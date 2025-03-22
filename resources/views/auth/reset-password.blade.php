<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 1100px;
        }

        .row {
            width: 100%;
            max-width: 1100px;
            height: 80vh; /* Ajusta la altura del contenedor */
        }

        .image-side {
            background: url('https://png.pngtree.com/png-vector/20190917/ourlarge/pngtree-lock-password-icon-vectors-png-image_1738050.jpg') no-repeat center center/cover;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            height: 100%;
            width: 50%;
        }

        .form-side {
            background-color: white;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            height: 100%;
            width: 50%;
        }

        h2 {
            color: #333;
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-control {
            border-radius: 25px;
            border: 1px solid #ccc;
            padding: 10px 20px;
            margin-bottom: 20px;
        }

        .btn {
            border-radius: 25px;
            padding: 8px 16px;
            margin: 5px;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
            color: white;
        }

        .btn-primary {
            background: #c40000;
            border: none;
            box-shadow: 0px 0px 10px rgba(255, 0, 0, 0.5);
        }

        .btn-primary:hover {
            background: #9e0000;
            box-shadow: 0px 0px 20px rgba(255, 0, 0, 0.8);
            transform: scale(1.05);
            color: black;
        }

        .alert {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
        }

        .alert-danger {
            background-color: #dc3545;
            color: white;
        }

        .text-center a {
            color: #007bff;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row align-items-center">
            <!-- Imagen -->
            <div class="col-md-6 image-side"></div>

            <!-- Formulario -->
            <div class="col-md-6 form-side">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <h2>Restablecer Contraseña</h2>

                <form action="{{ route('reset.post') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-600">Correo electrónico</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') border-danger @enderror" required autocomplete="email">
                        @error('email')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-600">Nueva Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') border-danger @enderror" required autocomplete="current-password">
                        @error('password')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Restablecer Contraseña
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="btn btn-link text-danger px-3 py-2 mb-2">¿Ya tienes cuenta? Inicia sesión</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
