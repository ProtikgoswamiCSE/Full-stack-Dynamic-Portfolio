@extends('index')
@push('styles')
<title>Work - Protik Goswami</title>

<!-- Glider.js CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/projects.css') }}">
@endpush
@section('work-section')
<!--===== WORK =====-->
<section class="work section" id="work">
    <h2 class="section-title">💼 My Work</h2>
    <div class="project-cards">
        <div class="card-container">
        <div class="card medium blank-card">
            <div class="blank-content">
                <i class="fas fa-plus-circle"></i>
                <p>Add Work Item</p>
            </div>
        </div>  
        <div class="card large blank-card">
            <div class="blank-content">
                <i class="fas fa-plus-circle"></i>
                <p>Add Work Item</p>
            </div>
        </div>
        <div class="card medium blank-card">
            <div class="blank-content">
                <i class="fas fa-plus-circle"></i>
                <p>Add Work Item</p>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection

<style>
.blank-card {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    border: 2px dashed #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 200px;
}

.blank-content {
    text-align: center;
    color: #666;
}

.blank-content i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.blank-content p {
    font-size: 1.1rem;
    margin: 0;
}
</style>