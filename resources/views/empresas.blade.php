<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protocolos de Seguridad</title>
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
        /* Sección de Contactos */
        .contact-section {
            padding: 1rem 2rem;
            background-color: #f1f8e9;
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
            background-color: rgb(220, 21, 21);
            color: #fff;
            padding: 40px 20px;
            text-align: center;
            margin-top: 20px;
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
        /* Estilos para la sección de empresas asociadas */
        .associated-companies-section {
            padding: 2rem;
            background-color: #f9f9f9;
            text-align: center;
        }
        .associated-companies-section h2 {
            color: #004d40;
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .associated-companies-section .company {
            margin-top: 1.5rem;
            padding: 1rem;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            text-align: left;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .associated-companies-section .company:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .associated-companies-section .company h3 {
            color:rgb(214, 39, 39);
            font-size: 1.5rem;
        }
        .associated-companies-section .company p {
            font-size: 1.1rem;
            margin: 0.5rem 0;
        }
        /* Estilo para las imágenes de empresas asociadas */
        .associated-companies-section .company .logo img {
            height: 100px;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .associated-companies-section .company .logo img:hover {
            transform: scale(1.1);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <!-- Espacio para la barra de navegación fija -->
    <div class="navbar-space"></div>

    <!-- Barra de Navegación -->
    <nav class="navbar">
        <div class="logo">
            <a href="home"><img src="{{ url('img/Logotipo.png') }}" alt="Ecovibe" style="height: 60px;"></a>
        </div>
        <div class="menu">
            <a class="nav-link" href="{{ route('home') }}">Inicio</a>
            <a class="nav-link" href="{{ route('recicladoras') }}">Alertas a Centros</a>
            <a class="empresas" href="{{ route('empresas') }}">Protocolos de Seguridad</a>
            <a class="centros" href="{{ route('centrosacopio') }}">Nosotros</a>
           
        </div>
    </nav>

    <!-- Sección de Empresas Asociadas -->
    <section class="associated-companies-section">
        <h2 class="titulo1">Protocolos de Seguridad</h2>
        <p>En Psycowax colaboramos con diversas empresas especializadas en la prevención y control de incendios industriales. Conoce algunos de los protocolo de seguridad que puedes tomar en cuenta.</p>

        <!-- Empresa 1 -->
        <div class="company">
    <h3>Prevención de Incendios</h3>
    <p><strong>Descripción:</strong> Implementación de medidas de seguridad para evitar incendios en instalaciones industriales, incluyendo inspecciones y mantenimiento de equipos.</p>
    <p><strong>Ubicación:</strong> Aplicable en todas las industrias y centros de trabajo.</p>
    <p><strong>Contacto:</strong> Línea de emergencias 911 o bomberos locales.</p>
    <div class="logo">
        <a href="#inicio"><img src="{{ url('img/protocolo1.png') }}" alt="Prevención" style="height: 60px;"></a>
    </div>
</div>

<!-- Protocolo 2 -->
<div class="company">
    <h3>Uso de Extintores</h3>
    <p><strong>Descripción:</strong> Capacitación sobre el uso adecuado de extintores en caso de incendio, identificación de tipos de fuego y extintores adecuados para cada situación.</p>
    <p><strong>Ubicación:</strong> Debe haber extintores accesibles en todas las áreas de riesgo.</p>
    <p><strong>Contacto:</strong> Responsable de seguridad en cada empresa o unidad de protección civil.</p>
    <div class="logo">
        <a href="#inicio"><img src="{{ url('img/protocolo2.png') }}" alt="Extintores" style="height: 60px;"></a>
    </div>
</div>

<!-- Protocolo 3 -->
<div class="company">
    <h3>Evacuación y Rutas de Escape</h3>
    <p><strong>Descripción:</strong> Planes de evacuación para emergencias, señalización adecuada de rutas de escape y simulacros periódicos para entrenar al personal.</p>
    <p><strong>Ubicación:</strong> Señales visibles en pasillos, salidas y puntos de reunión designados.</p>
    <p><strong>Contacto:</strong> Coordinador de seguridad interna o brigada de emergencia.</p>
    <div class="logo">
        <a href="#inicio"><img src="{{ url('img/protocolo3.png') }}" alt="Evacuación" style="height: 60px;"></a>
    </div>
    </div>
    <div class="company">
    <h3>Almacenamiento de Materiales Peligrosos</h3>
    <p><strong>Descripción:</strong> Normas para el almacenamiento seguro de sustancias inflamables o peligrosas, evitando fuentes de calor y asegurando ventilación adecuada.</p>
    <p><strong>Ubicación:</strong> Áreas designadas con señalización adecuada y accesibles solo para personal autorizado.</p>
    <p><strong>Contacto:</strong> Supervisor de seguridad industrial o unidad de protección civil.</p>
    <div class="logo">
        <a href="#inicio"><img src="{{ url('img/protocolo4.png') }}" alt="Almacenamiento" style="height: 60px;"></a>
    </div>
    </div>
    <div class="company">
    <h3>Mantenimiento de Instalaciones Eléctricas</h3>
    <p><strong>Descripción:</strong> Inspecciones regulares de cableado, tableros eléctricos y maquinaria para prevenir cortocircuitos e incendios por fallas eléctricas.</p>
    <p><strong>Ubicación:</strong> Todas las áreas con equipos eléctricos o alto consumo energético.</p>
    <p><strong>Contacto:</strong> Departamento de mantenimiento o técnico electricista certificado.</p>
    <div class="logo">
        <a href="#inicio"><img src="{{ url('img/protocolo5.png') }}" alt="Electricidad" style="height: 60px;"></a>
    </div>
</div>
<div class="company">
    <h3>“STOP, DROP & ROLL” (Detente, Tírate y Rueda)</h3>
    <p><strong>Descripción:</strong> Técnica universal en caso de que la ropa de una persona se incendie. Consiste en detenerse, tirarse al suelo y rodar para apagar las llamas.</p>
    <p><strong>Ubicación:</strong> Aplicable en cualquier lugar donde pueda ocurrir un incendio.</p>
    <p><strong>Contacto:</strong> Cualquier persona debe conocer esta técnica y aplicarla en caso de emergencia.</p>
    <div class="logo">
        <a href="#inicio"><img src="{{ url('img/protocolo6.png') }}" alt="Stop Drop Roll" style="height: 60px;"></a>
    </div>
</div>
    
        </div>
    </section>

    <!-- Pie de página -->
    <div class="footer">
        <h2>¡Contribuye a un México más limpio y sostenible!</h2>
        <p>Si conoces o eres el propietario de un centro de acopio o reciclaje que no se encuentre en este directorio, por favor contacta con nosotros para incluirlo aquí.</p>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>