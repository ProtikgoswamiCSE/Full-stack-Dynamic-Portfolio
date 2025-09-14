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
                'image_url' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=400&h=300&fit=crop',
                'project_url' => 'https://github.com/protikgoswami/ecommerce-platform',
                'github_url' => 'https://github.com/protikgoswami/ecommerce-platform',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Bootstrap', 'Stripe API'],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Portfolio Website',
                'description' => 'A dynamic portfolio website with admin panel for content management, built with Laravel and modern CSS.',
                'image_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=300&fit=crop',
                'project_url' => 'https://protikgoswami.com',
                'github_url' => 'https://github.com/protikgoswami/portfolio',
                'technologies' => ['Laravel', 'PHP', 'CSS3', 'JavaScript', 'MySQL'],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Task Management App',
                'description' => 'A collaborative task management application with real-time updates, team collaboration features, and project tracking.',
                'image_url' => 'https://images.unsplash.com/photo-1611224923853-80b023f02d71?w=400&h=300&fit=crop',
                'project_url' => 'https://github.com/protikgoswami/task-manager',
                'github_url' => 'https://github.com/protikgoswami/task-manager',
                'technologies' => ['React', 'Node.js', 'MongoDB', 'Socket.io', 'Express'],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Weather Dashboard',
                'description' => 'A responsive weather dashboard that displays current weather conditions and forecasts using multiple weather APIs.',
                'image_url' => 'https://images.unsplash.com/photo-1504608524841-42fe6f032b4b?w=400&h=300&fit=crop',
                'project_url' => 'https://github.com/protikgoswami/weather-dashboard',
                'github_url' => 'https://github.com/protikgoswami/weather-dashboard',
                'technologies' => ['JavaScript', 'HTML5', 'CSS3', 'Weather API'],
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Blog CMS',
                'description' => 'A content management system for blogs with rich text editor, comment system, and SEO optimization features.',
                'image_url' => 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=400&h=300&fit=crop',
                'project_url' => 'https://github.com/protikgoswami/blog-cms',
                'github_url' => 'https://github.com/protikgoswami/blog-cms',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'TinyMCE', 'SEO'],
                'order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Social Media Analytics',
                'description' => 'An analytics dashboard for social media metrics with data visualization and reporting features.',
                'image_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&h=300&fit=crop',
                'project_url' => 'https://github.com/protikgoswami/social-analytics',
                'github_url' => 'https://github.com/protikgoswami/social-analytics',
                'technologies' => ['Python', 'Django', 'PostgreSQL', 'D3.js'],
                'order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'AI Chat Application',
                'description' => 'A real-time chat application with AI integration, featuring smart responses and conversation analytics.',
                'image_url' => 'https://images.unsplash.com/photo-1577563908411-5077b6dc7624?w=400&h=300&fit=crop',
                'project_url' => 'https://github.com/protikgoswami/ai-chat-app',
                'github_url' => 'https://github.com/protikgoswami/ai-chat-app',
                'technologies' => ['React', 'Node.js', 'OpenAI API', 'Socket.io', 'MongoDB'],
                'order' => 7,
                'is_active' => true,
            ],
            [
                'title' => 'Cryptocurrency Tracker',
                'description' => 'A real-time cryptocurrency price tracker with portfolio management and price alerts.',
                'image_url' => 'https://images.unsplash.com/photo-1621761191319-c6fb62004040?w=400&h=300&fit=crop',
                'project_url' => 'https://github.com/protikgoswami/crypto-tracker',
                'github_url' => 'https://github.com/protikgoswami/crypto-tracker',
                'technologies' => ['Vue.js', 'Express', 'CoinGecko API', 'Chart.js', 'PostgreSQL'],
                'order' => 8,
                'is_active' => true,
            ],
            [
                'title' => 'Recipe Sharing Platform',
                'description' => 'A community-driven recipe sharing platform with rating system, meal planning, and grocery lists.',
                'image_url' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400&h=300&fit=crop',
                'project_url' => 'https://github.com/protikgoswami/recipe-platform',
                'github_url' => 'https://github.com/protikgoswami/recipe-platform',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'Vue.js', 'Cloudinary'],
                'order' => 9,
                'is_active' => true,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}