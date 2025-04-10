<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recicladora </title>
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
        .navbar h1{
            font-size: 1.5em;
            margin-bottom: 10px;
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
            color:rgb(27, 94, 54);
            background-color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .footer .contact-button:hover {
            background-color:rgb(255, 255, 255);
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
       
        
        .btn {
            padding: 0.4rem 1rem;
            background-color: #388e3c;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-size: 0.9rem;
        }
        .btn:hover {
            background-color: #2e7d32;
            transform: scale(1.05);
        }
        .navbar {
    display: flex; /* Usar flexbox para alinear los elementos */
    align-items: center; /* Alinear verticalmente al centro */
    justify-content: space-between; /* Espacio entre la imagen y el texto */
    padding: 1rem 2rem; /* Espaciado interno */
    background-color:rgb(220, 21, 21); /* Color de fondo */
}


.navbar h1 {
    margin: 0; /* Eliminar márgenes */
    color: #ffffff; /* Color del texto */
    font-size: 1.5rem; /* Tamaño de la fuente */
    text-align: left; /* Centrar el texto */
}

    </style>
</head>
<body>

<!-- Espacio reservado para que la barra de navegación no cubra el contenido -->
<div class="navbar-space"></div>

<nav class="navbar">
    <div class="logo">
   <a href="{{ url('/') }}"><img src="{{ url('img/Logotipo.png') }}" alt="Ecovibe" style="height: 60px;"></a> 
    </div>
    
</nav>

<div class="container">
    <div class="title">Cuerpo de Bomberos - Toluca</div>
    <div class="subtitle">📍 José Vicente Villada 109, Manzana 023,<br> Centro 50000 Toluca, Estado de México, México</div>
    <a href="tel:+7222286839" class="button">📞 Llamar: 722 228 68 39</a>

    <div class="categories">
        <p><strong>Servicios:</strong> Emergencias, Rescate</p>
    </div>

    <div class="map">
    <strong>🗺️ Cómo llegar</strong>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d120508.26075444267!2d-99.78249072160921!3d19.2874471!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cd884a826be7d1%3A0xc99d022b4edacadc!2sEstaci%C3%B3n%20de%20Bomberos%20Lic.%20Cesar%20Camacho%20Quiroz!5e0!3m2!1ses!2smx!4v1741183031548!5m2!1ses!2smx" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div class="schedule">
        <strong>⏰ Horarios</strong>
        <p>Disponible las 24 horas</p>
    </div>

    <div class="contact-info">
        <div><span class="icon">📞</span> Teléfono: <a href="tel:+525551590245">+52 55 1590 0245</a></div>
        <div><span class="icon">🌐</span><a href="#">Sitio Web</a></div>
        <div><span class="icon">📘</span><a href="#">Facebook</a></div>
    </div>
    <a class="salida" href="{{ route('recicladoras') }}">Regresar</a>   
    
</div>

<!-- Pie de página -->
<div class="footer">
    <h2>¡Apoya a los Bomberos de Toluca!</h2>
    <p>Si conoces o eres parte de una estación de bomberos que no se encuentra en este directorio, contáctanos para incluirla.</p>
    <a href="{{ route('contactos') }}" class="contact-button">CONTACTOS</a>
    <div class="copyright">
        &copy; 2024 Ecovibe. Todos los derechos reservados.
    </div>
    <div class="links">
        <a href="#">Política de Privacidad</a> | 
        <a href="#">Términos de Servicio</a> | 
        <a href="#">Soporte</a>
    </div>
</div>

</body>
</html>