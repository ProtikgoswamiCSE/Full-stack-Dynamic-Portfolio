@extends('index')
@push('styles')
<title>Academic - Protik Goswami</title>
<style>
    .academic-link {
        text-decoration: none;
        color: inherit;
        display: block;
        transition: transform 0.3s ease;
    }
    
    .academic-link:hover {
        transform: none;
        text-decoration: none;
        color: inherit;
    }
    
    .academic-image {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: box-shadow 0.3s ease;
    }
    
    .academic-link:hover .academic-image {
        box-shadow: 0 6px 16px rgba(0,0,0,0.2);
    }
    
    .academic-pdf {
        text-align: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 2px dashed #dee2e6;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .academic-pdf:hover {
        background: #e9ecef;
        border-color: #6c757d;
        transform: none;
    }
    
    .academic-pdf i {
        color: #dc3545;
    }
    
    .academic-pdf p {
        margin: 0;
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .academic-placeholder {
        text-align: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 2px dashed #dee2e6;
    }
    
    .academic-period {
        color: #6c757d;
        font-style: italic;
        margin-bottom: 10px;
    }
</style>
@section('academic-section')
<!--===== Academic =====-->
<section class="about section " id="academic">
    <h2 class="section-title">Academic</h2>

    @php
        $academics = \App\Models\Academic::getActiveOrdered();
    @endphp

    @if($academics->count() > 0)
        @foreach($academics as $academic)
        <div class="about__container bd-grid">
            <div class="about__img">
                @if($academic->certificate_image)
                    @if($academic->certificate_url)
                        <a href="{{ $academic->certificate_url }}" target="_blank" class="academic-link">
                            @if(Str::endsWith($academic->certificate_image, '.pdf'))
                                <div class="academic-pdf">
                                    <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                    <p class="mt-2">Click to view PDF</p>
                                </div>
                            @else
                                <img src="{{ asset('storage/' . $academic->certificate_image) }}" 
                                     alt="{{ $academic->institution_name }}" class="academic-image">
                            @endif
                        </a>
                    @else
                        @if(Str::endsWith($academic->certificate_image, '.pdf'))
                            <div class="academic-pdf">
                                <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                <p class="mt-2">PDF Certificate</p>
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $academic->certificate_image) }}" 
                                 alt="{{ $academic->institution_name }}" class="academic-image">
                        @endif
                    @endif
                @elseif($academic->certificate_url)
                    <a href="{{ $academic->certificate_url }}" target="_blank" class="academic-link">
                        <img src="{{ $academic->certificate_url }}" 
                             alt="{{ $academic->institution_name }}" class="academic-image">
                    </a>
                @else
                    <div class="academic-placeholder">
                        <i class="fas fa-graduation-cap fa-3x text-muted"></i>
                    </div>
                @endif
            </div>
            
            <div>
                <h2 class="about__subtitle">
                    <b>{{ $academic->institution_name }}</b>
                </h2>
                <div class="academic-period">
                    @if($academic->start_year && $academic->end_year)
                        {{ $academic->start_year }}-{{ $academic->end_year }}
                    @elseif($academic->start_year)
                        {{ $academic->start_year }}-Present
                    @elseif($academic->end_year)
                        Completed {{ $academic->end_year }}
                    @endif
                </div>
                <h3 class="about__subtitle" style="font-size: 1.1rem; margin-bottom: 10px;">
                    {{ $academic->degree_title }}
                </h3>
                <p class="about__text">
                    <strong>Field:</strong> {{ $academic->field_of_study }}
                    @if($academic->description)
                        <br><strong>Details:</strong> {!! nl2br(e($academic->description)) !!}
                    @endif
                </p>
            </div>                                   
        </div>
        @endforeach
    @else
        <div class="text-center text-muted py-5">
            <i class="fas fa-graduation-cap fa-4x mb-3"></i>
            <h5 class="text-muted">No academic records available at the moment</h5>
            <p class="text-muted">Check back later for updates!</p>
        </div>
    @endif
</section>
@endsection