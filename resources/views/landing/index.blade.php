<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gobierno Autónomo Regional del Gran Chaco Yacuiba</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variables CSS para colores (Ajusta estos colores para que coincidan EXACTAMENTE con la identidad del Gran Chaco Yacuiba) */
        :root {
            --chaco-green: #27ae60; /* Verde vibrante, evocando la naturaleza */
            --chaco-brown: #795548; /* Tono tierra/marrón */
            --chaco-blue: #3498db;  /* Azul cielo, representando el horizonte */
            --chaco-light-bg: #ecf0f1; /* Fondo claro */
            --chaco-text: #333;     /* Color de texto principal */
            --chaco-text-menu: #ffffff;     /* Color de texto principal */
            --chaco-footer-bg: #2c3e50; /* Fondo oscuro para el pie de página */
            --chaco-accent: #f39c12; /* Un toque de naranja/amarillo para resaltar */
        }

        /* Estilos Generales y Tipografía */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: var(--chaco-light-bg);
            color: var(--chaco-text);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Banner Superior (Pequeño) */
        .top-banner {
            width: 100%;
            height: 160px; /* Altura del banner pequeño */
            background-image: url('https://via.placeholder.com/1500x100/27ae60/ffffff?text=Gobierno+Gran+Chaco+Yacuiba'); /* Reemplaza con tu imagen de logo/banner */
            background-color: #17A668;
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 1.8em;
            font-weight: 700;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
            /* Oculta el texto si la imagen ya tiene el logo/texto */
            text-indent: -9999px; /* Ocultar texto si usas solo imagen */
            overflow: hidden; /* Ocultar desbordamiento del texto oculto */
        }

        /* Encabezado y Navegación */
        header {
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 10px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav {
            display: flex;
            background-color: #0FB462;
            justify-content: center; /* Centrar el menú por defecto */
            align-items: center;
            position: relative; /* Para posicionar el botón de hamburguesa */
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap; /* Permite que los elementos se envuelvan en pantallas pequeñas */
            justify-content: center;
        }

        nav ul li {
            position: relative;
            margin: 0 15px;
        }

        nav ul li a {
            display: block;
            padding: 15px 10px;
            text-decoration: none;
            color: var(--chaco-text-menu);
            font-weight: 600;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: var(--chaco-text-menu);
        }

        /* Menú Desplegable */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 180px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-top: 3px solid var(--chaco-green);
        }

        .dropdown-content a {
            color: var(--chaco-text);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
            font-weight: 400;
        }

        .dropdown-content a:hover {
            background-color: var(--chaco-light-bg);
            color: var(--chaco-green);
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Botón de Menú Hamburguesa */
        .menu-toggle {
            display: none; /* Oculto por defecto en pantallas grandes */
            background: none;
            border: none;
            font-size: 2em;
            cursor: pointer;
            color: var(--chaco-text);
            position: absolute; /* Posicionado dentro del nav */
            right: 20px; /* Alineado a la derecha */
            top: 50%;
            transform: translateY(-50%);
            z-index: 1001; /* Asegura que esté encima del menú */
        }

        /* Slider Principal de Imágenes (debajo del menú) */
        .main-slider-container {
            position: relative;
            width: 100%;
            max-width: 100%; /* Ocupa todo el ancho del contenedor */
            margin: 0 auto 30px auto;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .main-slider-images {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .main-slider-images img {
            width: 100%;
            display: block;
            flex-shrink: 0;
            height: 450px; /* Altura fija para las imágenes del slider principal */
            object-fit: cover;
        }

        /* Sección de Contenido General */
        .content-section {
            background-color: #fff;
            padding: 40px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .content-section h2 {
            text-align: center;
            color: var(--chaco-blue);
            margin-bottom: 30px;
            font-size: 2.2em;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }

        .content-section h2::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--chaco-green);
            border-radius: 2px;
        }

        /* Sección de Noticias */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .news-item {
            background-color: var(--chaco-light-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .news-item:hover {
            transform: translateY(-5px);
        }

        .news-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .news-content {
            padding: 20px;
        }

        .news-content h3 {
            margin-top: 0;
            color: var(--chaco-brown);
            font-size: 1.4em;
            margin-bottom: 10px;
        }

        .news-content p {
            font-size: 0.9em;
            color: var(--chaco-text);
        }

        .news-content .news-date {
            display: block;
            font-size: 0.8em;
            color: var(--chaco-dark-gray);
            margin-bottom: 5px;
        }

        .news-content a {
            display: inline-block;
            margin-top: 15px;
            color: var(--chaco-green);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .news-content a:hover {
            text-decoration: underline;
        }

        /* Sección de Videos */
        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .video-item {
            background-color: #f8f8f8;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
            position: relative;
            height: 0; /* Important for aspect ratio */
        }

        .video-item iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Pie de Página */
        footer {
            background-color: var(--chaco-footer-bg);
            color: #fff;
            padding: 40px 20px;
            margin-top: 30px;
            text-align: center;
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            text-align: left;
            margin-bottom: 20px;
        }

        .footer-section {
            flex: 1;
            min-width: 200px;
            margin: 15px;
        }

        .footer-section h4 {
            color: var(--chaco-green);
            margin-bottom: 15px;
            font-size: 1.2em;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 5px;
        }

        .footer-section p, .footer-section ul {
            font-size: 0.9em;
            color: #ccc;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 8px;
        }

        .footer-section ul li a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section ul li a:hover {
            color: var(--chaco-green);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            margin-top: 20px;
            font-size: 0.85em;
        }

        /* Responsive Design para Menú Móvil */
        @media (max-width: 768px) {
            .top-banner {
                height: 140px;
            }
            nav ul {
                display: none; /* Oculta el menú por defecto en pantallas pequeñas */
                flex-direction: column;
                width: 100%;
                background-color: #fff;
                position: absolute;
                top: 100%; /* Coloca el menú debajo del header */
                left: 0;
                box-shadow: 0 5px 10px rgba(0,0,0,0.1);
                padding: 10px 0;
                overflow: hidden; /* Para la transición de altura */
                max-height: 0; /* Para el efecto de deslizamiento */
                transition: max-height 0.5s ease-out; /* Transición suave */
            }

            nav ul.show {
                display: flex; /* Muestra el menú cuando tiene la clase 'show' */
                max-height: 500px; /* Suficientemente grande para contener el menú */
            }

            nav ul li {
                margin: 0; /* Elimina márgenes laterales en el menú móvil */
                width: 100%;
                text-align: center;
            }

            nav ul li a {
                padding: 12px 10px;
                border-bottom: 1px solid var(--chaco-light-bg); /* Separador para ítems */
            }

            nav ul li:last-child a {
                border-bottom: none;
            }

            .dropdown-content {
                position: static; /* Se muestra debajo en móviles */
                width: 100%;
                box-shadow: none;
                border-top: none;
                background-color: var(--chaco-light-bg); /* Fondo para submenú en móvil */
            }

            .dropdown-content a {
                padding-left: 30px; /* Indentación para submenú */
            }

            .menu-toggle {
                display: block; /* Muestra el botón de hamburguesa */
            }

            /* Ajustes para el resto de secciones en móvil */
            .main-slider-images img {
                height: 280px;
            }
            .content-section h2 {
                font-size: 1.8em;
            }
            .news-grid, .video-grid {
                grid-template-columns: 1fr; /* Una columna en móviles */
            }
            .footer-content {
                flex-direction: column;
                align-items: center;
            }
            .footer-section {
                text-align: center;
                margin-bottom: 25px;
            }
        }

        @media (max-width: 480px) {
            .top-banner {
                height: 120px;
            }
            .main-slider-images img {
                height: 200px;
            }
            .content-section {
                padding: 20px;
            }
            .content-section h2 {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
    <div class="top-banner">
        Gobierno Autónomo Regional del Gran Chaco Yacuiba
    </div>

    <header>
        <nav>
            <button class="menu-toggle" aria-label="Abrir menú de navegación">☰</button>
            <ul id="main-nav">
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#noticias">Noticias</a></li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn">Institucional</a>
                    <div class="dropdown-content">
                        <a href="#mision_vision">Mision y Visión</a>
                        <a href="#objetivos_estrategicos">Objetivos Estratégicos</a>
                        <a href="#valores_institucionales">Valores Institucionales</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn">Secretarias</a>
                    <div class="dropdown-content">
                        <a href="#desarrollo_productivo">Secretaria Regional de Desarrollo Productivo, RRNN y Medio Ambiente y Agua</a>
                        <a href="#desarrollo_social">Secretaria Regional de Desarrollo Social</a>
                        <a href="#obras_publicas">Secretaria Regional de Obras Publicas Energia e Hidrocarburos</a>
                        <a href="#planificacion">Secretaria Regional de Planificacion e Inversion</a>
                        <a href="#pueblos_indigenas">Secretaria Regional de Pueblos Indigenas Originarios Campesinos</a>
                        <a href="#gestion_institucional">Secretaria Regional de Gestion Institucional</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn">Noticias</a>
                    <div class="dropdown-content">
                        <a href="#atractivos">Atractivos</a>
                        <a href="#cultura">Cultura</a>
                        <a href="#gastronomia">Gastronomía</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn">Transparencia</a>
                    <div class="dropdown-content">
                        <a href="#objetivos">Objetivos</a>
                        <a href="#planificacion_actividades">Planificacion de Actividades</a>
                        <a href="#marco_legal">Marco Legal de DRTLCC</a>
                        <a href="#acciones_prevencion">Acciones de Prevencion</a>
                        <a href="#convocatorias">Convocatorias</a>
                        <a href="#escala_salarial">Escala Salarial</a>
                        <a href="#rendicion_publica_cuentas">Rendicion Publica de Cuentas</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn">Gaceta Institucional</a>
                    <div class="dropdown-content">
                        <a href="#estatuto Regional">Estatuto Regional</a>
                        <a href="#auditoria">Auditoria</a>
                        <a href="#decretos_regionales">Decretos Regionales</a>
                        <a href="#dinore">DINORE</a>
                        <a href="#juridica">Juridica</a>
                        <a href="#resoluciones_administrativas">Resoluciones Administrativas</a>
                        <a href="#transparencia_gaceta">Transparencia</a>
                        <a href="#normas_gargch">Normas G.A.R.G.CH.</a>
                        <a href="#plan_estrategico_institucional">Plan Estrategico Institucional</a>
                    </div>
                </li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <div class="main-slider-container">
        <div class="main-slider-images">
            <img src="{{ asset('imagenes/landing/slider_1.jpg') }}" alt="slider_1">
            <img src="{{ asset('imagenes/landing/slider_2.jpg') }}" alt="slider_2">
            <img src="{{ asset('imagenes/landing/slider_3.jpg') }}" alt="slider_3">
            <img src="{{ asset('imagenes/landing/slider_4.jpg') }}" alt="slider_4">
            <img src="{{ asset('imagenes/landing/slider_5.jpg') }}" alt="slider_5">
            <img src="{{ asset('imagenes/landing/slider_6.jpg') }}" alt="slider_6">
            <img src="{{ asset('imagenes/landing/slider_7.jpg') }}" alt="slider_7">
            <img src="{{ asset('imagenes/landing/slider_8.jpg') }}" alt="slider_8">
            <img src="{{ asset('imagenes/landing/slider_9.jpg') }}" alt="slider_9">
            <img src="{{ asset('imagenes/landing/slider_10.jpg') }}" alt="slider_10">
        </div>
    </div>

    <main class="container">
        <section id="noticias" class="content-section">
            <h2>Últimas Noticias</h2>
            <div class="news-grid">
                <div class="news-item">
                    <img src="https://via.placeholder.com/400x200/2ecc71/ffffff?text=Noticia+1" alt="Noticia 1">
                    <div class="news-content">
                        <span class="news-date">24 de Julio, 2025</span>
                        <h3>Gran Avance en Proyectos de Infraestructura</h3>
                        <p>Se ha inaugurado un nuevo puente que conecta varias comunidades, mejorando significativamente la conectividad en la región.</p>
                        <a href="#noticia1">Leer más</a>
                    </div>
                </div>
                <div class="news-item">
                    <img src="https://via.placeholder.com/400x200/e74c3c/ffffff?text=Noticia+2" alt="Noticia 2">
                    <div class="news-content">
                        <span class="news-date">22 de Julio, 2025</span>
                        <h3>Festival Cultural del Gran Chaco con Récord de Asistencia</h3>
                        <p>La edición anual del festival superó todas las expectativas, con la participación de artistas locales e internacionales.</p>
                        <a href="#noticia2">Leer más</a>
                    </div>
                </div>
                <div class="news-item">
                    <img src="https://via.placeholder.com/400x200/f39c12/ffffff?text=Noticia+3" alt="Noticia 3">
                    <div class="news-content">
                        <span class="news-date">20 de Julio, 2025</span>
                        <h3>Inversión en Educación para el Desarrollo Local</h3>
                        <p>Nuevos programas educativos se implementarán en escuelas rurales, enfocados en tecnología y desarrollo sostenible.</p>
                        <a href="#noticia3">Leer más</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="videos" class="content-section">
            <h2>Videos Destacados</h2>
            <div class="video-grid">
                <div class="video-item">
                    <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Video de YouTube" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="video-item">
                    <iframe src="https://www.youtube.com/embed/your_video_id_2" title="Otro Video de YouTube" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="video-item">
                    <iframe src="https://www.youtube.com/embed/your_video_id_3" title="Tercer Video de YouTube" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </section>

        <section id="sobre-nosotros" class="content-section">
            <h2>Sobre el Gobierno Autónomo Regional</h2>
            <p>
                El Gobierno Autónomo Regional del Gran Chaco Yacuiba trabaja incansablemente para el desarrollo y bienestar de sus ciudadanos. Nuestro compromiso es fomentar el progreso económico, social y cultural, preservando nuestras raíces y proyectándonos hacia un futuro próspero.
            </p>
            <p>
                A través de una gestión transparente y participativa, buscamos fortalecer la autonomía, impulsar proyectos estratégicos en infraestructura, educación, salud y turismo, y garantizar la protección de nuestros recursos naturales.
            </p>
        </section>
    </main>

    <footer>
        <div class="container footer-content">
            <div class="footer-section">
                <h4>Contacto</h4>
                <p>Dirección: Calle Principal, Nro. 123, Yacuiba, Bolivia</p>
                <p>Teléfono: +591 4 67X XXXX</p>
                <p>Email: info@granChacoYacuiba.gob.bo</p>
            </div>
            <div class="footer-section">
                <h4>Enlaces Rápidos</h4>
                <ul>
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#transparencia">Portal de Transparencia</a></li>
                    <li><a href="#noticias">Sala de Prensa</a></li>
                    <li><a href="#faq">Preguntas Frecuentes</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Redes Sociales</h4>
                <ul>
                    <li><a href="https://facebook.com/GranChacoYacuiba" target="_blank">Facebook</a></li>
                    <li><a href="https://twitter.com/GranChacoYacuiba" target="_blank">Twitter</a></li>
                    <li><a href="https://youtube.com/GranChacoYacuiba" target="_blank">YouTube</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Gobierno Autónomo Regional del Gran Chaco Yacuiba. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        // Lógica del Slider Principal (debajo del menú)
        const mainSliderImages = document.querySelector('.main-slider-images');
        const mainImages = document.querySelectorAll('.main-slider-images img');
        let mainCurrentIndex = 0;
        const mainTotalImages = mainImages.length;

        function nextMainImage() {
            mainCurrentIndex = (mainCurrentIndex + 1) % mainTotalImages;
            const offset = -mainCurrentIndex * 100;
            mainSliderImages.style.transform = `translateX(${offset}%)`;
        }
        setInterval(nextMainImage, 3000); // Cambia cada 3 segundos (3000 milisegundos)

        // Lógica para el Menú Móvil (Toggle)
        const menuToggle = document.querySelector('.menu-toggle');
        const mainNav = document.getElementById('main-nav');

        menuToggle.addEventListener('click', () => {
            mainNav.classList.toggle('show');
            // Cierra cualquier dropdown abierto cuando se abre/cierra el menú principal
            document.querySelectorAll('.dropdown-content').forEach(content => {
                content.style.display = 'none';
            });
        });

        // Lógica para los dropdowns en pantallas pequeñas (Click)
        document.querySelectorAll('.dropdown > .dropbtn').forEach(button => {
            button.addEventListener('click', function(event) {
                // Solo activa el click para dropdowns si la pantalla es pequeña (menú móvil activo)
                if (window.innerWidth <= 768) {
                    event.preventDefault(); // Evita que el enlace # se active inmediatamente
                    const dropdownContent = this.nextElementSibling;
                    if (dropdownContent.style.display === 'block') {
                        dropdownContent.style.display = 'none';
                    } else {
                        // Cierra otros dropdowns abiertos del mismo nivel
                        this.closest('ul').querySelectorAll('.dropdown-content').forEach(content => {
                            if (content !== dropdownContent) {
                                content.style.display = 'none';
                            }
                        });
                        dropdownContent.style.display = 'block';
                    }
                }
            });
        });

        // Cierra los dropdowns y el menú principal si se hace clic fuera
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                const isClickInsideNav = event.target.closest('nav');
                if (!isClickInsideNav) {
                    // Cierra el menú principal si está abierto
                    if (mainNav.classList.contains('show')) {
                        mainNav.classList.remove('show');
                    }
                    // Cierra cualquier dropdown abierto
                    document.querySelectorAll('.dropdown-content').forEach(content => {
                        content.style.display = 'none';
                    });
                }
            }
        });

        // Asegúrate de que el menú se muestre correctamente al redimensionar a desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                mainNav.classList.remove('show'); // Esconde la clase 'show' en desktop
                mainNav.style.maxHeight = ''; // Restaura la altura en desktop
                // Asegura que los dropdowns estén visibles al hacer hover en desktop
                document.querySelectorAll('.dropdown-content').forEach(content => {
                    content.style.display = ''; // Oculta o muestra según el CSS original (hover)
                });
            }
        });
    </script>
</body>
</html>
