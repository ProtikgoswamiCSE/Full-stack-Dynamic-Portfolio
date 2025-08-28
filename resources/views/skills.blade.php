@extends('index')
@push('styles')
<title>skills - Protik Goswami</title>
@section('skills-section')
<!--===== SKILLS =====-->
<section class="skills section" id="skills">
    <h2 class="section-title">Skills</h2>

    <div class="skills__container bd-grid">          
        <div>
            <h2 class="skills__subtitle">Profesional Skills</h2>
            <p class="skills__text">Here are some of my core skills and proficiency levels.</p>
            @php
                try {
                    $skillModels = \App\Models\Skill::getAllOrderedActive();
                } catch (\Throwable $e) {
                    $skillModels = collect();
                }
            @endphp
            @if($skillModels->count() > 0)
                @foreach($skillModels as $skill)
                    <div class="skills__data">
                        <div class="skills__names">
                            @if(!empty($skill->icon_class))
                                <i class="{{ $skill->icon_class }} skills__icon"></i>
                            @endif
                            <span class="skills__name">{{ $skill->name }}</span>
                        </div>
                        <div class="skills__bar" style="width: {{ (int) $skill->proficiency_percent }}%">
                        </div>
                        <div>
                            <span class="skills__percentage">{{ (int) $skill->proficiency_percent }}%</span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="skills__data">
                    <div class="skills__names">
                        <i class='fa-solid fa-circle-info skills__icon'></i>
                        <span class="skills__name">No skills added yet</span>
                    </div>
                    <div class="skills__bar" style="width: 0%"></div>
                    <div>
                        <span class="skills__percentage">0%</span>
                    </div>
                </div>
            @endif
        </div>
        
        <div>              
            <img src="{{ asset('assets/img/IMG_20231214_030304.jpg') }}" alt="" class="skills__img">
        </div>
    </div>
</section>
@endsection