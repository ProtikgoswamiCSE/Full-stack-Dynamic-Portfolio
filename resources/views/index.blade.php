<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @stack('styles')
    <title>Protik Goswami - Portfolio</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
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
                        <li class="nav__item"><a href={{ url('/home') }}  class="nav__link active-link">Home</a></li>
                        <li class="nav__item"><a href={{ url('/about') }} class="nav__link">About</a></li>
                        <li class="nav__item"><a href="#skills" class="nav__link">Skills</a></li>
                        <li class="nav__item"><a href="#Achivement" class="nav__link">Achivement</a></li>
                        <li class="nav__item"><a href="#Academic" class="nav__link">Academic</a></li>
                        <li class="nav__item"><a href="#work" class="nav__link">Work</a></li>
                        <li class="nav__item"><a href="#contact" class="nav__link">Contact</a></li>
                    </ul>
                </div>

                <div class="nav__toggle" id="nav-toggle">
                    <i class='bx bx-menu'></i>
                </div>
            </nav>
        </header>

        <!--===== HOME =====-->
        @yield('home-section')

        <!--===== ABOUT =====-->
            @yield('about-section')
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
</body>
</html>