<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Work;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $works = [
            [
                'title' => 'Full Stack Developer',
                'company_name' => 'Tech Solutions Inc.',
                'position' => 'Senior Developer',
                'description' => 'Led development of multiple web applications using Laravel, Vue.js, and MySQL. Implemented RESTful APIs and managed database design.',
                'image_url' => 'https://via.placeholder.com/400x200/667eea/ffffff?text=Tech+Solutions',
                'work_url' => 'https://techsolutions.com',
                'start_date' => '2022-01-01',
                'end_date' => '2024-06-30',
                'is_current' => false,
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Redis', 'Docker'],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Frontend Developer',
                'company_name' => 'Digital Agency Co.',
                'position' => 'Lead Frontend Developer',
                'description' => 'Developed responsive web applications and mobile-first designs. Collaborated with design team to create pixel-perfect user interfaces.',
                'image_url' => 'https://via.placeholder.com/400x200/764ba2/ffffff?text=Digital+Agency',
                'work_url' => 'https://digitalagency.com',
                'start_date' => '2020-03-01',
                'end_date' => '2021-12-31',
                'is_current' => false,
                'technologies' => ['React', 'TypeScript', 'SCSS', 'Webpack', 'Jest'],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Software Engineer',
                'company_name' => 'Innovation Labs',
                'position' => 'Software Engineer',
                'description' => 'Currently working on cutting-edge projects involving AI/ML integration, microservices architecture, and cloud deployment.',
                'image_url' => 'https://via.placeholder.com/400x200/667eea/ffffff?text=Innovation+Labs',
                'work_url' => 'https://innovationlabs.com',
                'start_date' => '2024-07-01',
                'end_date' => null,
                'is_current' => true,
                'technologies' => ['Python', 'Django', 'PostgreSQL', 'AWS', 'Docker', 'Kubernetes'],
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($works as $work) {
            Work::create($work);
        }
    }
}