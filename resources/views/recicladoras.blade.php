<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alertas a Centros</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Amatic+SC:wght@700&display=swap" rel="stylesheet">

    <style>
        /* Estilos Generales */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f4f4f4;
        }

       

        /* Barra de navegación fija */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
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

        /* Contenido principal */
        .content {
            padding: 2rem;
            background-color: #f9f9f9;
        }

        /* Estilo para cada sección de servicios */
        .service-section h2 {
            color: #004d40;
        }

        /* Estilos para las tarjetas */
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid #d0d0d0;
            border-radius: 8px;
            width: 300px;
            padding: 20px;
            text-align: left;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card h2 {
            font-size: 1.3em;
            color: #333;
            margin-bottom: 10px;
        }

        .card p {
            color: #666;
            margin: 5px 0;
        }

        .icon {
            font-weight: bold;
            color: #388e3c;
            margin-right: 5px;
        }

        .materials {
            margin-top: 10px;
        }

        .material-tag {
            display: inline-block;
            background-color:rgb(228, 36, 36);
            color: #ffffff;
            border-radius: 4px;
            padding: 5px 10px;
            font-size: 0.85em;
            margin: 3px;
        }

        /* Estilos para los botones */
        .button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            font-size: 0.9em;
            color: #ffffff;
            background-color:rgba(255, 8, 8, 0.9);
            border: none;
            border-radius: 6px;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color:rgb(70, 70, 70);
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
    </style>
</head>
<body>
    <!-- Espacio para la barra de navegación fija -->
    <div class="navbar-space"></div>

    <!-- Barra de Navegación -->
    <nav class="navbar">
        <div class="logo">
            <a href="{{ url('home') }}"><img src="{{ url('img/Logotipo.png') }}" alt="Ecovibe" style="height: 60px;"></a>
        </div>
        <div class="menu">
        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
            <a class="nav-link" href="{{ route('recicladoras') }}">Alertas a Centros</a>
            <a class="empresas" href="{{ route('empresas') }}">Protocolos de Seguridad</a>
            <a class="centros" href="{{ route('centrosacopio') }}">Nosotros</a>
        </div>
        
    </nav>


    <h1 class="titulo">Bomberos en Estado de México</h1>
    <p class="textos">Encuentra los mejores centros de bomberos cerca de ti en Estado de México, a continuación, encontrarás un listado completo de los servicios de bomberos en Estado de México. Cada tarjeta proporciona información esencial como el nombre del centro, dirección, número de teléfono y una breve descripción de los servicios ofrecidos.</p>

