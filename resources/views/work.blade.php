@extends('index')
@push('styles')
<title>work - Protik Goswami</title>

<!-- Glider.js CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/projects.css') }}">
@endpush
@section('work-section')
<!--===== WORK =====-->
<section class="work section" id="work">
    <h2 class="section-title">🚀 My Projects</h2>
    <div class="project-cards">
        <div class="card-container">
        <div class="card medium"><img src="{{ asset('https://img.freepik.com/free-photo/boy-taking-picture_23-2148011872.jpg?semt=ais_hybrid&w=740') }}" alt="Project"></div>  
        <div class="card large"><img src="{{ asset('https://media.istockphoto.com/id/1180778899/photo/young-woman-taking-a-pictures.jpg?s=170667a&w=0&k=20&c=nryzlDE3twbNsokiX6p0xlsOyQmU1TYrYDOdd182wcY=') }}" alt="Project"></div>
        <div class="card medium"><img src="{{ asset('https://www.shutterstock.com/image-photo/smiling-young-woman-using-camera-260nw-679625758.jpg') }}" alt="Project"></div>
        </div>
    </div>
</section>

<section class="work section" id="work-2">
    <h2 class="section-title">🌟 More Projects</h2>
    <div class="project-cards">
        <div class="card medium"><img src="{{ asset('assets/images/img5.jpg') }}" alt="Project"></div>
        <div class="card medium"><img src="{{ asset('assets/images/img6.jpg') }}" alt="Project"></div>
        <div class="card medium"><img src="{{ asset('assets/images/img7.jpg') }}" alt="Project"></div>
        <div class="card medium"><img src="{{ asset('assets/images/img8.jpg') }}" alt="Project"></div>
    </div>
</section>
@endsection