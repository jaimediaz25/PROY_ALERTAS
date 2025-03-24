<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros</title>
    <style>
        /* Estilos Generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f5f5f5;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            text-align: center; /* Centramos el título */
        }
        .subtitle {
            color: #666;
            margin-bottom: 20px;
            text-align: center;
        }
        .description {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 20px;
            text-align: justify;
        }
        .button {
            background-color: rgb(220, 21, 21);
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            font-weight: bold;
        }
        .categories, .contact-info, .map, .schedule {
            margin-bottom: 20px;
        }
        
        .map {
            width: 100%;
        }
        .map iframe {
            width: 100%;
            height: 400px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .icon {
            margin-right: 5px;
        }
        .contact-info div {
            display: flex;
            align-items: center;
        }
        .salida {
            background-color:rgb(220, 21, 21);
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            font-weight: bold;
        }
        /* Estilos de pie de página */
        .footer {
            background-color: rgb(220, 21, 21);
            color: #fff;
            padding: 30px 20px;
            text-align: center;
            margin-top: 40px;
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
                color:rgb(255, 255, 255);
                background-color: #000000;
                padding: 10px 20px;
                border-radius: 4px;
                font-weight: bold;
                text-decoration: none;
                transition: background-color 0.3s;
            }

            .footer .contact-button:hover {
                background-color:rgb(70, 70, 70);
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

        /* Barra de navegación fija */
        .navbar {
            position: fixed;
            top: 0;
            width: 97%;
            background-color: rgb(220, 21, 21);
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
            color:rgb(227, 72, 72);
            margin-top: 100px;
            font-size: 2.5rem;
            font-family: 'Amatic SC', cursive;
        }
        .navbar .logo img {
            height: 50px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .navbar .logo img:hover {
            transform: scale(1.1);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
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
            color:rgb(230, 200, 200);
        }
        .btn {
            padding: 0.5rem 1.5rem;
            background-color:rgb(0, 0, 0);
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 50px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn:hover {
            background-color:rgb(125, 46, 46);
            transform: scale(1.1);
        }
        /* Espacio debajo de la barra de navegación */
        .navbar-space {
            height: 80px;
        }
    </style>
</head>
<body>

<!-- Espacio reservado para que la barra de navegación no cubra el contenido -->
<div class="navbar-space"></div>

<nav class="navbar">
    <div class="logo">
        <a href="home"><img src="img/Logotipo.png" alt="Psycowax" style="height: 60px;"></a> 
    </div>
    <div class="menu">
        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
            <a class="nav-link" href="{{ route('recicladoras') }}">Alertas de Centros</a>
            <a class="empresas" href="{{ route('empresas') }}">Protocolos de Seguridad</a>
            <a class="centros" href="{{ route('centrosacopio') }}">Nosotros</a>
           
        </div>
</nav>

<div class="container">
    <div class="title">Ubicación de Psycowax</div>
    <div class="subtitle">Nuestra Empresa</div>
    <div class="description">
        En Psycowax, nos especializamos en la prevención y control de incendios industriales, ofreciendo soluciones innovadoras para la seguridad y protección de empresas. Encuentra nuestra ubicación y conoce más sobre nuestros servicios.
    </div>
    <div class="categories">
        <h3>Áreas en las que Brindamos Soluciones:</h3>
        <ul>
            <li>🔥 Prevención de incendios</li>
            <li>🔥 Equipos de seguridad</li>
            <li>🔥 Capacitación y asesoría</li>
            <li>🔥 Sistemas de detección y control</li>
            <li>🔥 Protección contra riesgos industriales</li>
        </ul>
    </div>
    <div class="map">
        <strong>📍 Ubicación de Psycowax:</strong>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3764.663104263615!2d-99.47859472532849!3d19.34041994361938!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d20a1464000001%3A0x1c254456341588a0!2sUniversidad%20Tecnol%C3%B3gica%20del%20Valle%20de%20Toluca!5e0!3m2!1ses-419!2smx!4v1741199931675!5m2!1ses-419!2smx" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <div class="contact-info">
        "La seguridad es nuestra prioridad. Protege tu empresa con las mejores soluciones en prevención de incendios."
    </div>
    <div>
        <a class="salida" href="{{ route('recicladoras') }}">Regresar</a>   
       
    </div>
</div>

<!-- Pie de página -->
<div class="footer">
    <h2>¡Comprometidos con la seguridad industrial!</h2>
    <p>Si deseas más información sobre nuestros servicios o tienes alguna consulta, no dudes en contactarnos.</p>
    <a href="{{ route('contactos') }}" class="contact-button">CONTACTOS</a>
    <div class="copyright">
        &copy; 2025 Psycowax. Todos los derechos reservados.
    </div>
    <div class="links">
        <a href="#">Política de Privacidad</a> | 
        <a href="#">Términos de Servicio</a> | 
        <a href="#">Soporte</a>
    </div>
</div>

</body>
</html>