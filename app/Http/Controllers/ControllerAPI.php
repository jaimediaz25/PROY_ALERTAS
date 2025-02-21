<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ControllerAPI extends Controller
{   
    //FUNCIONES LOGIN
    public function login(Request $request)
    {
        $response = Http::post('http://localhost:3001/api/login', $request->all());

        if ($response->successful()) {
            return view('home');
        }

        return redirect()->back()->with('error', $response->json()['error']);
    }

    public function register(Request $request)
    {
        $response = Http::post('http://localhost:3001/api/register', $request->all());

        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Registro exitoso');
        }

        return redirect()->back()->with('error', 'Error al registrar usuario');
    }

    public function resetPassword(Request $request)
    {
        $response = Http::post('http://localhost:3001/api/reset-password', $request->all());

        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Contraseña restablecida');
        }

        return redirect()->back()->with('error', 'Error al restablecer la contraseña');
    }

    // CRUD de usuarios
    public function index()
    {
        $response = Http::get('http://localhost:3001/api/users');

        if ($response->successful()) {
            $users = $response->json();
            return view('users.index', compact('users'));
        }

        return redirect()->back()->with('error', 'Error al obtener los usuarios');
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $response = Http::post('http://localhost:3001/api/users', $request->all());

        if ($response->successful()) {
            return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente');
        }

        return redirect()->back()->with('error', 'Error al crear usuario');
    }

    public function edit($id)
    {
        $response = Http::get("http://localhost:3001/api/users/{$id}");
        $user = $response->json();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $response = Http::put("http://localhost:3001/api/users/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente');
        }

        return redirect()->back()->with('error', 'Error al actualizar usuario');
    }

    public function destroy($id)
    {
        $response = Http::delete("http://localhost:3001/api/users/{$id}");

        if ($response->successful()) {
            return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente');
        }

        return redirect()->back()->with('error', 'Error al eliminar usuario');
    }
}
