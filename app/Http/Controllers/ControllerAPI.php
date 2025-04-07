<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Sensor;
use App\Models\Reading;
use App\Models\Alert;
use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Str;   



class ControllerAPI extends Controller
{   
    // CRUD de usuarios
    public function index(Request $request)
    {
        $perPage = 3; 
        $response = Http::get('http://localhost:3000/PsycoWax/v1/usersxx', [
            'search' => $request->search,
            'page' => $request->page,
            'perPage' => $perPage 
        ]);
        if (!$response->successful()) {
            Log::error('Error API Users: ' . $response->body());
            return redirect()->back()->with('error', 'Error al obtener usuarios');
        }
        $apiResponse = $response->json();
        if (!isset($apiResponse['data'], $apiResponse['total'])) {
            Log::error('Respuesta inválida: ' . json_encode($apiResponse));
            return redirect()->back()->with('error', 'Error en formato de datos');
        }
        $users = new LengthAwarePaginator(
            $apiResponse['data'],
            $apiResponse['total'],
            $perPage, 
            $apiResponse['currentPage'] ?? 1,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query()
            ]
        );
        return view('users.index', compact('users'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'edad' => 'required|integer|min:1|max:120',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'rol' => 'required|in:usuario,admin,bombero'
        ]);
        try {
            $response = Http::timeout(10)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('http://localhost:3000/PsycoWax/v1/usersxx', $validated);
            if ($response->successful()) {
                return redirect()->route('users.index')
                    ->with('success', 'Usuario registrado exitosamente');
            }
            $errorData = $response->json();
            return back()
                ->withInput()
                ->with('error', $errorData['error'] ?? 'Error desconocido');
        } catch (\Exception $e) {
            Log::error('Error en store: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Error interno: ' . $e->getMessage());
        }
    }


    public function create()
    {
        return view('users.create');
    }

    public function edit($id)
    {
        if (!Str::isUuid($id) && !preg_match('/^[a-f\d]{24}$/i', $id)) {
            abort(404);
        }
        $response = Http::get("http://localhost:3000/PsycoWax/v1/usersxx/{$id}");
        if (!$response->successful() || !isset($response->json()['_id'])) {
            return redirect()->route('users.index')->with('error', 'Usuario no encontrado');
        }
        $user = $response->json();
        return view('users.edit', compact('user'));
    }


    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255', 
        'edad' => 'required|integer|min:18',
        'email' => 'required|email',
        'rol' => 'required|in:usuario,admin',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
    ]);

    $data = $validated;

    if ($request->hasFile('imagen')) {
        try {
            $image = $request->file('imagen');
            
            // Verificar tipo MIME real
            $mimeType = $image->getMimeType();
            $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
            
            if (!in_array($mimeType, $allowedMimes)) {
                return back()->withInput()->with('error', 'Formato de imagen no válido');
            }

            // Convertir a base64
            $base64 = base64_encode(file_get_contents($image));
            $data['imagen'] = "data:$mimeType;base64,$base64";
            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error procesando la imagen: '.$e->getMessage());
        }
    } else {
        unset($data['imagen']);
    }

    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ])
    ->timeout(90)
    ->put("http://localhost:3000/PsycoWax/v1/usersxx/{$id}", $data);

    if ($response->successful()) {
        if (session('user._id') === $id) {
            $updatedUser = Http::get("http://localhost:3000/PsycoWax/v1/usersxx/{$id}")->json();
            session()->put('user', $updatedUser);
        }
        return redirect()->route('users.index')->with('success', 'Usuario actualizado');
    }

    $error = $response->json()['error'] ?? 'Error desconocido';
    $statusCode = $response->status();

    return back()->withInput()->with('error', "Error $statusCode: ".substr($error, 0, 200));
}


    public function destroy($id)
    {
        if (!preg_match('/^[a-f\d]{24}$/i', $id)) {
            return back()->with('error', 'ID inválido');
        }
        $response = Http::delete("http://localhost:3000/PsycoWax/v1/usersxx/{$id}");
        if ($response->successful()) {
            return redirect()->route('users.index')->with('success', 'Usuario eliminado');
        }
        $error = $response->json()['error'] ?? 'Error al eliminar';
        return back()->with('error', $error);
    }


    public function exportPdf(Request $request)
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/usersxx', [
            'search' => $request->search,
            'perPage' => 1000 
        ]);
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener usuarios');
        }
        $apiResponse = $response->json();
        $users = $apiResponse['data'] ?? [];
        $searchTerm = $request->search ?? 'todos';

        $html = view('users.pdf', compact('users', 'searchTerm'))->render();
        return response()->make($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="usuarios_'.$searchTerm.'_'.now()->format('Ymd').'.html"');
    }


    public function exportExcel(Request $request)
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/usersxx', [
            'search' => $request->search
        ]);
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener usuarios desde la API');
        }
        $users = $response->json()['data'] ?? [];
        $csvData = "\xEF\xBB\xBF"; 
        $csvData .= "ID,Nombre,Apellidos,Email,Edad,Rol\n"; 
        foreach ($users as $user) {
            $csvData .= sprintf(
                '"%s","%s","%s","%s","%s","%s"' . "\n",
                $user['_id'] ?? '',      
                $user['nombre'] ?? '',
                $user['apellidos'] ?? '',
                $user['email'] ?? '',
                $user['edad'] ?? '',
                $user['rol'] ?? ''
            );
        }
        $filename = 'usuarios_' . ($request->search ? 'filtrados' : 'completos') . '_' . date('Ymd') . '.csv';
        return response()->make($csvData, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }


    public function showGraph()
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/usersxx/stats/monthly');
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener datos de la API');
        }
        $stats = $response->json();
        $months = [];
        $userCounts = [];
        $updatedCounts = [];
        foreach ($stats as $stat) {
            $date = \Carbon\Carbon::createFromDate($stat['year'], $stat['month'], 1);
            $months[] = $date->isoFormat('MMM YYYY');
            $userCounts[] = $stat['total'];
            $updatedCounts[] = $stat['updated'];
        }
        return view('users.grafica', [
            'months' => $months,
            'userCounts' => $userCounts,
            'updatedCounts' => $updatedCounts
        ]);
    }


    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $file = $request->file('file');
            $path = $file->getRealPath();
            $rows = array_map('str_getcsv', file($path));
            $header = array_shift($rows); 
            
            $importedCount = 0;
            $errors = [];
            $columnMap = [
                0 => 'nombre',
                1 => 'apellidos', 
                2 => 'edad',
                3 => 'email',
                4 => 'password',
                5 => 'rol'
            ];
            foreach ($rows as $index => $row) {
                try {
                    if (count($row) < 6) {
                        $errors[] = "Fila ".($index + 1).": Formato inválido";
                        continue;
                    }
                    $userData = [];
                    foreach ($columnMap as $col => $field) {
                        $userData[$field] = trim($row[$col]);
                    }
                    $email = strtolower($userData['email']);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Fila ".($index + 1).": Email inválido";
                        continue;
                    }
                    if (!is_numeric($userData['edad']) || $userData['edad'] < 1) {
                        $errors[] = "Fila ".($index + 1).": Edad inválida";
                        continue;
                    }
                    $checkResponse = Http::get('http://localhost:3000/PsycoWax/v1/usersxx/check-email', [
                        'email' => $email 
                    ]);
                    if (!$checkResponse->successful()) {
                        $errors[] = "Fila ".($index + 1).": Error verificando email";
                        continue;
                    }
                    if ($checkResponse->json()['exists']) {
                        $errors[] = "Fila ".($index + 1).": Email ya registrado";
                        continue;
                    }
                    $userData['password'] = bcrypt($userData['password']);
                    $apiResponse = Http::post('http://localhost:3000/PsycoWax/v1/usersxx', $userData);
                    if (!$apiResponse->successful()) {
                        $errorData = $apiResponse->json();
                        $errors[] = "Fila ".($index + 1).": ".($errorData['error'] ?? 'Error API');
                        continue;
                    }
                    $importedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Fila ".($index + 1).": Error - ".$e->getMessage();
                }
            }
            $result = "Importados: $importedCount";
            if (count($errors) > 0) $result .= " | Errores: ".count($errors);
            return redirect()->back()
                ->with('import_result', $result)
                ->with('import_errors', $errors);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error general: '.$e->getMessage());
        }
    }








    //CRUD de sensors
    public function indexsen(Request $request)
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/sensorsxx');
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener los sensores.');
        }
        $sensors = collect($response->json());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search);
            $sensors = $sensors->filter(function ($sensor) use ($search) {
                return str_contains(strtolower($sensor['tipo']), $search) ||
                    str_contains(strtolower($sensor['ubicacion']), $search);
            })->values();
        }
        $perPage = 3;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $sensors->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $sensors = new LengthAwarePaginator($currentItems, $sensors->count(), $perPage, $currentPage, [
            'path' => url()->current(),
            'query' => $request->query(),
        ]);
        return view('sensors.index', compact('sensors'));
    }


    public function createsen()
    {
        return view('sensors.create');
    }


    public function storesen(Request $request)
    {
        $response = Http::post('http://localhost:3000/PsycoWax/v1/sensorsxx', $request->all());
        if ($response->successful()) {
            return redirect()->route('sensors.index')->with('success', 'Sensor creado exitosamente');
        }
        return redirect()->back()->with('error', 'Error al crear sensor');
    }


    public function editsen($id)
    {
        $response = Http::get("http://localhost:3000/PsycoWax/v1/sensorsxx/{$id}");
        if ($response->successful()) {
            $sensor = $response->json();
            return view('sensors.edit', compact('sensor'));
        }
        return redirect()->back()->with('error', 'Error al obtener el sensor');
    }


    public function updatesen(Request $request, $id)
    {
        $response = Http::put("http://localhost:3000/PsycoWax/v1/sensorsxx/{$id}", $request->all());
        if ($response->successful()) {
            return redirect()->route($request->input('redirect_to'))->with('success', 'Sensor actualizado correctamente');
        }
        return redirect()->back()->with('error', 'Error al actualizar sensor');
    }


    public function destroysen($id)
    {
        $response = Http::delete("http://localhost:3000/PsycoWax/v1/sensorsxx/{$id}");
        if ($response->successful()) {
            return redirect()->route('sensors.index')->with('success', 'Sensor eliminado correctamente');
            
        }
        return redirect()->back()->with('error', 'Error al eliminar sensor');
    }


    public function exportPdfsen(Request $request) 
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/sensorsxx');
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener los sensores.');
        }
        $sensors = collect($response->json());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search);
            $sensors = $sensors->filter(function ($sensor) use ($search) {
                return str_contains(strtolower($sensor['tipo']), $search) ||
                    str_contains(strtolower($sensor['ubicacion']), $search);
            })->values();
        }
        $pdf = Pdf::loadView('sensors.pdf', compact('sensors'));
        return $pdf->download('sensores_filtrados.pdf');
    }


    public function exportExcelsen(Request $request)
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/sensorsxx'); 
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener los sensores desde la API.');
        }
        $sensors = collect($response->json());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search);
            $sensors = $sensors->filter(function ($sensor) use ($search) {
                return str_contains(strtolower($sensor['tipo']), $search) ||
                    str_contains(strtolower($sensor['ubicacion']), $search) ||
                    str_contains(strtolower($sensor['activo']), $search);
            });
        }
        $csvData = "ID,ID Usuario,Tipo,Ubicación,Estado\n";

        foreach ($sensors as $sensor) {
            $csvData .= "{$sensor['_id']},{$sensor['user_id']},{$sensor['tipo']},{$sensor['ubicacion']},{$sensor['activo']}\n";
        }
        return response($csvData, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="sensores.csv"');
    }

    
    public function showGraphsen()
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/sensorsxx/stats/monthly');
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener datos de sensores');
        }
        $stats = $response->json();
        $months = [];
        $sensorCounts = [];
        $activeCounts = [];
        $updatedCounts = [];
        foreach ($stats as $stat) {
            $date = \Carbon\Carbon::createFromDate($stat['year'], $stat['month'], 1);
            $months[] = $date->isoFormat('MMM YYYY');
            $sensorCounts[] = $stat['total'];
            $activeCounts[] = $stat['activos'];
            $updatedCounts[] = $stat['actualizados'];
        }
        return view('sensors.grafica', [
            'months' => $months,
            'sensorCounts' => $sensorCounts,
            'activeCounts' => $activeCounts,
            'updatedCounts' => $updatedCounts
        ]);
    }

    
    public function importExcelsen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $file = $request->file('file');
            $path = $file->getRealPath();
            $rows = array_map('str_getcsv', file($path));
            $header = array_shift($rows); 
            $importedCount = 0;
            $errors = [];
            $columnMap = [
                0 => 'user_id',
                1 => 'ubicacion',
                2 => 'tipo', 
                3 => 'activo'
            ];
            foreach ($rows as $index => $row) {
                try {
                    if (count($row) < 4) {
                        $errors[] = "Fila ".($index + 1).": Formato inválido - Debe tener 4 columnas";
                        continue;
                    }
                    $sensorData = [];
                    foreach ($columnMap as $col => $field) {
                        $sensorData[$field] = trim($row[$col]);
                    }
                    $camposRequeridos = ['user_id', 'ubicacion', 'tipo'];
                    foreach ($camposRequeridos as $campo) {
                        if (empty($sensorData[$campo])) {
                            $errors[] = "Fila ".($index + 1).": Campo requerido vacío ($campo)";
                            continue 2; 
                        }
                    }
                    if (!preg_match('/^[a-f\d]{24}$/i', $sensorData['user_id'])) {
                        $errors[] = "Fila ".($index + 1).": ID de usuario inválido";
                        continue;
                    }
                    $valorActivo = strtolower($sensorData['activo']);
                    if (!in_array($valorActivo, ['0', '1', 'true', 'false'])) {
                        $errors[] = "Fila ".($index + 1).": Valor activo inválido";
                        continue;
                    }
                    $sensorData['activo'] = (bool) intval($valorActivo);
                    $checkResponse = Http::get('http://localhost:3000/PsycoWax/v1/sensorsxx/check', [
                        'ubicacion' => $sensorData['ubicacion'],
                        'tipo' => $sensorData['tipo']
                    ]);
                    if (!$checkResponse->successful()) {
                        $errors[] = "Fila ".($index + 1).": Error de verificación en API";
                        continue;
                    }
                    if ($checkResponse->json()['exists']) {
                        $errors[] = "Fila ".($index + 1).": Sensor ya existe para este usuario";
                        continue;
                    }
                    $apiResponse = Http::post('http://localhost:3000/PsycoWax/v1/sensorsxx', $sensorData);
                    if (!$apiResponse->successful()) {
                        $errorData = $apiResponse->json();
                        $errors[] = "Fila ".($index + 1).": ".($errorData['error'] ?? 'Error desconocido');
                        continue;
                    }
                    $importedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Fila ".($index + 1).": Error - ".$e->getMessage();
                }
            }
            $result = "Importación completa: $importedCount sensores";
            if (count($errors)) {
                $result .= " | Errores: ".count($errors)." filas con problemas";
            }
            return redirect()->back()
                ->with('import_result', $result)
                ->with('import_errors', $errors);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error general: '.$e->getMessage());
        }
    }







    //CRUD de readings
    public function indexre(Request $request)
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/readingsxx');
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener las lecturas.');
        }
        $readings = collect($response->json());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search);
            $readings = $readings->filter(function ($reading) use ($search) {
                return str_contains(strtolower($reading['sensor_id']), $search) ||
                    str_contains(strtolower($reading['valor']), $search);
            })->values();
        }
        $perPage = 10; 
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $readings->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $readings = new LengthAwarePaginator($currentItems, $readings->count(), $perPage, $currentPage, [
            'path' => url()->current(),
            'query' => $request->query(),
        ]);
        return view('readings.index', compact('readings'));
    }


    public function createre()
    {
        return view('readings.create');
    }


    public function storere(Request $request)
    {
        $response = Http::post('http://localhost:3000/PsycoWax/v1/readingsxx', $request->all());
        if ($response->successful()) {
            return redirect()->route('readings.index')->with('success', 'Reading creado exitosamente');
        }
        return redirect()->back()->with('error', 'Error al crear el reading');
    }


    public function editre($id)
    {
        $response = Http::get("http://localhost:3000/PsycoWax/v1/readingsxx/{$id}");
        if ($response->successful()) {
            $reading = $response->json();
            return view('readings.edit', compact('reading'));
        }
        return redirect()->back()->with('error', 'Error al obtener el reading');
    }


    public function updatere(Request $request, $id)
    {
        $response = Http::put("http://localhost:3000/PsycoWax/v1/readingsxx/{$id}", $request->all());
        if ($response->successful()) {
            return redirect()->route('readings.index')->with('success', 'Reading actualizado correctamente');
        }
        return redirect()->back()->with('error', 'Error al actualizar el reading');
    }


    public function destroyre($id)
    {
        $response = Http::delete("http://localhost:3000/PsycoWax/v1/readingsxx/{$id}");
        if ($response->successful()) {
            return redirect()->route('readings.index')->with('success', 'Reading eliminado correctamente');
        }
        return redirect()->back()->with('error', 'Error al eliminar el reading');
    }


    public function exportPdfre(Request $request)
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/readingsxx'); 
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener las lecturas.');
        }
        $readings = collect($response->json());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search);
            $readings = $readings->filter(function ($reading) use ($search) {
                return str_contains(strtolower($reading['sensor_id']), $search) ||
                    str_contains(strtolower($reading['valor']), $search) ||
                    str_contains(strtolower($reading['created_at']), $search);
            })->values();
        }
        $pdf = Pdf::loadView('readings.pdf', compact('readings'));
        return $pdf->download('lecturas_filtradas.pdf');
    }


    public function exportExcelre(Request $request)
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/readingsxx'); 
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener las lecturas.');
        }
        $readings = collect($response->json());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search);
            $readings = $readings->filter(function ($reading) use ($search) {
                return str_contains(strtolower($reading['sensor_id']), $search) ||
                    str_contains(strtolower($reading['valor']), $search) ||
                    str_contains(strtolower($reading['created_at']), $search);
            });
        }
        $csvData = "Sensor ID,Valor,Fecha\n";
        foreach ($readings as $reading) {
            $csvData .= "{$reading['sensor_id']},{$reading['valor']},{$reading['created_at']}\n";
        }
        return response($csvData, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="lecturas.csv"');
    }

    
    public function showGraphre()
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/readingsxx/stats/monthly');
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener datos de lecturas');
        }
        $stats = $response->json();
        $months = [];
        $totalLecturas = [];
        $promedioValores = [];
        $maximos = [];
        $minimos = [];
        foreach ($stats as $stat) {
            $date = \Carbon\Carbon::createFromDate($stat['year'], $stat['month'], 1);
            $months[] = $date->isoFormat('MMM YYYY');
            $totalLecturas[] = $stat['total'];
            $promedioValores[] = $stat['promedio'];
            $maximos[] = $stat['maximo'];
            $minimos[] = $stat['minimo'];
        }
        return view('readings.grafica', [
            'months' => $months,
            'totalLecturas' => $totalLecturas,
            'promedioValores' => $promedioValores,
            'maximos' => $maximos,
            'minimos' => $minimos
        ]);
    }


    public function importExcelre(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $file = $request->file('file');
            $path = $file->getRealPath();
            $rows = array_map('str_getcsv', file($path));
            $header = array_shift($rows);
            $importedCount = 0;
            $errors = [];
            foreach ($rows as $index => $row) {
                try {
                    if (count($row) < 2) {
                        $errors[] = "Fila ".($index + 1).": Formato inválido, se requieren 2 columnas";
                        continue;
                    }
                    $sensor_id = trim($row[0]);
                    $valor = trim($row[1]);
                    if (empty($sensor_id) || empty($valor)) {
                        $errors[] = "Fila ".($index + 1).": Todos los campos son obligatorios";
                        continue;
                    }
                    if (!is_numeric($valor)) {
                        $errors[] = "Fila ".($index + 1).": Valor debe ser numérico";
                        continue;
                    }
                    
                    $checkSensor = Http::get("http://localhost:3000/PsycoWax/v1/sensorsxx/{$sensor_id}");
                    if (!$checkSensor->successful()) {
                        $errors[] = "Fila ".($index + 1).": Error verificando sensor";
                        continue;
                    }
                    if ($checkSensor->status() === 404) {
                        $errors[] = "Fila ".($index + 1).": Sensor no existe";
                        continue;
                    }
                    $response = Http::post('http://localhost:3000/PsycoWax/v1/readingsxx', [
                        'sensor_id' => $sensor_id,
                        'valor' => $valor
                    ]);
                    if (!$response->successful()) {
                        $errorData = $response->json();
                        $errors[] = "Fila ".($index + 1).": ".($errorData['error'] ?? 'Error API');
                        continue;
                    }
                    $importedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Fila ".($index + 1).": Error - ".$e->getMessage();
                }
            }
            $result = "Lecturas importadas: $importedCount";
            if (count($errors) > 0) $result .= " | Errores: ".count($errors);
            return redirect()->back()
                ->with('import_result', $result)
                ->with('import_errors', $errors);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error general: '.$e->getMessage());
        }
    }

    






    //CRUD de alerts
    public function indexalerts(Request $request)
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/alertsxx');
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener las alertas.');
        }
        $alerts = collect($response->json());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search);
            $alerts = $alerts->filter(function ($alert) use ($search) {
                return str_contains(strtolower($alert['sensor_id']), $search) ||
                    str_contains(strtolower($alert['tipo_alerta']), $search);
            })->values();
        }
        $perPage = 3;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $alerts->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $alerts = new LengthAwarePaginator($currentItems, $alerts->count(), $perPage, $currentPage, [
            'path' => url()->current(),
            'query' => $request->query(),
        ]);
        return view('alerts.index', compact('alerts'));
    }


    public function createAlert()
    {
        return view('alerts.create');
    }


    public function storeAlert(Request $request)
    {
        $response = Http::post('http://localhost:3000/PsycoWax/v1/alertsxx', $request->all());
        if ($response->successful()) {
            return redirect()->route('alerts.index')->with('success', 'Alerta creada correctamente');
        }
        return redirect()->back()->with('error', 'Error al crear alerta');
    }


    public function editAlert($id)
    {
        $response = Http::get("http://localhost:3000/PsycoWax/v1/alertsxx/{$id}");
        if ($response->successful()) {
            $alert = $response->json();
            return view('alerts.edit', compact('alert'));
        }
        return redirect()->back()->with('error', 'Error al obtener la alerta');
    }


    public function updateAlert(Request $request, $id)
    {
        $response = Http::put("http://localhost:3000/PsycoWax/v1/alertsxx/{$id}", $request->all());
        if ($response->successful()) {
            return redirect()->route('alerts.index')->with('success', 'Alerta actualizada correctamente');
        }
        return redirect()->back()->with('error', 'Error al actualizar alerta');
    }


    public function destroyAlert($id)
    {
        $response = Http::delete("http://localhost:3000/PsycoWax/v1/alertsxx/{$id}");
        if ($response->successful()) {
            return redirect()->route('alerts.index')->with('success', 'Alerta eliminada correctamente');
        }
        return redirect()->back()->with('error', 'Error al eliminar alerta');
    }


    public function exportPdfAlert(Request $request)
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/alertsxx');
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener las alertas.');
        }
        $alerts = collect($response->json());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search);
            $alerts = $alerts->filter(function ($alert) use ($search) {
                return str_contains(strtolower($alert['_id']), $search) ||
                    str_contains(strtolower($alert['sensor_id']), $search) ||
                    
                    str_contains(strtolower($alert['tipo_alerta']), $search) ||
                    str_contains(strtolower($alert['mensaje']), $search);
            })->values();
        }
        $pdf = Pdf::loadView('alerts.pdf', compact('alerts'));
        return $pdf->download('alertas_filtradas.pdf');
    }


    public function exportExcelAlert(Request $request)
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/alertsxx');
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener las alertas.');
        }
        $alerts = collect($response->json());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search);
            $alerts = $alerts->filter(function ($alert) use ($search) {
                return str_contains(strtolower($alert['_id']), $search) ||
                    str_contains(strtolower($alert['sensor_id']), $search) ||
                    str_contains(strtolower($alert['tipo_alerta']), $search) ||
                    str_contains(strtolower($alert['mensaje']), $search);
            });
        }
        $csvData = "ID Alerta, ID Sensor, Tipo, Mensaje\n";
        foreach ($alerts as $alert) {
            $csvData .= "{$alert['_id']},{$alert['sensor_id']},{$alert['tipo_alerta']},{$alert['mensaje']}\n";
        }
        return response($csvData, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="alertas.csv"');
    }


    public function showGraphAlert()
    {
        $response = Http::get('http://localhost:3000/PsycoWax/v1/alertsxx/stats/monthly');
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Error al obtener datos de alertas');
        }
        $stats = $response->json();
        $months = [];
        $totalAlertas = [];
        $atendidasCounts = [];
        $tiposData = [];
        foreach ($stats as $stat) {
            $date = \Carbon\Carbon::createFromDate($stat['year'], $stat['month'], 1);
            $months[] = $date->isoFormat('MMM YYYY');
            $totalAlertas[] = $stat['total'];
            $atendidasCounts[] = $stat['atendidas'];
            foreach ($stat['tipos'] as $tipo => $cantidad) {
                if (!isset($tiposData[$tipo])) {
                    $tiposData[$tipo] = [];
                }
                $tiposData[$tipo][] = $cantidad;
            }
        }
        return view('alerts.grafica', [
            'months' => $months,
            'totalAlertas' => $totalAlertas,
            'atendidasCounts' => $atendidasCounts,
            'tiposData' => $tiposData
        ]);
    }


    public function importExcelAlert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $file = $request->file('file');
            $path = $file->getRealPath();
            $rows = array_map('str_getcsv', file($path));
            $header = array_shift($rows);
            $importedCount = 0;
            $errors = [];
            $columnMap = [
                0 => 'sensor_id',
                1 => 'user_id', 
                2 => 'tipo_alerta',
                3 => 'mensaje',
                4 => 'atendida',
                5 => 'generado_en'
            ];
            foreach ($rows as $index => $row) {
                try {
                    if (count($row) < 6) {
                        $errors[] = "Fila ".($index + 1).": Formato inválido";
                        continue;
                    }
                    $alertData = [];
                    foreach ($columnMap as $col => $field) {
                        $alertData[$field] = trim($row[$col]);
                    }
                    if (!preg_match('/^[a-f\d]{24}$/i', $alertData['sensor_id']) || 
                        !preg_match('/^[a-f\d]{24}$/i', $alertData['user_id'])) {
                        $errors[] = "Fila ".($index + 1).": ID inválido";
                        continue;
                    }
                    $sensorCheck = Http::get("http://localhost:3000/PsycoWax/v1/sensorsxx/{$alertData['sensor_id']}");
                    $userCheck = Http::get("http://localhost:3000/PsycoWax/v1/usersxx/{$alertData['user_id']}");
                    if (!$sensorCheck->successful()) {
                        $errors[] = "Fila ".($index + 1).": Sensor no encontrado";
                        continue;
                    }
                    if (!$userCheck->successful()) {
                        $errors[] = "Fila ".($index + 1).": Usuario no encontrado";
                        continue;
                    }
                    if (!in_array($alertData['tipo_alerta'], ['ALTA', 'MEDIA', 'BAJA'])) {
                        $errors[] = "Fila ".($index + 1).": Tipo de alerta inválido";
                        continue;
                    }
                    $alertData['atendida'] = (bool)$alertData['atendida'];
                    $alertData['generado_en'] = \Carbon\Carbon::parse($alertData['generado_en'])->toIso8601String();
                    $checkResponse = Http::get('http://localhost:3000/PsycoWax/v1/alertsxx/check', [
                        'sensor_id' => $alertData['sensor_id'],
                        'user_id' => $alertData['user_id'],
                        'generado_en' => $alertData['generado_en']
                    ]);
                    if ($checkResponse->successful() && $checkResponse->json()['exists']) {
                        $errors[] = "Fila ".($index + 1).": Alerta duplicada";
                        continue;
                    }
                    $apiResponse = Http::post('http://localhost:3000/PsycoWax/v1/alertsxx', $alertData);
                    if (!$apiResponse->successful()) {
                        $errorData = $apiResponse->json();
                        $errors[] = "Fila ".($index + 1).": ".($errorData['error'] ?? 'Error API');
                        continue;
                    }
                    $importedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Fila ".($index + 1).": Error - ".$e->getMessage();
                }
            }
            $result = "Importados: $importedCount";
            if (count($errors) > 0) $result .= " | Errores: ".count($errors);
            return redirect()->back()
                ->with('import_result', $result)
                ->with('import_errors', $errors);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error general: '.$e->getMessage());
        }
    }
}