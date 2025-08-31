<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AboutContent;

class AboutContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aboutContents = [
            [
                'section' => 'main',
                'title' => "I'am Protik",
                'content' => "I am curious and adventurous individual with a passion for programming and exploring new things. I find joy in the endless possibilities that provides, and love to challenge myself with complex problems. I also enjoy traveling and immersing myself in nature to experience different cultures and environments. My inquisitive nature fuels, desire to learn and grow, and i always seeking out new experiences to broaden my horizons.\n\nHello there\nI stand before you today to present about summary of my professional journey and my unyielding passion for learning and embracing new technologies. I am currently studying Daffodil International University, where I specialized in Computer Science and Engineering within the Faculty of Science and Information Technology.\n\nThroughout my academic years, I have acquired a diverse range of skills and expertise. I have completed comprehensive courses in web development, cyber security, and Python programming. Additionally, I have delved into the intricacies of network security through Cisco's esteemed certification program.\n\nIn conclusion, I humbly present myself as an enthusiastic and dedicated individual, ready to take on new challenges and make a positive impact in the realm of AI.",
                'image' => 'assets/img/About11.jpg',
                'order' => 1,
                'is_active' => true
            ],
            [
                'section' => 'ai',
                'title' => 'Artificial Intelligence',
                'content' => 'Modern era artificial intelligence research focuses on advancing machine learning algorithms and deep neural networks to develop highly intelligent systems capable of complex tasks, such as natural language processing, computer vision, and decision-making, driving innovation across various industries.',
                'image' => 'assets/img/ttt.gif',
                'order' => 2,
                'is_active' => true
            ],
            [
                'section' => 'programming',
                'title' => 'Programming Specialization',
                'content' => 'Programming refers to the process of creating and designing sets of instructions, known as code, that are executed by a computer to perform specific tasks, solve problems, or build software applications. It involves writing, debugging, and maintaining code in various programming languages to achieve desired functionality and automate processes.',
                'image' => 'assets/img/0_NgUtI3tYLhuq5Vy0.gif',
                'order' => 3,
                'is_active' => true
            ],
            [
                'section' => 'cybersecurity',
                'title' => 'Cyber Security',
                'content' => 'Cyber security research aims to develop advanced threat detection and prevention techniques, leveraging artificial intelligence, machine learning, and big data analytics to mitigate evolving cyber threats and protect sensitive information from unauthorized access, ensuring the integrity, confidentiality, and availability of digital systems and networks.',
                'image' => 'assets/img/Cyber Security.gif',
                'order' => 4,
                'is_active' => true
            ]
        ];

        foreach ($aboutContents as $content) {
            AboutContent::create($content);
        }
    }
}
