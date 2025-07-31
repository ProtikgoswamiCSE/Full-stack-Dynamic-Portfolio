@extends('index')
@push('styles')
<title>About - Protik Goswami</title>
@section('about-section')
<!--===== ABOUT =====-->
<section class="about section " id="about">
    <h2 class="section-title">About</h2>

    <div class="about__container bd-grid">
        <div class="about__img">
            <img src="{{ asset('assets/img/About11.jpg') }}" alt="">
        </div>
        
        <div>
            <h2 class="about__subtitle">I'am Protik</h2>
            <p class="about__text"> <>  I am curious and adventurous individual with a passion for programming and exploring new things. I find joy in the endless possibilities that provides, and love to challenge myself with complex problems. I also enjoy traveling and immersing myself in nature to experience different cultures and environments. My inquisitive nature fuels, desire to learn and grow, and i always seeking out new experiences to broaden my horizons.  <>  </p>
            <p class="about__text"><b>Hello there </b><br>I stand before you today to present about summary of my professional journey and my unyielding passion for learning and embracing new technologies. I am currently  studying  Daffodil International University, where I specialized in Computer Science and Engineering within the Faculty of Science and Information Technology.</p>  
            <p class="about__text"><b>Throughout</b> my academic years, I have acquired a diverse range of skills and expertise. I have completed comprehensive courses in web development, cyber security, and Python programming. Additionally, I have delved into the intricacies of network security through Cisco's esteemed certification program.   </p>  
            <p class="about__text">In conclusion, I humbly present myself as an enthusiastic and dedicated individual, ready to take on new challenges and make a positive impact in the realm of AI.                          </p>       
        </div>                                   
    </div>
    <div class="about__container bd-grid">
        <div class="about__img">
            <img src="{{ asset('assets/img/ttt.gif') }}" alt="">
        </div>
        
        <div>
            <h2 class="about__subtitle"> <b> <u>Artificial Intelligence </u></b></h2>
            <p class="about__text">Modern era artificial intelligence research focuses on advancing machine learning algorithms and deep neural networks to develop highly intelligent systems capable of complex tasks, such as natural language processing, computer vision, and decision-making, driving innovation across various industries. </p> 
        </div>                                   
    </div>
    <div class="about__container bd-grid">
        <div class="about__img">
            <img src="{{ asset('assets/img/0_NgUtI3tYLhuq5Vy0.gif') }}" alt="">
        </div>
        
        <div>
            <h2 class="about__subtitle"> <b> <u>Programming Specilization  </u>    </b></h2>
            <p class="about__text">Programming refers to the process of creating and designing sets of instructions, known as code, that are executed by a computer to perform specific tasks, solve problems, or build software applications. It involves writing, debugging, and maintaining code in various programming languages to achieve desired functionality and automate processes.</p> 
        </div>                                   
    </div>
    <div class="about__container bd-grid">
        <div class="about__img">
            <img src="{{ asset('assets/img/Cyber Security.gif') }}" alt="">
        </div>
        
        <div>
            <h2 class="about__subtitle"> <b> <u>Cyber Security  </u>    </b></h2>
            <p class="about__text">Cyber security research aims to develop advanced threat detection and prevention techniques, leveraging artificial intelligence, machine learning, and big data analytics to mitigate evolving cyber threats and protect sensitive information from unauthorized access, ensuring the integrity, confidentiality, and availability of digital systems and networks.  
            </p> 
        </div>                                   
    </div>
</section>

@endsection