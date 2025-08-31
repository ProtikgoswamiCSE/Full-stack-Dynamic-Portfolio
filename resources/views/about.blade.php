@extends('index')
@push('styles')
<title>About - Protik Goswami</title>
@section('about-section')
<!--===== ABOUT =====-->
<section class="about section " id="about">
    <h2 class="section-title">About</h2>

    @php
        $aboutContents = \App\Models\AboutContent::getAllOrdered();
    @endphp

    @foreach($aboutContents as $content)
    <div class="about__container bd-grid">
        <div class="about__img">
            @if($content->image)
                @if(Str::startsWith($content->image, 'http'))
                    <img src="{{ $content->image }}" alt="{{ $content->title }}">
                @else
                    <img src="{{ asset('storage/' . $content->image) }}" alt="{{ $content->title }}">
                @endif
            @endif
        </div>
        
        <div>
            @if($content->title)
                <h2 class="about__subtitle">{!! $content->title !!}</h2>
            @endif
            <div class="about__text">
                {!! nl2br(e($content->content)) !!}
            </div>
        </div>                                   
    </div>
    @endforeach
</section>

@endsection