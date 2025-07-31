<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <script>
  // This runs before DOMContentLoaded
  (function () {
    try {
      const isDark = localStorage.getItem('theme') === 'dark';
      if (isDark) {
        document.documentElement.classList.add('dark-mode');
      }
    } catch (e) {
      // fail silently
    }
  })();
</script>

    @stack('styles')
    <title>Protik Goswami - Portfolio</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
            <!--===== HEADER =====-->
        <header class="l-header">
            <nav class="nav bd-grid">
                <div>
                    <a href="https://linktr.ee/protikgoswami" class="nav__logo">Protik</a>
                </div>

                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item"><a href={{ url('/') }}  class="nav__link active-link">Home</a></li>
                        <li class="nav__item"><a href={{ url('/about') }} class="nav__link">About</a></li>
                        <li class="nav__item"><a href={{ url('/skills') }} class="nav__link">Skills</a></li>
                        <li class="nav__item"><a href={{ url('/achivement') }} class="nav__link">Achivement</a></li>
                        <li class="nav__item"><a href={{ url('/academic') }} class="nav__link">Academic</a></li>
                        <li class="nav__item"><a href={{ url('/work') }} class="nav__link">Work</a></li>
                        <li class="nav__item"><a href={{ url('/Image') }} class="nav__link">Image</a></li>
                        <li class="nav__item"><a href={{ url('/contact') }} class="nav__link">Contact</a></li>
                    </ul>
                </div>

                <div style="display: flex; align-items: center; gap: 10px;">
    <!-- Theme toggle button -->
    <button id="theme-toggle" style="background: none; border: none; cursor: pointer; font-size: 1.5rem;" title="Toggle dark mode">
        <span id="theme-toggle-icon">&#9788;</span>
    </button>
</div>
            </nav>
        </header>

        <!--===== HOME =====-->
        @yield('home-section')

        <!--===== ABOUT =====-->
            @yield('about-section')

        <!--===== Achivement =====-->
            @yield('achivement-section')
        <!--===== WORK =====-->
         @yield('work-section')
        <!--===== Image =====-->
            @yield('image-section')
        <!--===== ACADEMIC =====-->
            @yield('academic-section')
        <!--===== SKILLS =====-->
            @yield('skills-section')

        <!--===== CONTACT =====-->
            @yield('contact-section')
        <!--===== FOOTER =====-->
        <footer class="footer">
            <p class="footer__title">Contact with Me</p>
            <div class="footer__social">
                <a href="https://github.com/ProtikgoswamiCSE" class="footer__icon"><i class='fa-brands fa-github skills__icon_futter' ></i></a>
                <a href="https://www.facebook.com/protik.goswami.140" class="footer__icon"><i class='fa-brands fa-facebook skills__icon_futter' ></i></a>
                <a href="#" class="footer__icon"><i class='fa-brands fa-linkedin skills__icon_futter' ></i></a>
                <a href="https://www.instagram.com/goswamiprotik/" class="footer__icon"><i class='fa-brands fa-instagram skills__icon_futter' ></i></a>
                <a href="https://linktr.ee/protikgoswami" class="footer__icon"><i class='fa-solid fa-link' ></i></a>
            </div>
            
        </footer>
        <script src="{{ asset('assets/js/theme-toggle.js') }}"></script>
        <script src="{{ asset('resources/js/app.js') }}"></script>
</body>
</html>