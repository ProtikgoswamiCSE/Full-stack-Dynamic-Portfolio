@extends('index')
@push('styles')
<title>Home - Protik Goswami</title>
@section('home-section')
<!--===== HOME =====-->

<main class="l-main">
    <section class="home bd-grid" id="home">
        <div class="home__data">
            <h1 class="home__title">{!! \App\Models\HomeContent::getContent('title', 'Hi there,<br>I\'m <span class="home__title-color">Protik Goswami</span><br>Web Designer') !!}</h1>
            <p class="home__subtitle">{{ \App\Models\HomeContent::getContent('subtitle', 'Passionate about creating amazing web experiences') }}</p>
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
        </div>
        <div>
            <a href={{ url('/contact') }} class="button">{{ \App\Models\HomeContent::getContent('contact_button_text', 'Contact') }}</a>
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
            <svg class="home__blob" viewBox="0 0 479 467" xmlns="" xmlns:xlink="">
                <mask id="mask0" mask-type="alpha">
                    <path d="M9.19024 145.964C34.0253 76.5814 114.865 54.7299 184.111 29.4823C245.804 6.98884 311.86 -14.9503 370.735 14.143C431.207 44.026 467.948 107.508 477.191 174.311C485.897 237.229 454.931 294.377 416.506 344.954C373.74 401.245 326.068 462.801 255.442 466.189C179.416 469.835 111.552 422.137 65.1576 361.805C17.4835 299.81 -17.1617 219.583 9.19024 145.964Z"/>
                </mask>
                <g mask="url(#mask0)">
                    <path d="M9.19024 145.964C34.0253 76.5814 114.865 54.7299 184.111 29.4823C245.804 6.98884 311.86 -14.9503 370.735 14.143C431.207 44.026 467.948 107.508 477.191 174.311C485.897 237.229 454.931 294.377 416.506 344.954C373.74 401.245 326.068 462.801 255.442 466.189C179.416 469.835 111.552 422.137 65.1576 361.805C17.4835 299.81 -17.1617 219.583 9.19024 145.964Z"/>
                    <image class="home__blob-img" x="50" y="60" href="{{ asset('assets/img/protik.png') }}"/>
                </g>
            </svg>
        </div>
    </section>
</main>
@endsection