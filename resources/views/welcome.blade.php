<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API | Design | 2023</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header class="hero">
        <nav class="nav__hero">
            <div class="container nav__container">
                <div class="logo">
                    <h2 class="logo__name">Tarsicio Carrizales API_REST, Design<span class="point">.</span></h2>
                </div>
                <div class="links">                    
                    <a href="#contacto" class="link link--active">Contacto</a>
                </div>
            </div>
        </nav>


        <section class="container hero__main">  
            <div class="hero__textos">
                <h1 class="title">Prueba nuestra <span class="title--active">API_REST Laravel_9.</span></h1> 
                <p class="copy">Nos encargamos de llevar tu idea al <span class="copy__active">siguiente nivel</span></p>
                <a href="#" class="cta">telecom.com.ve@gmail.com</a>
                <p class="copy">Manejo de Usuarios(Autenticación por Token, módulo <span class="copy__active">Sanctum</span>), Roles, Permisos, Notificaciones, Módulos y mucho más. 100% Funcional, Documentación API y prueba con <span class="copy__active">Swagger. </span><a href="{{url('/api/v1/documentation')}}" class="link link--active">{{url('/api/v1/documentation')}}</a></p>
            </div>                            
            <img src="img/intro-img.svg" alt="" class="mockup">          
        </section>
    </header>

    <footer class="footer">
        <div class="contact">
            <div class="item__contact">                
            </div>
            <div class="item__contact">
                <i class='bx bx-copyright contact__icon' ></i>
                <h3 class="contact__title">Tarsicio Carrizales API_REST Design</h3>
            </div>
            <div class="item__contact" id="contacto">
                <i class='bx bx-mail-send contact__icon' > Contacto</i>
                <h3 class="contact__title">telecom.com.ve@gmail.com</h3>
            </div>
            <div class="item__contact">                
            </div>            
        </div>
    </footer>
</body>
</html>
