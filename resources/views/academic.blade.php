@extends('index')
@push('styles')
<title>Academic - Protik Goswami</title>
@section('academic-section')
<!--===== Academic =====-->
<section class="about section " id="Academic">
    <h2 class="section-title">Academic</h2>


    <div class="about__container bd-grid">
        <div class="about__img">
            <img src="{{ asset('assets/img/SRP.jpg') }}" alt="">
        </div>
        
        <div>
            <h2 class="about__subtitle"> <b>S.R Patory Quality Educare Institute</b></h2>
            <p class="about__text">Secondary School Certificate <br>Group :Science <br>Year:2018-19</p> 
        </div>                                   
    </div>
    <div class="about__container bd-grid">
        <div class="about__img">
            <img src="{{ asset('assets/img/sristy.png') }}" alt="">
        </div>
        
        <div>
            <h2 class="about__subtitle"> <b>Sristy College of Tangail </b></h2>
            <p class="about__text">Higher Secondary School Certificate <br>Group: science <br>year:2019-20</p> 
        </div>                                   
    </div>
    <div class="about__container bd-grid">
        <div class="about__img">
            <img src="{{ asset('assets/img/VID_20231002_115152.jpg') }}" alt="">
        </div>
        
        <div>
            <h2 class="about__subtitle"> <b>Daffodil International University </b></h2>
            <p class="about__text">Computer Science and Engineering <br>Year:2021-2024 </p>
        </div>                                   
    </div>
</section>
@endsection