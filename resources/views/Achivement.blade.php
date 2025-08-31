@extends('index')
@push('styles')
<title>Achievements - Protik Goswami</title>
<style>
    .achievement-link {
        text-decoration: none;
        color: inherit;
        display: block;
        transition: transform 0.3s ease;
    }
    
    .achievement-link:hover {
        transform: scale(1.05);
        text-decoration: none;
        color: inherit;
    }
    
    .achievement-image {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: box-shadow 0.3s ease;
    }
    
    .achievement-link:hover .achievement-image {
        box-shadow: 0 6px 16px rgba(0,0,0,0.2);
    }
    
    .achievement-pdf {
        text-align: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 2px dashed #dee2e6;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .achievement-pdf:hover {
        background: #e9ecef;
        border-color: #6c757d;
        transform: scale(1.02);
    }
    
    .achievement-pdf i {
        color: #dc3545;
    }
    
    .achievement-pdf p {
        margin: 0;
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .achievement-placeholder {
        text-align: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 2px dashed #dee2e6;
    }
</style>
@section('achivement-section')
<!--===== Achievements =====-->
<section class="about section " id="achievements">
    <h2 class="section-title">Achievements</h2>

    @php
        $achievements = \App\Models\Achievement::getActiveOrdered();
    @endphp

    @if($achievements->count() > 0)
        @foreach($achievements as $achievement)
        <div class="about__container bd-grid">
            <div class="about__img">
                @if($achievement->certificate_image)
                    @if($achievement->certificate_url)
                        <a href="{{ $achievement->certificate_url }}" target="_blank" class="achievement-link">
                            @if(Str::endsWith($achievement->certificate_image, '.pdf'))
                                <div class="achievement-pdf">
                                    <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                    <p class="mt-2">Click to view PDF</p>
                                </div>
                            @else
                                <img src="{{ asset('storage/' . $achievement->certificate_image) }}" 
                                     alt="{{ $achievement->title }}" class="achievement-image">
                            @endif
                        </a>
                    @else
                        @if(Str::endsWith($achievement->certificate_image, '.pdf'))
                            <div class="achievement-pdf">
                                <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                <p class="mt-2">PDF Certificate</p>
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $achievement->certificate_image) }}" 
                                 alt="{{ $achievement->title }}" class="achievement-image">
                        @endif
                    @endif
                @elseif($achievement->certificate_url)
                    <a href="{{ $achievement->certificate_url }}" target="_blank" class="achievement-link">
                        <img src="{{ $achievement->certificate_url }}" 
                             alt="{{ $achievement->title }}" class="achievement-image">
                    </a>
                @else
                    <div class="achievement-placeholder">
                        <i class="fas fa-certificate fa-3x text-muted"></i>
                    </div>
                @endif
            </div>
            
            <div>
                @if($achievement->title)
                    <h2 class="about__subtitle">
                        <b><u>{{ $achievement->title }}</u></b>
                    </h2>
                @endif
                @if($achievement->description)
                    <div class="about__text">
                        {!! nl2br(e($achievement->description)) !!}
                    </div>
                @endif
            </div>                                   
        </div>
        @endforeach
    @else
        <div class="text-center py-5">
            <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No achievements available at the moment</h5>
            <p class="text-muted">Check back later for updates!</p>
        </div>
    @endif
</section>
@endsection