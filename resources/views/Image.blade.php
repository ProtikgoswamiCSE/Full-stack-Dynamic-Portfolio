@extends('index')
@push('styles')
<title>Image - Protik Goswami</title>
@section('image-section')
<!--===== WORK =====-->
<section class="work section" id="work">
    <h2 class="section-title">Image's</h2>

    <div class="work__container bd-grid">
        @forelse($images as $img)
            <div class="work__item">
                <a href="{{ asset('storage/' . $img->image_path) }}" class="work__img" target="_blank">
                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $img->alt_text }}">
                </a>
                @if($img->alt_text && $img->alt_text !== '—' && trim($img->alt_text) !== '')
                    <p class="work__caption">{{ $img->alt_text }}</p>
                @endif
            </div>
        @empty
            <p style="grid-column: 1 / -1; text-align:center">No images yet.</p>
        @endforelse
    </div>
</section>
@endsection