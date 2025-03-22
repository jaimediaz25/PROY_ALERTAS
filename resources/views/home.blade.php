<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido</title>
    <!-- Agregar estilos básicos -->
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .nav-links { margin: 20px 0; }
        .nav-links a { 
            display: block; 
            margin: 10px 0; 
            color: #1a0dab; 
            text-decoration: none;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    @if(session('user'))
        <h2>Bienvenido, {{ session('user.nombre') }}</h2>
        <p>Tu rol es: {{ session('user.rol') }}</p>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Cerrar sesión</button>
        </form>

        <div class="nav-links">
            @if(session('user.rol') === 'admin')
                <a href="{{ route('users.index') }}">Ver Usuarios</a>
                <a href="{{ route('sensors.index') }}">Ver Sensores</a>
                <a href="{{ route('readings.index') }}">Ver Mediciones</a>
                <a href="{{ route('alerts.index') }}">Ver Alertas</a>
            @endif
            
           
            
        </div>
    @else
        <script>window.location = "{{ route('login') }}";</script>
    @endif
</body>
</html>