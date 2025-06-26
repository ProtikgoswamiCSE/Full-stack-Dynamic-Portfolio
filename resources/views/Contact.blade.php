@extends('index')
@push('styles')
<title>Contact - Protik Goswami</title>
@section('contact-section')
<!--===== CONTACT =====-->
<section class="contact section" id="contact">
    <h2 class="section-title">Contact</h2>
    <div class="contact__container bd-grid">
        <h1 class="contact__no"><b><u>My Location </u></b></h1>
    </div>

    <div class="contact__container bd-grid">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116800.7806285964!2d90.26781351359263!3d23.817731559856263!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8ada2664e21%3A0x3c872fd17bc11ddb!2sDaffodil%20International%20University!5e0!3m2!1sen!2sbd!4v1720016624011!5m2!1sen!2sbd" width="1000" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

        <h2 class="contact__no">Contuct :01736744140<br>E-mail :goswami15-5841@diu.edu.bd</h2>
        
    </div>

    <div class="contact__container bd-grid">
        <form action="" class="contact__form">
            <input type="text" placeholder="Name" class="contact__input">
            <input type="mail" placeholder="Email" class="contact__input">
            <textarea name="" id="" cols="0" rows="10" class="contact__input"></textarea>
            <input type="button" value="Send" class="contact__button button">
        </form>
    </div>
</section>
</main>
@endsection