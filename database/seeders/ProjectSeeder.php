<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'E-Commerce Platform',
                'description' => 'A full-stack e-commerce platform built with Laravel and Vue.js, featuring user authentication, product management, shopping cart, and payment integration.',
                'image_url' => 'https://img.freepik.com/free-photo/boy-taking-picture_23-2148011872.jpg?semt=ais_hybrid&w=740',
                'project_url' => 'https://github.com/protikgoswami/ecommerce-platform',
                'github_url' => 'https://github.com/protikgoswami/ecommerce-platform',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Bootstrap', 'Stripe API'],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Portfolio Website',
                'description' => 'A dynamic portfolio website with admin panel for content management, built with Laravel and modern CSS.',
                'image_url' => 'https://media.istockphoto.com/id/1180778899/photo/young-woman-taking-a-pictures.jpg?s=170667a&w=0&k=20&c=nryzlDE3twbNsokiX6p0xlsOyQmU1TYrYDOdd182wcY=',
                'project_url' => 'https://protikgoswami.com',
                'github_url' => 'https://github.com/protikgoswami/portfolio',
                'technologies' => ['Laravel', 'PHP', 'CSS3', 'JavaScript', 'MySQL'],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Task Management App',
                'description' => 'A collaborative task management application with real-time updates, team collaboration features, and project tracking.',
                'image_url' => 'https://www.shutterstock.com/image-photo/smiling-young-woman-using-camera-260nw-679625758.jpg',
                'project_url' => 'https://github.com/protikgoswami/task-manager',
                'github_url' => 'https://github.com/protikgoswami/task-manager',
                'technologies' => ['React', 'Node.js', 'MongoDB', 'Socket.io', 'Express'],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Weather Dashboard',
                'description' => 'A responsive weather dashboard that displays current weather conditions and forecasts using multiple weather APIs.',
                'image_url' => 'https://img.freepik.com/free-photo/boy-taking-picture_23-2148011872.jpg?semt=ais_hybrid&w=740',
                'project_url' => 'https://github.com/protikgoswami/weather-dashboard',
                'github_url' => 'https://github.com/protikgoswami/weather-dashboard',
                'technologies' => ['JavaScript', 'HTML5', 'CSS3', 'Weather API', 'Chart.js'],
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Blog CMS',
                'description' => 'A content management system for blogs with rich text editor, comment system, and SEO optimization features.',
                'image_url' => 'https://media.istockphoto.com/id/1180778899/photo/young-woman-taking-a-pictures.jpg?s=170667a&w=0&k=20&c=nryzlDE3twbNsokiX6p0xlsOyQmU1TYrYDOdd182wcY=',
                'project_url' => 'https://github.com/protikgoswami/blog-cms',
                'github_url' => 'https://github.com/protikgoswami/blog-cms',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'TinyMCE', 'SEO'],
                'order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Social Media Analytics',
                'description' => 'An analytics dashboard for social media metrics with data visualization and reporting features.',
                'image_url' => 'https://www.shutterstock.com/image-photo/smiling-young-woman-using-camera-260nw-679625758.jpg',
                'project_url' => 'https://github.com/protikgoswami/social-analytics',
                'github_url' => 'https://github.com/protikgoswami/social-analytics',
                'technologies' => ['Python', 'Django', 'PostgreSQL', 'D3.js', 'REST API'],
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}