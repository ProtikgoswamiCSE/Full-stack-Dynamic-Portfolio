<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeContent;
use App\Models\SocialMediaLink;
use App\Models\Skill;
use App\Models\Footer;
use App\Models\FooterSocialLink;
use App\Models\Achievement;
use App\Models\Academic;

class AdminContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Initialize Home Content
        $this->initializeHomeContent();
        
        // Initialize Social Media Links
        $this->initializeSocialMediaLinks();
        
        // Initialize Skills
        $this->initializeSkills();
        
        // Initialize Footer
        $this->initializeFooter();
        
        // Initialize Footer Social Links
        $this->initializeFooterSocialLinks();
        
        // Initialize Achievements
        $this->initializeAchievements();
        
        // Initialize Academics
        $this->initializeAcademics();
    }

    private function initializeHomeContent()
    {
        $sections = [
            'title' => '<h1>Welcome to My Portfolio</h1><p>Full-Stack Developer & Creative Problem Solver</p>',
            'subtitle' => 'Passionate about creating innovative web solutions',
            'skills_list' => "* HTML/CSS\n* JavaScript\n* PHP/Laravel\n* MySQL\n* React.js\n* Node.js",
            'contact_button_text' => 'Get In Touch'
        ];

        foreach ($sections as $section => $content) {
            HomeContent::updateOrCreate(
                ['section' => $section],
                ['content' => $content]
            );
        }
    }

    private function initializeSocialMediaLinks()
    {
        $socialLinks = [
            [
                'platform' => 'github',
                'name' => 'GitHub',
                'icon_class' => 'fa-brands fa-github',
                'url' => 'https://github.com/yourusername',
                'order' => 1,
                'is_active' => true
            ],
            [
                'platform' => 'linkedin',
                'name' => 'LinkedIn',
                'icon_class' => 'fa-brands fa-linkedin',
                'url' => 'https://linkedin.com/in/yourusername',
                'order' => 2,
                'is_active' => true
            ],
            [
                'platform' => 'twitter',
                'name' => 'Twitter',
                'icon_class' => 'fa-brands fa-twitter',
                'url' => 'https://twitter.com/yourusername',
                'order' => 3,
                'is_active' => true
            ]
        ];

        foreach ($socialLinks as $link) {
            SocialMediaLink::updateOrCreate(
                ['platform' => $link['platform']],
                $link
            );
        }
    }

    private function initializeSkills()
    {
        $skills = [
            ['name' => 'HTML/CSS', 'icon_class' => 'fa-brands fa-html5', 'proficiency_percent' => 95, 'order' => 1],
            ['name' => 'JavaScript', 'icon_class' => 'fa-brands fa-js', 'proficiency_percent' => 90, 'order' => 2],
            ['name' => 'PHP/Laravel', 'icon_class' => 'fa-brands fa-php', 'proficiency_percent' => 85, 'order' => 3],
            ['name' => 'MySQL', 'icon_class' => 'fas fa-database', 'proficiency_percent' => 80, 'order' => 4],
            ['name' => 'React.js', 'icon_class' => 'fa-brands fa-react', 'proficiency_percent' => 75, 'order' => 5],
            ['name' => 'Node.js', 'icon_class' => 'fa-brands fa-node-js', 'proficiency_percent' => 70, 'order' => 6]
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                array_merge($skill, ['is_active' => true])
            );
        }
    }

    private function initializeFooter()
    {
        Footer::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Portfolio',
                'description' => 'Full-Stack Developer Portfolio',
                'copyright_text' => '© 2024 All rights reserved.',
                'facebook_url' => 'https://facebook.com/yourusername',
                'twitter_url' => 'https://twitter.com/yourusername',
                'linkedin_url' => 'https://linkedin.com/in/yourusername',
                'github_url' => 'https://github.com/yourusername',
                'instagram_url' => 'https://instagram.com/yourusername',
                'is_active' => true
            ]
        );
    }

    private function initializeFooterSocialLinks()
    {
        $footerLinks = [
            [
                'platform' => 'facebook',
                'url' => 'https://facebook.com/yourusername',
                'order' => 1,
                'is_active' => true
            ],
            [
                'platform' => 'twitter',
                'url' => 'https://twitter.com/yourusername',
                'order' => 2,
                'is_active' => true
            ],
            [
                'platform' => 'linkedin',
                'url' => 'https://linkedin.com/in/yourusername',
                'order' => 3,
                'is_active' => true
            ],
            [
                'platform' => 'github',
                'url' => 'https://github.com/yourusername',
                'order' => 4,
                'is_active' => true
            ]
        ];

        foreach ($footerLinks as $link) {
            FooterSocialLink::updateOrCreate(
                ['platform' => $link['platform']],
                $link
            );
        }
    }

    private function initializeAchievements()
    {
        $achievements = [
            [
                'title' => 'Web Development Certification',
                'description' => 'Certified Full-Stack Web Developer',
                'certificate_url' => 'https://example.com/certificate1',
                'order' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Laravel Framework Expert',
                'description' => 'Advanced Laravel Development Certification',
                'certificate_url' => 'https://example.com/certificate2',
                'order' => 2,
                'is_active' => true
            ],
            [
                'title' => 'React.js Mastery',
                'description' => 'Modern React Development Certification',
                'certificate_url' => 'https://example.com/certificate3',
                'order' => 3,
                'is_active' => true
            ]
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['title' => $achievement['title']],
                $achievement
            );
        }
    }

    private function initializeAcademics()
    {
        $academics = [
            [
                'institution_name' => 'S.R Patory Quality Educare Institute',
                'degree_title' => 'Secondary School Certificate',
                'field_of_study' => 'Science',
                'start_year' => 2018,
                'end_year' => 2019,
                'description' => 'Group: Science',
                'certificate_url' => 'https://example.com/ssc',
                'order' => 1,
                'is_active' => true
            ],
            [
                'institution_name' => 'Sristy College of Tangail',
                'degree_title' => 'Higher Secondary School Certificate',
                'field_of_study' => 'Science',
                'start_year' => 2019,
                'end_year' => 2020,
                'description' => 'Group: Science',
                'certificate_url' => 'https://example.com/hsc',
                'order' => 2,
                'is_active' => true
            ],
            [
                'institution_name' => 'Daffodil International University',
                'degree_title' => 'Bachelor of Science',
                'field_of_study' => 'Computer Science and Engineering',
                'start_year' => 2021,
                'end_year' => 2024,
                'description' => 'Computer Science and Engineering',
                'certificate_url' => 'https://example.com/bsc',
                'order' => 3,
                'is_active' => true
            ]
        ];

        foreach ($academics as $academic) {
            Academic::updateOrCreate(
                ['institution_name' => $academic['institution_name']],
                $academic
            );
        }
    }
}
