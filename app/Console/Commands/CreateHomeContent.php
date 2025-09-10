<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HomeContent;

class CreateHomeContent extends Command
{
    protected $signature = 'home:create-content';
    protected $description = 'Create default home content';

    public function handle()
    {
        $this->info('Creating home content...');
        
        // Create home content sections
        $sections = [
            'title' => 'Hi there,<br>I\'m <span class="home__title-color">Protik Goswami</span><br>Web Designer',
            'subtitle' => 'Passionate about creating amazing web experiences',
            'skills_list' => "* Network Security Specialist\n* Programming\n* UI/UX Design\n* Artificial Intelligence",
            'contact_button_text' => 'Contact'
        ];

        foreach ($sections as $section => $content) {
            HomeContent::updateOrCreate(
                ['section' => $section],
                ['content' => $content]
            );
            $this->info("Created section: {$section}");
        }

        $this->info('Home content created successfully!');
    }
}