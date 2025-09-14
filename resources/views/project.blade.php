@extends('index')
@push('styles')
<title>Project - Protik Goswami</title>

<!-- Glider.js CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/projects.css') }}">
@endpush
@section('project-section')
<!--===== PROJECT =====-->
@php
    $projects = \App\Models\Project::getActiveOrdered();
@endphp

<section class="work section" id="work">
    <h2 class="section-title">🚀 My Projects</h2>
    <div class="project-cards">
        <div class="card-container">
            @forelse($projects as $project)
                <div class="card uniform-card">
                    <div class="card-image">
                        @if($project->image_url)
                            <img src="{{ $project->image_url }}" alt="{{ $project->title }}">
                        @else
                            <div class="project-placeholder">
                                <i class="fas fa-code"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">{{ $project->title }}</h3>
                        @if($project->technologies && is_array($project->technologies))
                            <div class="project-tech">
                                @foreach($project->technologies as $tech)
                                    <span class="tech-tag">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="project-links">
                            @if($project->project_url)
                                <a href="{{ $project->project_url }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="fas fa-external-link-alt"></i> View Project
                                </a>
                            @endif
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-github"></i> GitHub
                                </a>
                            @endif
                        </div>
                    </div>
                    <!-- Hover overlay with full description -->
                    <div class="project-overlay">
                        <div class="overlay-content">
                            <h3>{{ $project->title }}</h3>
                            @if($project->description)
                                <p class="full-description">{{ $project->description }}</p>
                            @endif
                            @if($project->technologies && is_array($project->technologies))
                                <div class="project-tech">
                                    @foreach($project->technologies as $tech)
                                        <span class="tech-tag">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <!-- Links in overlay -->
                            <div class="overlay-links">
                                @if($project->project_url)
                                    <a href="{{ $project->project_url }}" target="_blank" class="btn btn-primary btn-sm overlay-btn">
                                        <i class="fas fa-external-link-alt"></i> View Project
                                    </a>
                                @endif
                                @if($project->github_url)
                                    <a href="{{ $project->github_url }}" target="_blank" class="btn btn-outline-primary btn-sm overlay-btn">
                                        <i class="fab fa-github"></i> GitHub
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card uniform-card blank-card">
                    <div class="blank-content">
                        <i class="fas fa-plus-circle"></i>
                        <p>No projects yet. Add some projects from the admin panel!</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

@if($projects->count() > 0)
<section class="work section" id="work-2">
    <h2 class="section-title">🌟 More Projects</h2>
    <div class="project-cards">
        <div class="card-container">
            @foreach($projects->skip(3) as $project)
                <div class="card uniform-card">
                    <div class="card-image">
                        @if($project->image_url)
                            <img src="{{ $project->image_url }}" alt="{{ $project->title }}">
                        @else
                            <div class="project-placeholder">
                                <i class="fas fa-code"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">{{ $project->title }}</h3>
                        @if($project->technologies && is_array($project->technologies))
                            <div class="project-tech">
                                @foreach($project->technologies as $tech)
                                    <span class="tech-tag">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="project-links">
                            @if($project->project_url)
                                <a href="{{ $project->project_url }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="fas fa-external-link-alt"></i> View Project
                                </a>
                            @endif
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-github"></i> GitHub
                                </a>
                            @endif
                        </div>
                    </div>
                    <!-- Hover overlay with full description -->
                    <div class="project-overlay">
                        <div class="overlay-content">
                            <h3>{{ $project->title }}</h3>
                            @if($project->description)
                                <p class="full-description">{{ $project->description }}</p>
                            @endif
                            @if($project->technologies && is_array($project->technologies))
                                <div class="project-tech">
                                    @foreach($project->technologies as $tech)
                                        <span class="tech-tag">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <!-- Links in overlay -->
                            <div class="overlay-links">
                                @if($project->project_url)
                                    <a href="{{ $project->project_url }}" target="_blank" class="btn btn-primary btn-sm overlay-btn">
                                        <i class="fas fa-external-link-alt"></i> View Project
                                    </a>
                                @endif
                                @if($project->github_url)
                                    <a href="{{ $project->github_url }}" target="_blank" class="btn btn-outline-primary btn-sm overlay-btn">
                                        <i class="fab fa-github"></i> GitHub
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<style>
/* Uniform Card Styles */
.uniform-card {
    width: 350px;
    height: 400px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 6px 32px rgba(0,0,0,0.10);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    display: flex;
    flex-direction: column;
}