<div class="container">
    <!-- Ejemplo de tarjeta -->
    <div class="card">
        <h2>Cuerpo de Bomberos - Cuautitlán Izcalli</h2>
        <p><span class="icon">📍</span> C. Miguel Hidalgo 6 C, Manzana 012, San Martin Tepetlitlan, Cuautitlán Izcalli, Estado de México</p>
        <p><span class="icon">📞</span> 557 159 03 69</p>
        <p>Bomberos</p>
        <p>Servicios Aceptados:</p>
        <div class="materials">
            <span class="material-tag">Emergencias</span>
            <span class="material-tag">Rescate</span>
            <span class="material-tag">Prevención de incendios</span>
        </div>
        <a class="button" href="{{ route('recicladoraIzcalli') }}">MÁS INFORMACIÓN</a>
    </div>
    <!-- Más tarjetas pueden ir aquí -->
    <div class="card">
        <h2>Cuerpo de Bomberos - Toluca</h2>
        <p><span class="icon">📍</span> José Vicente Villada 109,Manzana 023, Centro 50000 Toluca, Estado de México</p>
        <p><span class="icon">📞</span> 722 228 68 39</p>
        <p>Bomberos</p>
        <p>Servicios Aceptados:</p>
        <div class="materials">
            <span class="material-tag">Emergencias</span>
            <span class="material-tag">Rescate</span>
        </div>
        <a class="button" href="{{ route('reciclacentro') }}">MÁS INFORMACIÓN</a>
    </div>
    <!---------------------->
    <div class="card">
        <h2>Cuerpo de Bomberos - Tlachaloya Segunda Secc.</h2>
        <p><span class="icon">📍</span> Tlachaloya, Benito Juárez, Tlachaloya Segunda Secc., Manzana 021 50295 Toluca, Estado de México México</p>
        <p><span class="icon">📞</span> 556 003 50 43</p>
        <p>Bomberos</p>
        <p>Servicios Aceptados:</p>
        <div class="materials">
            <span class="material-tag">Emergencias</span>
            <span class="material-tag">Rescate</span>
            <span class="material-tag">Prevención de incendios</span>
        </div>
        <a class="button" href="{{ route('recicladoralvarez') }}">MÁS INFORMACIÓN</a>
    </div>
     <!---------------------->
     <div class="card">
        <h2>Cuerpo de Bomberos - Naucalpan de Juárez</h2>
        <p><span class="icon">📍</span> Avenida San Mateo Nopala 164, San Mateo Nopala 53220 Naucalpan de Juárez, Estado de México México</p>
        <p><span class="icon">📞</span> 551 793 33 59</p>
        <p>Bomberos</p>
        <p>Servicios Aceptados:</p>
        <div class="materials">
            <span class="material-tag">Emergencias</span>
            <span class="material-tag">Rescate</span>
        </div>
        <a class="button" href="{{ route('recicladoracuspide') }}">MÁS INFORMACIÓN</a>
    </div>
     <!---------------------->
     <div class="card">
        <h2>Cuerpo de Bomberos - Lerma de Villada</h2>
        <p><span class="icon">📍</span> Boulevard Doña Rosa. 7 Sección I y II, Mz 1 Nave I, Manzana 1, Parque Industrial Lerma Toluca 52004 Lerma de Villada, Estado de México</p>
        <p><span class="icon">📞</span> 556 347 70 20</p>
        <p>Bomberos</p>
        <p>Servicios Aceptados:</p>
        <div class="materials">
            <span class="material-tag">Emergencias</span>
        </div>
        <a class="button" href="{{ route('recicladorapoambi') }}">MÁS INFORMACIÓN</a>
    </div>
     <!---------------------->
     <div class="card">
     <h2>Cuerpo de Bomberos - Atizapán de Zaragoza</h2>
    <p><span class="icon">📍</span> Avenida de los Maestros, Manzana 30, Atizapán de Zaragoza, Estado de México</p>
    <p><span class="icon">📞</span> 555 223 44 55</p>
    <p>Bomberos</p>
    <p>Servicios Aceptados:</p>
    <div class="materials">
        <span class="material-tag">Emergencias</span>
        <span class="material-tag">Rescate</span>
    </div>
        <a class="button" href="{{ route('recicladoramexico') }}">MÁS INFORMACIÓN</a>
    </div>
     <!---------------------->
     <div class="card">
        <h2>Cuerpo de Bomberos - Ecatepec de Morelos</h2>
        <p><span class="icon">📍</span> C. 1 Mz 012, Rústica Xalostoc, Manzana 012, Benito Juárez Xalostoc 55340 Ecatepec de Morelos, Estado de México</p>
        <p><span class="icon">📞</span> 559 210 19 30</p>
        <p>Bomberos</p>
        <p>Servicios Aceptados:</p>
        <div class="materials">
            <span class="material-tag">Emergencias</span>
            <span class="material-tag">Rescate</span>
            <span class="material-tag">Prevención de incendios</span>
        </div>
        <a class="button" href="{{ route('recicladoraecatepec') }}">MÁS INFORMACIÓN</a>
    </div>
     <!---------------------->
     <div class="card">
     <h2>Cuerpo de Bomberos - Chimalhuacán</h2>
    <p><span class="icon">📍</span> Calle Juárez, Manzana 10, Chimalhuacán, Estado de México</p>
    <p><span class="icon">📞</span> 555 111 22 33</p>
    <p>Bomberos</p>
    <p>Servicios Aceptados:</p>
    <div class="materials">
        <span class="material-tag">Emergencias</span>
        <span class="material-tag">Rescate</span>
        <span class="material-tag">Prevención de incendios</span>
    </div>

        <a class="button" href="{{ route('recicladoraproton') }}">MÁS INFORMACIÓN</a>
    </div>
     <!---------------------->
     <div class="card">
     <h2>Cuerpo de Bomberos - Nezahualcóyotl</h2>
        <p><span class="icon">📍</span> Calle 4, Manzana 101, Nezahualcóyotl, Estado de México</p>
        <p><span class="icon">📞</span> 555 678 12 34</p>
        <p>Bomberos</p>
        <p>Servicios Aceptados:</p>
        <div class="materials">
            <span class="material-tag">Emergencias</span>
            <span class="material-tag">Rescate</span>
            <span class="material-tag">Prevención de incendios</span>
        </div>
        <a class="button" href="{{ route('recicladoraverdes') }}">MÁS INFORMACIÓN</a>
    </div>
</div>

<!-- Pie de página -->
<div class="footer">
<h2>¡Contribuye a un México más seguro y preparado!</h2>
<p>Si conoces o eres el propietario de un centro de bomberos que no se encuentre en este directorio, por favor contacta con nosotros para incluirlo aquí.</p>
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