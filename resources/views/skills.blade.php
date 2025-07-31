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
            <p class="skills__text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Velit optio id vero amet, alias architecto consectetur error eum eaque sit.</p>
            <div class="skills__data">
                <div class="skills__names">
                    <i class='fa-brands fa-html5 skills__icon'></i>
                    <span class="skills__name">HTML,CSS,JS</span>
                </div>
                <div class="skills__bar skills__html">

                </div>
                <div>
                    <span class="skills__percentage">85%</span>
                </div>
            </div>
            <div class="skills__data">
                <div class="skills__names">
                    <i class='fa-brands fa-c skills__icon'></i>
                    <span class="skills__name">C,C++</span>
                </div>
                <div class="skills__bar skills__c-plus-plus">
                    
                </div>
                <div>
                    <span class="skills__percentage">95%</span>
                </div>
            </div>
            <div class="skills__data">
                <div class="skills__names">
                    <i class="fa-brands fa-python skills__icon"></i>
                    <span class="skills__name">Python</span>
                </div>
                <div class="skills__bar skills__python">
                    
                </div>
                <div>
                    <span class="skills__percentage">65%</span>
                </div>
            </div>
            <div class="skills__data">
                <div class="skills__names">
                    <i class="fa-brands fa-js skills__icon"></i>
                    <span class="skills__name">JS</span>
                </div>
                <div class="skills__bar skills__js">
                    
                </div>
                <div>
                    <span class="skills__percentage">40%</span>
                </div>
            </div>
            <div class="skills__data">
                <div class="skills__names">
                    <i class="fa-brands fa-uikit skills__icon"></i>
                    <span class="skills__name">UX/UI</span>
                </div>
                <div class="skills__bar skills__ux">
                    
                </div>
                <div>
                    <span class="skills__percentage">98%</span>
                </div>
            </div>
        </div>
        
        <div>              
            <img src="{{ asset('assets/img/IMG_20231214_030304.jpg') }}" alt="" class="skills__img">
        </div>
    </div>
</section>
@endsection