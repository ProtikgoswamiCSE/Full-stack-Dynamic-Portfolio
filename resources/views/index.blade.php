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
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS for dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown .nav__link {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            min-width: 160px;
            padding: 5px 0;
            margin: 2px 0 0;
            background-color: #2CCB92;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 6px 12px rgba(0,0,0,.175);
        }
        .dropdown-menu.show {
            display: block;
        }
        .dropdown-item {
            display: block;
            width: 100%;
            padding: 8px 16px;
            clear: both;
            font-weight: normal;
            line-height: 1.42857143;
            color: #333;
            white-space: nowrap;
            text-decoration: none;
        }
        .dropdown-item:hover {
            background-color: #f5f5f5;
            color: #262626;
        }
        .nav__link.dropdown-toggle {
            cursor: pointer;
        }
        .nav__link.dropdown-toggle .dropdown-icon {
            margin-left: 5px;
            font-size: 0.7em;
            transition: transform 0.3s ease;
        }
    </style>
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
                        @php
                            $currentRoute = request()->route()->getName() ?? request()->path();
                            $isHome = $currentRoute === 'home' || $currentRoute === '/';
                        @endphp
                        <li class="nav__item"><a href={{ url('/') }} class="nav__link {{ $isHome ? 'active-link' : '' }}">Home</a></li>
                        <li class="nav__item"><a href={{ url('/about') }} class="nav__link {{ request()->is('about') ? 'active-link' : '' }}">About</a></li>
                        <li class="nav__item"><a href={{ url('/skills') }} class="nav__link {{ request()->is('skills') ? 'active-link' : '' }}">Skills</a></li>
                        <li class="nav__item"><a href={{ url('/achivement') }} class="nav__link {{ request()->is('achivement') ? 'active-link' : '' }}">Achivement</a></li>
                        <li class="nav__item"><a href={{ url('/academic') }} class="nav__link {{ request()->is('academic') ? 'active-link' : '' }}">Academic</a></li>
                        <li class="nav__item dropdown">
                            <a href="#" class="nav__link dropdown-toggle {{ request()->is('work') || request()->is('project') ? 'active-link' : '' }}" id="workDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <span id="workNavText">Work</span> <i class="fas fa-chevron-down dropdown-icon"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="workDropdown">
                                <li><a class="dropdown-item" href="#" onclick="selectWorkOption('Work', '/work')">Work</a></li>
                                <li><a class="dropdown-item" href="#" onclick="selectWorkOption('Project', '/project')">Project</a></li>
                            </ul>
                        </li>
                        <li class="nav__item"><a href={{ url('/Image') }} class="nav__link {{ request()->is('Image') ? 'active-link' : '' }}">Image</a></li>
                        <li class="nav__item"><a href={{ url('/contact') }} class="nav__link {{ request()->is('contact') ? 'active-link' : '' }}">Contact</a></li>
                    </ul>
                </div>

                <div style="display: flex; align-items: center; gap: 10px;">
    <!-- Theme toggle button -->
    <button id="theme-toggle" style="background: none; border: none; cursor: pointer; font-size: 1.5rem;" title="Toggle dark mode">
        <span id="theme-toggle-icon">🌙</span>
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
        <!--===== PROJECT =====-->
         @yield('project-section')
        <!--===== Image =====-->
            @yield('image-section')
        <!--===== ACADEMIC =====-->
            @yield('academic-section')
        <!--===== SKILLS =====-->
            @yield('skills-section')

        <!--===== CONTACT =====-->
            @yield('contact-section')
        <!--===== FOOTER =====-->
        @php
            $footer = \App\Models\Footer::getActive();
            $footerLinks = \App\Models\FooterSocialLink::getActiveOrdered();
        @endphp
        <footer class="footer">
            <p class="footer__title">{{ $footer->title ?? 'Contact with Me' }}</p>
            @if($footer && $footer->description)
                <div class="footer__description">{{ $footer->description }}</div>
            @endif
            <div class="footer__social">
                @forelse($footerLinks as $link)
                    <a href="{{ $link->url }}" class="footer__icon {{ $link->getColorClass() }}" target="_blank" rel="noopener">
                        <i class="{{ $link->getIconClass() }} skills__icon_futter"></i>
                    </a>
                @empty
                @endforelse
            </div>
            @if($footer && $footer->copyright_text)
                <div class="footer__copy">{{ $footer->copyright_text }}</div>
            @endif
        </footer>
        <script src="{{ asset('assets/js/theme-toggle.js') }}"></script>
        <script src="{{ asset('resources/js/app.js') }}"></script>
        <script>
            // Dropdown functionality
            document.addEventListener('DOMContentLoaded', function() {
                const dropdown = document.getElementById('workDropdown');
                const dropdownMenu = dropdown.nextElementSibling;
                
                // Toggle dropdown on click
                dropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isOpen = dropdownMenu.classList.contains('show');
                    dropdownMenu.classList.toggle('show');
                    
                    // Rotate chevron icon
                    const chevron = dropdown.querySelector('.dropdown-icon');
                    if (isOpen) {
                        chevron.style.transform = 'rotate(0deg)';
                    } else {
                        chevron.style.transform = 'rotate(180deg)';
                    }
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdown.contains(e.target)) {
                        dropdownMenu.classList.remove('show');
                        // Reset chevron icon
                        const chevron = dropdown.querySelector('.dropdown-icon');
                        chevron.style.transform = 'rotate(0deg)';
                    }
                });
                
                // Set initial text based on current page
                const currentPath = window.location.pathname;
                if (currentPath === '/project') {
                    document.getElementById('workNavText').textContent = 'Project';
                } else {
                    document.getElementById('workNavText').textContent = 'Work';
                }
            });
            
            // Function to select work option
            function selectWorkOption(text, url) {
                document.getElementById('workNavText').textContent = text;
                window.location.href = url;
            }
        </script>
</body>
</html>