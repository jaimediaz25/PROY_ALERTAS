<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Lectura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            display: flex;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            display: flex;
            width: 80%;
            max-width: 1200px;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        }

        .form-container .image {
            width: 50%;
            background-image: url('https://thumbs.dreamstime.com/b/icono-de-lectura-en-estilo-l%C3%ADnea-para-cualquier-proyecto-que-se-utilice-la-presentaci%C3%B3n-aplicaciones-m%C3%B3viles-del-sitio-web-193902596.jpg'); /* Reemplaza con la imagen que desees */
            background-size: cover;
            background-position: center;
        }

        .form-container .form-content {
            width: 50%;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h2 {
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input, button {
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: 2px solid #ccc;
            font-size: 1rem;
            font-weight: 500;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus {
            border-color: #c40000;
            outline: none;
            box-shadow: 0 0 5px rgba(196, 0, 0, 0.5);
        }

        .btn {
            background-color: #c40000;
            color: black;
            font-size: 1.1rem;
            font-weight: bold;
            border: none;
            cursor: pointer;
            box-shadow: 0px 4px 10px rgba(196, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #9b0000;
            transform: scale(1.05);
            box-shadow: 0px 6px 15px rgba(196, 0, 0, 0.5);
            color: white;
        }

        .back-btn {
            background-color: #f39c12;
            color: black;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
            padding: 12px 25px;
            border-radius: 7px;
            transition: all 0.3s ease;
            box-shadow: 0px 4px 15px rgba(243, 156, 18, 0.3);
        }

        .back-btn:hover {
            background-color: #e67e22;
            box-shadow: 0px 6px 25px rgba(243, 156, 18, 0.5);
            transform: scale(1.05);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="image"></div>
            <div class="form-content">
                <h2>Crear Nueva Lectura</h2>
                <form action="{{ route('readings.store') }}" method="POST">
                    @csrf
                    <label for="sensor_id">Sensor ID:</label>
                    <input type="text" name="sensor_id" id="sensor_id" value="{{ old('sensor_id') }}" required>
                    
                    <label for="valor">Valor:</label>
                    <input type="number" name="valor" id="valor" value="{{ old('valor') }}" required>
                    
                    <button type="submit" class="btn">Guardar</button>
                </form>
                <a href="{{ url()->previous() }}" class="back-btn">Volver</a>
            </div>
        </div>
    </div>
</body>
</html>