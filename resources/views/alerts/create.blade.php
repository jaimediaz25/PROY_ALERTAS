<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Alerta</title>
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
            background-image: url('https://static.vecteezy.com/system/resources/previews/002/573/408/large_2x/alert-caution-signal-line-style-icon-free-vector.jpg'); /* Reemplaza con la imagen que desees */
            background-size: cover;
            background-position: center;
            margin: 30px;
            
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

        input, textarea, select, button {
            width: 100%;
            padding: 15px;
            
            border-radius: 10px;
            border: 2px solid #ccc;
            font-size: 1rem;
            font-weight: 500;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus, textarea:focus, select:focus {
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
            margin-top: 10px;
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
                <h2>Crear Alerta</h2>
                <form action="{{ route('alerts.store') }}" method="POST">
                    @csrf
                    <label for="sensor_id">Sensor</label>
                    <input type="text" name="sensor_id" required>

                    <label for="user_id">Usuario (opcional)</label>
                    <input type="text" name="user_id">

                    <label for="tipo_alerta">Tipo de Alerta</label>
                    <input type="text" name="tipo_alerta" required>

                    <label for="mensaje">Mensaje</label>
                    <textarea name="mensaje" rows="2" required></textarea>

                    <label for="atendida">¿Atendida?</label>
                    <select name="atendida">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>

                    <button type="submit" class="btn">Guardar</button>
                </form>
                <a href="{{ url()->previous() }}" class="back-btn">Volver</a>
            </div>
        </div>
    </div>
</body>
</html>
