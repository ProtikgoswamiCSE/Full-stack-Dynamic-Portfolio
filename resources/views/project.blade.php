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
                <div class="card {{ $loop->index % 3 === 1 ? 'large' : 'medium' }}">
                    @if($project->image_url)
                        <img src="{{ $project->image_url }}" alt="{{ $project->title }}">
                    @else
                        <div class="project-placeholder">
                            <i class="fas fa-code"></i>
                            <h4>{{ $project->title }}</h4>
                        </div>
                    @endif
                    <div class="project-overlay">
                        <h3>{{ $project->title }}</h3>
                        @if($project->description)
                            <p>{{ Str::limit($project->description, 100) }}</p>
                        @endif
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
                                <a href="{{ $project->github_url }}" target="_blank" class="btn btn-outline-light btn-sm">
                                    <i class="fab fa-github"></i> GitHub
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="card medium blank-card">
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
        @foreach($projects->skip(3) as $project)
            <div class="card medium">
                @if($project->image_url)
                    <img src="{{ $project->image_url }}" alt="{{ $project->title }}">
                @else
                    <div class="project-placeholder">
                        <i class="fas fa-code"></i>
                        <h4>{{ $project->title }}</h4>
                    </div>
                @endif
                <div class="project-overlay">
                    <h3>{{ $project->title }}</h3>
                    @if($project->description)
                        <p>{{ Str::limit($project->description, 100) }}</p>
                    @endif
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
                            <a href="{{ $project->github_url }}" target="_blank" class="btn btn-outline-light btn-sm">
                                <i class="fab fa-github"></i> GitHub
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

<style>
.project-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-align: center;
    padding: 20px;
}

.project-placeholder i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.8;
}

.project-placeholder h4 {
    margin: 0;
    font-size: 1.2rem;
}

.project-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.card:hover .project-overlay {
    opacity: 1;
}

.project-overlay h3 {
    margin-bottom: 10px;
    font-size: 1.3rem;
}

.project-overlay p {
    margin-bottom: 15px;
    font-size: 0.9rem;
    line-height: 1.4;
}

.project-tech {
    margin-bottom: 15px;
}

.tech-tag {
    display: inline-block;
    background: rgba(255, 255, 255, 0.2);
    padding: 4px 8px;
    margin: 2px;
    border-radius: 12px;
    font-size: 0.8rem;
}

.project-links {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: center;
}

.project-links .btn {
    font-size: 0.8rem;
    padding: 5px 10px;
}

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
@endsection
