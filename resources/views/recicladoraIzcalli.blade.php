<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recicladora Izcalli</title>
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
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 20px;
        }
        .button {
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
        .categories, .contact-info, .map, .schedule {
            margin-bottom: 20px;
        }
        .map {
            width: 100%;
        }
        .map iframe {
            width: 100%;
            height: 500px; /* Puedes ajustar la altura según prefieras */
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
        /* Estilos de pie de página */
        .footer {
            background-color:rgb(220, 21, 21);
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
        .navbar-space {
            height: 80px; /* Espacio reservado para la barra de navegación */
        }
        .navbar .logo img {
            height: 50px;
        }
        .navbar .menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .navbar a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        .navbar a:hover {
            color: #c8e6c9;
        }
        .btn {
            padding: 0.4rem 1rem;
            background-color:rgb(142, 56, 56);
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-size: 0.9rem;
        }
        .btn:hover {
            background-color:rgb(125, 46, 46);
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<!-- Espacio reservado para que la barra de navegación no cubra el contenido -->
<div class="navbar-space"></div>  <!-- Barra de Navegación -->
<nav class="navbar">
    <div class="logo">
        <a href="{{ url('/ecovibe') }}"><img src="{{ url('img/Logotipo.png') }}" alt="Ecovibe" style="height: 60px;"></a>
    </div>
</nav>

<div class="container">
    <div class="title">Cuerpo de Bomberos - Cuautitlán Izcalli</div>
    <div class="subtitle">📍 C. Miguel Hidalgo 6 C, Manzana 012, San Martin Tepetlitlan, Cuautitlán Izcalli, Estado de México</div>
    <a href="tel:+525526201909" class="button">📞 Llamar: 52 552 620 1909</a>
    
    <div class="categories">
        <p><strong>Servicios:</strong> Bomberos</p>
        <p>Emergencias | Rescate | Prevención de incendios</p>
    </div>

    <div class="map">
        <strong>🗺️ Cómo llegar</strong>
        <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15058.561469575362!2d-99.2677081!3d19.65642!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d21e28437e59a9%3A0x3a0492417a4b29d7!2sPROTECCION%20CIVIL%20Y%20BOMBEROS%20DE%20CUAUTITLAN%20IZCALLI!5e0!3m2!1ses-419!2smx!4v1709595034506!5m2!1ses-419!2smx" 
        >
    </iframe>
    </div>

    <div class="schedule">
        <strong>⏰ Horarios</strong>
        <p>Disponible las 24 horas</p>
    </div>

    <div class="contact-info">
        <div><span class="icon">📞</span>Teléfono: <a href="tel:+525526201909">+525526201909</a></div>
        <div><span class="icon">🌐</span><a href="#">Sitio Web</a></div>
        <div><span class="icon">📘</span><a href="#">Facebook</a></div>
    </div>
    
    <a class="salida" href="{{ route('recicladoras') }}">Regresar</a>
    
</div>

<!-- Pie de página -->
<div class="footer">
    <h2>¡Contribuye a un México más seguro!</h2>
    <p>Si conoces o eres parte de una estación de bomberos que no se encuentre en este directorio, por favor contáctanos para incluirla.</p>
    <a href="{{ route('contactos') }}" class="contact-button">CONTACTOS</a>
    <div class="copyright">
        &copy; 2025 PsycoWax. Todos los derechos reservados.
    </div>
    <div class="links">
        <a href="#">Política de Privacidad</a> | 
        <a href="#">Términos de Servicio</a> | 
        <a href="#">Soporte</a>
    </div>
</div>

</body>
</html>