<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PsycoWax</title>
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
                color:rgb(0, 0, 0);
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
                color:rgb(230, 200, 200);
            }

            .btn {
                padding: 0.5rem 1.5rem;
                background-color:rgb(0, 0, 0);
                color: white ;
                font-weight: bold;
                border: none;
                border-radius: 50px;
                transition: background-color 0.3s ease, transform 0.3s ease;
            }

            .btn:hover {
                background-color:rgb(70, 70, 70);
                transform: scale(1.1);
            }

            /* Espacio debajo de la barra de navegación */
            .navbar-space {
                height: 80px; /* Ajusta este valor al alto de la barra de navegación */
            }

            /* Submenú */
            .submenu {
                background-color: #f9f9f9;
                padding: 1.0rem 8rem;
                display: flex;
                justify-content: center;
                gap: 4rem;
            }

            .submenu a {
                color:rgb(0, 0, 0);
                text-decoration: none;
                font-size: 0.9rem;
                font-weight: bold;
                transition: color 0.3s ease;
            }

            .submenu a:hover {
                color: black;
            }

            /* Sección Principal */
            .main-section {
                background-image: url('./img/incendio2.jpg');
                background-size: cover;
                background-position: center;
                text-align: center;
                color: white;
                padding: 10rem 2rem;
            }

            .main-section h1 {
                font-size: 3rem;
                margin-bottom: 1rem;
                font-family: 'Amatic SC', cursive;
                font-weight: bold;
            }

            .main-section p {
                font-size: 1.3rem;
                max-width: 700px;
                margin: auto;
            }

            /* Sección de Información */
            .info-section {
                padding: 2rem 2rem;
                background-color:rgb(255, 255, 255);
                text-align: center;
                color: #333;
            }

            .info-section h2 {
                color:rgb(0, 0, 0);
                font-size: 2rem;
            }

            .info-section p {
                max-width: 800px;
                margin: auto;
                font-size: 1.1rem;
                line-height: 1.6;
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
            .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 15px;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
        }
        .admin-links {
            display: flex;
            gap: 15px;
        }
        .admin-links a {
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            background: rgba(255,255,255,0.1);

        }
        .navbar-toggler {
        padding: 0.5rem;
        transition: all 0.3s ease;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 8px;
        position: relative;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .navbar-toggler:hover {
        border-color: white;
        background: rgba(255, 255, 255, 0.1);
    }

    .navbar-toggler-icon {
        background-image: none;
        position: relative;
        width: 24px;
        height: 2px;
        background: white;
        transition: all 0.3s ease;
    }

    .navbar-toggler-icon::before,
    .navbar-toggler-icon::after {
        content: '';
        position: absolute;
        width: 24px;
        height: 2px;
        background: white;
        transition: all 0.3s ease;
    }

    .navbar-toggler-icon::before {
        transform: translateY(-6px);
    }

    .navbar-toggler-icon::after {
        transform: translateY(6px);
    }

    .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
        background: transparent;
    }

    .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before {
        transform: rotate(45deg);
    }

    .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::after {
        transform: rotate(-45deg);
    }

    /* Mejoras al Offcanvas */
    .offcanvas {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        width: 300px;
        border-left: 1px solid rgba(0, 0, 0, 0.1);
        box-shadow: -4px 0 15px rgba(0, 0, 0, 0.05);
    }

    .offcanvas-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        padding: 1rem 1.5rem;
    }

    .offcanvas-title {
        font-family: 'Amatic SC', cursive;
        font-size: 2rem;
        font-weight: 700;
        color: #dc1529;
    }

    .offcanvas-body {
        padding: 1.5rem;
    }

    .mobile-user-info {
        text-align: center;
        margin-bottom: 2rem;
    }

    .mobile-user-info h3 {
        font-size: 1.25rem;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .mobile-user-info p {
        color: #666;
        font-size: 0.9rem;
    }

    .mobile-admin-links {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin: 1.5rem 0;
    }

    .mobile-admin-links a {
        color: #333;
        padding: 0.75rem;
        border-radius: 8px;
        background: rgba(220, 21, 33, 0.05);
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .mobile-admin-links a:hover {
        background: rgba(220, 21, 33, 0.1);
        transform: translateX(5px);
    }

    .mobile-admin-links a::before {
        content: '➤';
        color: #dc1529;
    }

    .logout-btn {
        width: 100%;
        margin-top: 1rem;
        padding: 0.75rem;
        background: #dc1529;
        color: white;
        border: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .logout-btn:hover {
        background: #b81222;
    }

    /* Mejoras adicionales al menú offcanvas */
    .offcanvas .nav-link {
        padding: 0.75rem 1rem;
        margin: 0.25rem 0;
        border-radius: 8px;
        color: #333;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .offcanvas .nav-link:hover {
        background: rgba(220, 21, 33, 0.05);
        color: #dc1529;
    }

    .offcanvas .nav-link::before {
        content: '•';
        color: #dc1529;
        font-size: 1.5rem;
        line-height: 0;
    }
    .profile-image-container {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto 20px;
}

.profile-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
/* Prevención de layout shift */
#imagePreview {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
}

.spinner-border {
    vertical-align: middle;
}

.d-none {
    display: none;
}

/* Mejoras visuales para la carga */
#loadingSpinner {
    color: #ffffff;
    margin-left: 5px;
}
        
        </style>
    </head>
    <body>
        <!-- Espacio para la barra de navegación fija -->
        <div class="navbar-space"></div>

        <!-- Barra de Navegación -->
        <nav class="navbar">
            <div class="logo">
                <a href="#inicio"><img src="{{ url('./img/Logotipo.png') }}" alt="Psycowax" style="height: 60px;"></a>
            </div>
            <div class="menu">
                <a href="#inicio">Inicio</a>
                <a class="nav-link" href="{{ route('recicladoras') }}">Alertas a Centros</a>
                <a class="empresas" href="{{ route('empresas') }}">Protocolos de Seguridad</a>
                <a class="centros" href="{{ route('centrosacopio') }}">Nosotros</a>
            </div>
    
            <!-- Botón de Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>

        <!-- Submenú -->
        <div class="submenu">
            <a href="#psycowax">¿Qué es Psycowax?</a>
            <a href="#proyectos">Proyectos y Tecnologías</a>
            <a href="#actualidad">Innovaciones</a>
            <a href="#economia">Seguridad contra Incendios</a>
        </div>

        <!-- Offcanvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu">
            <div class="offcanvas-body">
                @if(session('user'))
                <div class="mobile-user-info">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="profile-image-container mb-3">
                            <img src="{{ session('user.imagen', url('/img/default-user.png')) }}" 
                                 alt="Foto de perfil"
                                 class="profile-image"
                                 id="profilePreview">
                            
                        </div>
                        <div class="mt-2">
                            <input type="file" name="imagen" 
                                   id="imageInput" 
                                   class="form-control d-none"
                                   accept="image/*">
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="document.getElementById('imageInput').click()">
                                Cambiar imagen
                            </button>
                        </div>
                        
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" 
                                   value="{{ old('nombre', session('user.nombre')) }}" 
                                   class="form-control"
                                   required>
                        </div>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger mt-2">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        
                        
                        <button type="submit" class="btn btn-primary w-100 mt-3">
                            Guardar cambios
                        </button>
                    </form>
    
                    <hr>
                    
                    <h3>Bienvenido, {{ session('user.nombre') }}</h3>
                    <p>Rol: {{ session('user.rol') }}</p>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">Cerrar sesión</button>
                    </form>
                        
                        @if(session('user.rol') === 'admin')
                            <div class="mobile-admin-links">
                                <a href="{{ route('users.index') }}">Usuarios</a>
                                <a href="{{ route('sensors.index') }}">Sensores</a>
                                <a href="{{ route('readings.index') }}">Mediciones</a>
                                <a href="{{ route('alerts.index') }}">Alertas</a>
                            </div>
                        @endif
                        @if(session('user.rol') === 'usuario')
                            <div class="mobile-admin-links">
                                <a href="{{ route('sensors.create') }}">Agregar un sensor</a>
                                <a href="{{ route('grafica.temperatura') }}">Gráfica de Temperaturas</a>
                                <a href="{{ route('grafica.gas') }}">Gráfica de Gases</a>
                                <a href="{{ route('latest.values') }}">Monitor en Tiempo Real</a>
                            </div>
                        @endif
                    </div>
                @else
                    <a class="btn" href="{{ route('login') }}">Iniciar Sesión</a>
                @endif
            </div>
        </div>
        <script>
            document.getElementById('imageInput').addEventListener('change', function(e) {
                handleImage(e.target.files[0]);
            });
            
            function handleImage(file) {
                if (!file) return;
            
                if (file.size > 10485760) {
                    alert('La imagen excede el límite de 10MB');
                    return;
                }
            
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = new Image();
                    
                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');
                        const MAX_WIDTH = 500;
                        const scale = Math.min(MAX_WIDTH / img.width, 1);
                        canvas.width = img.width * scale;
                        canvas.height = img.height * scale;
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                        canvas.toBlob(blob => {
                            const preview = document.getElementById('profilePreview');
                            preview.src = URL.createObjectURL(blob);
                            const compressedFile = new File([blob], file.name, {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            });
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(compressedFile);
                            document.getElementById('imageInput').files = dataTransfer.files;
                        }, 'image/jpeg', 0.3);
                    };
                    
                    img.src = e.target.result;
                };
                
                reader.readAsDataURL(file);
            }
            </script>

        <!-- Sección Principal -->
        <section id="inicio" class="main-section">
            <h1>Psycowax, expertos en detección de incendios</h1>
            <p>Nos especializamos en sistemas de detección temprana de incendios para garantizar la seguridad y protección de tu empresa o hogar.</p>
            <a href="#psycowax" class="btn">¡Conócenos!</a>
        </section>

        <!-- Secciones de Información -->
        <section id="psycowax" class="info-section">
            <h2>¿Qué es Psycowax?</h2>
            <p>Nos dedicamos a la instalación y mantenimiento de sistemas de detección de incendios, brindando soluciones innovadoras para la protección de vidas y bienes.</p>
            <br><br>
            <iframe width="600" height="370" src="https://www.youtube.com/embed/unIY_k5u0z8?si=NQ7M4vNQ7sJvI5OC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </section>
    
        <section id="actualidad" class="info-section">
            <h2>Innovaciones</h2>
            <p>Implementamos tecnología de vanguardia para la detección y prevención de incendios, asegurando máxima eficacia en cada sistema.</p>
        </section>

        <section id="proyectos" class="info-section">
            <h2>Proyectos y Tecnologías</h2>
            <p>Desarrollamos soluciones personalizadas para cada tipo de industria, adaptándonos a las necesidades de nuestros clientes.</p>
        </section>

        <section id="economia" class="info-section">
            <h2>Seguridad contra Incendios</h2>
            <p>Brindamos asesoramiento y equipos de última generación para la detección y prevención de incendios en epresas industriales.</p>
        </section>

        <!-- Pie de página -->
        <div class="footer">
            <h2>¡Protege tu entorno con Psycowax!</h2>
            <p>Si deseas más información sobre nuestros sistemas de detección de incendios, contáctanos y conoce nuestras soluciones.</p>
            <a href="{{ route('contactos') }}" class="contact-button">CONTACTO</a>
            <div class="copyright">
                &copy; 2025 Psycowax. Todos los derechos reservados.
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