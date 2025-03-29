<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos Generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .titulo1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-family: 'Amatic SC', cursive;
            font-weight: bold;
        }
        /* Barra de navegación fija */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background-color:rgb(220, 21, 21);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .titulo {
            text-align: center;
            color: #2e7d32;
            margin-top: 100px;
            font-size: 2.5rem;
            font-family: 'Amatic SC', cursive;
        }
        .navbar .logo img {
            height: 50px;
        }
        .navbar .menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .navbar a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        .navbar a:hover {
            color:rgb(255, 255, 255);
        }
        .btn {
            padding: 0.5rem 1.5rem;
            background-color: rgb(0, 0, 0);
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 50px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn:hover {
            background-color: rgb(70, 70, 70);
            transform: scale(1.1);
        }
        /* Espacio debajo de la barra de navegación */
        .navbar-space {
            height: 80px;
        }
        /* Sección de Contactos */
        .contact-section {
            padding: 1rem 2rem;
            background-color:rgb(255, 255, 255);
            text-align: center;
            color: #333;
        }
        .contact-section h2 {
            font-size: 2rem;
            color: #004d40;
            margin-bottom: 1rem;
        }
        .contact-section p {
            font-size: 1.1rem;
            line-height: 1.6;
        }
        .contact-details {
            margin-top: 2rem;
        }
        .contact-details p {
            font-size: 1.1rem;
            margin: 0.5rem 0;
        }
        /* Sección de Importancia del Reciclaje */
        .importance-section {
           
            background-color: #f1f8e9;
            text-align: center;
            color: #333;
        }
        .importance-section h2 {
            font-size: 2rem;
            color: #004d40;
            margin-bottom: 1rem;
        }
        .importance-section p {
            font-size: 1.1rem;
            line-height: 1.6;
            max-width: 800px;
            margin: auto;
        }
        /* Estilos de pie de página */
        .footer {
            background-color:rgb(220, 21, 21);
            color: #fff;
            padding: 40px 20px;
            text-align: center;
            margin-top: 110px;
        }
        .footer h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .footer p {
            font-size: 1em;
            margin: 5px 0 15px;
        }
        .footer .contact-button {
            display: inline-block;
            color: #1b5e20;
            background-color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .footer .contact-button:hover {
            background-color: #e0f2f1;
        }
        .footer .copyright {
            font-size: 0.9em;
            margin-top: 15px;
            color:rgb(255, 255, 255);
        }
        .footer .links a {
            color:rgb(255, 255, 255);
            text-decoration: none;
            margin: 0 8px;
        }
        .footer .links a:hover {
            text-decoration: underline;
        }
        /* Estilo para el video */
        .video-container {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }
        .video-container iframe {
            width: 100%;
            max-width: 700px;
            height: 400px;
            border: none;
        }
    </style>
</head>
<body>
    <!-- Espacio para la barra de navegación fija -->
    <div class="navbar-space"></div>

    <!-- Barra de Navegación -->
    <nav class="navbar">
        <div class="logo">
            <a href="#inicio"><img src="{{ url('img/Logotipo.png') }}" alt="Ecovibe" style="height: 60px;"></a>
        </div>
        <div class="menu">
        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
            <a class="nav-link" href="{{ route('recicladoras') }}">Alertas de Centros</a>
            <a class="empresas" href="{{ route('empresas') }}">Protocolos de Seguridad</a>
            <a class="centros" href="{{ route('centrosacopio') }}">Nosotros</a>
            <a class="contactos" href="{{ route('contactos') }}">Contactos</a>
            
        </div>
    </nav>

    <!-- Sección de Contactos -->
    <section class="contact-section">
        <h2 class="titulo1">Contactos</h2>
        <p>Si tienes preguntas, sugerencias o deseas colaborar con nosotros, ¡contáctanos!</p>
        <div class="contact-details">
            <p>📞 Teléfonos: +720 248 5834</p>
            <p>📞 Teléfonos: +55 2544 2435</p>
            <p>📧 Correo Electrónico: <a href="mailto:contacto@psycowax.com">contacto@psycowax.com</a></p>
            <p>🌐 Sitio Web: <a href="http://127.0.0.1:8000/home">www.psycowax.com</a></p>
        </div>
    </section>

    <!-- Sección de Video -->
    <section id="ecovibe" class="contact-section">
        <h2 class="titulo1">Tu haces la diferencia</h2>
        <div class="video-container">
           <br>
        </div>
    </section>

    <!-- Pie de página -->
    <div class="footer">
        <h2>¡ PsycoWax hace la diferencia !</h2>
        <p> GRACIAS POR TU PREFERENCIA</p>
        <div class="copyright">
            &copy; 2025 PsycoWax. Todos los derechos reservados.
        </div>
        <div class="links">
            <a href="#">Política de Privacidad</a> | 
            <a href="#">Términos de Servicio</a> | 
            <a href="#">Soporte</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>