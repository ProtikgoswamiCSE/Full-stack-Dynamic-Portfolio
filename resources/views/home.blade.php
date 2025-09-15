@extends('index')
@push('styles')
<title>Home - Protik Goswami</title>
@section('home-section')
<!--===== HOME =====-->

<main class="l-main">
    <section class="home bd-grid" id="home">
        @php $animEnabled = \App\Models\HomeContent::getContent('animation_enabled', '1') === '1'; @endphp
        @if($animEnabled)
        <style>
        .bee-overlay{position:fixed;inset:0;pointer-events:none;z-index:1;opacity:.8}
        .bd-grid,.footer,.home__data,.home__social{position:relative;z-index:2}
        .home__img{z-index:2}
        </style>
        <canvas id="bee-canvas" class="bee-overlay"></canvas>
        @endif
        <div class="home__data">
            <h1 class="home__title">{!! \App\Models\HomeContent::getContent('title', 'Hi there,<br>I\'m <span class="home__title-color">Protik Goswami</span><br>Web Designer') !!}</h1>
            <p class="home__subtitle">{!! \App\Models\HomeContent::getContent('subtitle', 'Passionate about creating amazing web experiences') !!}</p>
            <ul class="home__title_li">
                @php
                    $skills = \App\Models\HomeContent::getContent('skills_list', "* Network Security Specialist\n* Programming\n* UI/UX Design\n* Artificial Intelligence");
                    $skillsArray = explode("\n", $skills);
                @endphp
                @foreach($skillsArray as $skill)
                    @if(trim($skill) !== '')
                        <li>{{ ltrim(trim($skill), '*') }}</li>
                    @endif
                @endforeach
            </ul>
            <div class="home__button">
                <a href="{{ url('/contact') }}" class="button">{{ \App\Models\HomeContent::getContent('contact_button_text', 'Contact') }}</a>
            </div>
        </div>

        <div class="home__social">
            @php
                $socialLinks = \App\Models\SocialMediaLink::getActiveLinks();
            @endphp
            @foreach($socialLinks as $link)
                <a href="{{ $link->url }}" class="home__social-icon" title="{{ $link->name }}">
                    <i class="{{ $link->icon_class }}"></i>
                </a>
            @endforeach
        </div>

        <div class="home__img">
            @php
                // Force fresh data from database
                $profileSettings = \App\Models\ProfileImageSetting::getSettings();
                $profileImage = $profileSettings->profile_image ? asset('storage/' . $profileSettings->profile_image . '?v=' . time()) : asset('assets/img/protik.png?v=' . time());
                $imageAlt = $profileSettings->image_alt_text ?: 'Profile Image';
                
            @endphp
            @php
                $shadowHex = ltrim($profileSettings->shadow_color ?? '#000000', '#');
                $sr = hexdec(substr($shadowHex, 0, 2));
                $sg = hexdec(substr($shadowHex, 2, 2));
                $sb = hexdec(substr($shadowHex, 4, 2));
                $sop = ($profileSettings->shadow_opacity ?? 30) / 100;
                $shadowFilter = "drop-shadow(0 8px 16px rgba($sr, $sg, $sb, $sop))";
            @endphp
            <svg class="home__blob" viewBox="0 0 479 467" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="--bg-color: {{ $profileSettings->background_color }}; --border-color: {{ $profileSettings->border_color }}; --shadow-color: {{ $profileSettings->shadow_color }}; --shadow-opacity: {{ $profileSettings->shadow_opacity / 100 }}; filter: {{ $shadowFilter }};" data-timestamp="{{ time() }}" id="profile-svg">
                <mask id="mask0" mask-type="alpha">
                    <path d="M9.19024 145.964C34.0253 76.5814 114.865 54.7299 184.111 29.4823C245.804 6.98884 311.86 -14.9503 370.735 14.143C431.207 44.026 467.948 107.508 477.191 174.311C485.897 237.229 454.931 294.377 416.506 344.954C373.74 401.245 326.068 462.801 255.442 466.189C179.416 469.835 111.552 422.137 65.1576 361.805C17.4835 299.81 -17.1617 219.583 9.19024 145.964Z"/>
                </mask>
                <g mask="url(#mask0)">
                    <path d="M9.19024 145.964C34.0253 76.5814 114.865 54.7299 184.111 29.4823C245.804 6.98884 311.86 -14.9503 370.735 14.143C431.207 44.026 467.948 107.508 477.191 174.311C485.897 237.229 454.931 294.377 416.506 344.954C373.74 401.245 326.068 462.801 255.442 466.189C179.416 469.835 111.552 422.137 65.1576 361.805C17.4835 299.81 -17.1617 219.583 9.19024 145.964Z" fill="var(--bg-color)"/>
                    <image class="home__blob-img" x="10" y="5" href="{{ $profileImage }}" width="500" height="500" alt="{{ $imageAlt }}" onerror="this.onerror=null; this.href='{{ asset('assets/img/protik.png') }}';"/>
                </g>
            </svg>
        </div>
    </section>
</main>

<script>
// Function to refresh profile settings from server
function refreshProfileSettings() {
    fetch('/api/profile-settings')
        .then(response => response.json())
        .then(data => {
            console.log('Refreshing profile settings:', data);
            
            const svg = document.getElementById('profile-svg');
            const image = document.querySelector('.home__blob-img');
            
            if (svg) {
                // Update CSS variables
                svg.style.setProperty('--bg-color', data.background_color);
                svg.style.setProperty('--border-color', data.border_color);
                svg.style.setProperty('--shadow-color', data.shadow_color);
                svg.style.setProperty('--shadow-opacity', data.shadow_opacity / 100);
                
                // Update the fill color directly
                const blobPath = svg.querySelector('path[fill="var(--bg-color)"]');
                if (blobPath) {
                    blobPath.setAttribute('fill', data.background_color);
                }
                
                // Update shadow effect
                const shadowRgb = hexToRgb(data.shadow_color);
                if (shadowRgb) {
                    svg.style.filter = `drop-shadow(0 8px 16px rgba(${shadowRgb.r}, ${shadowRgb.g}, ${shadowRgb.b}, ${data.shadow_opacity / 100}))`;
                }
            }
            
            if (image && data.profile_image) {
                image.href = `/storage/${data.profile_image}?v=${Date.now()}`;
            }
            
            console.log('Profile settings refreshed successfully');
        })
        .catch(error => {
            console.error('Error refreshing profile settings:', error);
        });
}

// Helper function to convert hex to RGB
function hexToRgb(hex) {
    const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

// Auto-refresh profile settings every 30 seconds
// setInterval(refreshProfileSettings, 30000);

// Add keyboard shortcut to manually refresh (Ctrl+R)
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        refreshProfileSettings();
        console.log('Profile settings manually refreshed');
    }
});
</script>
@if($animEnabled)
<script src="{{ asset('assets/js/bee-animation.js') }}"></script>
@endif
@endsection