.uniform-card:hover {
    transform: translateY(-12px) scale(1.03);
    box-shadow: 0 20px 50px rgba(0,0,0,0.25);
    border: 2px solid rgba(102, 126, 234, 0.3);
}

/* Card Image Section */
.card-image {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.uniform-card:hover .card-image img {
    transform: scale(1.1);
    filter: brightness(1.1);
}

/* Card Content Section */
.card-content {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.card-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0 0 10px 0;
    color: #333;
    line-height: 1.3;
}

/* Project Placeholder */
.project-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.project-placeholder i {
    font-size: 3rem;
    opacity: 0.8;
}

/* Technology Tags */
.project-tech {
    margin: 10px 0;
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.tech-tag {
    display: inline-block;
    background: #f0f0f0;
    color: #666;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Project Links */
.project-links {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: auto;
}

.project-links .btn {
    font-size: 0.8rem;
    padding: 6px 12px;
    border-radius: 20px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.project-links .btn-primary {
    background: #667eea;
    border: none;
    color: white;
}

.project-links .btn-outline-primary {
    border: 1px solid #667eea;
    color: #667eea;
    background: transparent;
}

.project-links .btn:hover {
    transform: translateY(-2px);
}

/* Hover Overlay with Full Description */
.project-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.9);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    padding: 20px;
    pointer-events: none; /* Allow clicks to pass through initially */
}

.uniform-card:hover .project-overlay {
    opacity: 1;
    pointer-events: auto; /* Enable clicks when visible */
}

.overlay-content {
    text-align: center;
    max-height: 100%;
    overflow-y: auto;
}

.overlay-content h3 {
    margin-bottom: 15px;
    font-size: 1.4rem;
    font-weight: 600;
}

.full-description {
    margin-bottom: 15px;
    font-size: 0.9rem;
    line-height: 1.5;
    color: #e0e0e0;
}

.overlay-content .project-tech {
    justify-content: center;
    margin-bottom: 20px;
}

.overlay-content .tech-tag {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

/* Overlay Links */
.overlay-links {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 15px;
}

.overlay-btn {
    font-size: 0.8rem;
    padding: 8px 16px;
    border-radius: 20px;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    z-index: 10;
    position: relative;
}

.overlay-btn.btn-primary {
    background: #667eea;
    border: none;
    color: white;
}

.overlay-btn.btn-outline-primary {
    border: 1px solid #667eea;
    color: #667eea;
    background: rgba(255, 255, 255, 0.1);
}

.overlay-btn:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.overlay-btn.btn-primary:hover {
    background: #5a6fd8;
    color: white;
}

.overlay-btn.btn-outline-primary:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

/* Blank Card */
.blank-card {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    border: 2px dashed #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
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

/* Responsive Design */
@media (max-width: 1200px) {
    .uniform-card {
        width: 300px;
        height: 380px;
    }
}

@media (max-width: 900px) {
    .uniform-card {
        width: 280px;
        height: 360px;
    }
    
    .card-image {
        height: 180px;
    }
}

@media (max-width: 600px) {
    .card-container {
        flex-direction: column;
        align-items: center;
    }
    
    .uniform-card {
        width: 90vw;
        max-width: 350px;
        height: 400px;
    }
}

/* Dark mode support */
body.dark-mode .uniform-card,
html.dark-mode .uniform-card {
    background: #23272b !important;
    box-shadow: 0 6px 32px rgba(0,0,0,0.32);
}

body.dark-mode .card-title,
html.dark-mode .card-title {
    color: #e0e0e0 !important;
}

body.dark-mode .tech-tag,
html.dark-mode .tech-tag {
    background: #3a3a3a !important;
    color: #e0e0e0 !important;
}
</style>
@endsection
