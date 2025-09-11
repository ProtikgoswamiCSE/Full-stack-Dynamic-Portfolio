<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Models\HomeContent;
use App\Models\SocialMediaLink;
use App\Models\Skill;
use App\Models\Footer;
use App\Models\FooterSocialLink;
use App\Models\Achievement;
use App\Models\Academic;
use App\Models\AboutContent;
use App\Models\ProfileImageSetting;

class ReloadDatabaseData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portfolio:reload-data 
                            {--fresh : Fresh migration and seed}
                            {--clear : Clear all data}
                            {--backup : Create backup before operations}
                            {--restore : Restore from backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload, clear, or backup portfolio database data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Portfolio Data Management Tool');
        $this->line('================================');

        if ($this->option('backup')) {
            $this->createBackup();
            return;
        }

        if ($this->option('restore')) {
            $this->restoreFromBackup();
            return;
        }

        if ($this->option('clear')) {
            if ($this->confirm('⚠️  Are you sure you want to clear ALL data? This cannot be undone!')) {
                $this->clearAllData();
            }
            return;
        }

        if ($this->option('fresh')) {
            if ($this->confirm('⚠️  This will run fresh migrations and seed data. Continue?')) {
                $this->freshMigrationAndSeed();
            }
            return;
        }

        // Default: Reload data with confirmation
        $this->reloadData();
    }

    /**
     * Create database backup
     */
    private function createBackup()
    {
        $this->info('📦 Creating database backup...');
        
        try {
            $timestamp = now()->format('Y-m-d_H-i-s');
            $backupPath = storage_path("app/backups/portfolio_backup_{$timestamp}.json");
            
            // Create backup directory if it doesn't exist
            if (!file_exists(dirname($backupPath))) {
                mkdir(dirname($backupPath), 0755, true);
            }

            // Export data to JSON format (more reliable for SQLite)
            $backupData = [
                'home_contents' => HomeContent::all()->toArray(),
                'social_media_links' => SocialMediaLink::all()->toArray(),
                'skills' => Skill::all()->toArray(),
                'footer' => Footer::all()->toArray(),
                'footer_social_links' => FooterSocialLink::all()->toArray(),
                'achievements' => Achievement::all()->toArray(),
                'academics' => Academic::all()->toArray(),
                'about_contents' => AboutContent::all()->toArray(),
                'profile_image_settings' => ProfileImageSetting::all()->toArray(),
                'created_at' => now()->toISOString()
            ];

            file_put_contents($backupPath, json_encode($backupData, JSON_PRETTY_PRINT));
            
            $this->info("✅ Backup created successfully: {$backupPath}");
        } catch (\Exception $e) {
            $this->error("❌ Backup failed: " . $e->getMessage());
        }
    }

    /**
     * Restore from backup
     */
    private function restoreFromBackup()
    {
        $this->info('🔄 Restoring from backup...');
        
        $backupFiles = glob(storage_path('app/backups/portfolio_backup_*.json'));
        
        if (empty($backupFiles)) {
            $this->error('❌ No backup files found!');
            return;
        }

        // Show available backups
        $this->info('Available backups:');
        foreach ($backupFiles as $index => $file) {
            $this->line(($index + 1) . '. ' . basename($file));
        }

        $choice = $this->ask('Select backup to restore (number)');
        $selectedFile = $backupFiles[$choice - 1] ?? null;

        if (!$selectedFile || !file_exists($selectedFile)) {
            $this->error('❌ Invalid backup selection!');
            return;
        }

        try {
            $backupData = json_decode(file_get_contents($selectedFile), true);
            
            if (!$backupData) {
                $this->error('❌ Invalid backup file format!');
                return;
            }

            // Clear existing data
            $this->clearAllData(false);

            // Restore data
            foreach ($backupData['home_contents'] as $data) {
                unset($data['id']);
                HomeContent::create($data);
            }

            foreach ($backupData['social_media_links'] as $data) {
                unset($data['id']);
                SocialMediaLink::create($data);
            }

            foreach ($backupData['skills'] as $data) {
                unset($data['id']);
                Skill::create($data);
            }

            foreach ($backupData['footer'] as $data) {
                unset($data['id']);
                Footer::create($data);
            }

            foreach ($backupData['footer_social_links'] as $data) {
                unset($data['id']);
                FooterSocialLink::create($data);
            }

            foreach ($backupData['achievements'] as $data) {
                unset($data['id']);
                Achievement::create($data);
            }

            foreach ($backupData['academics'] as $data) {
                unset($data['id']);
                Academic::create($data);
            }

            foreach ($backupData['about_contents'] as $data) {
                unset($data['id']);
                AboutContent::create($data);
            }

            foreach ($backupData['profile_image_settings'] as $data) {
                unset($data['id']);
                ProfileImageSetting::create($data);
            }

            $this->info('✅ Data restored successfully!');
            $this->info("📅 Backup created: {$backupData['created_at']}");
            
        } catch (\Exception $e) {
            $this->error("❌ Restore failed: " . $e->getMessage());
        }
    }

    /**
     * Clear all data
     */
    private function clearAllData($confirm = true)
    {
        if ($confirm && !$this->confirm('⚠️  This will delete ALL portfolio data. Images will be preserved. Continue?')) {
            return;
        }

        $this->info('🗑️  Clearing all data...');

        try {
            // Backup existing images before clearing
            $this->info('📸 Backing up existing images...');
            $imageBackup = $this->backupImages();
            
            DB::transaction(function () {
                HomeContent::truncate();
                SocialMediaLink::truncate();
                Skill::truncate();
                Footer::truncate();
                FooterSocialLink::truncate();
                Achievement::truncate();
                Academic::truncate();
                AboutContent::truncate();
                ProfileImageSetting::truncate();
            });

            // Restore images after clearing
            $this->info('🔄 Restoring images...');
            $this->restoreImages($imageBackup);

            $this->info('✅ All data cleared successfully! Images preserved.');
        } catch (\Exception $e) {
            $this->error("❌ Clear failed: " . $e->getMessage());
        }
    }

    /**
     * Fresh migration and seed
     */
    private function freshMigrationAndSeed()
    {
        $this->info('🔄 Running fresh migrations and seeding...');

        try {
            Artisan::call('migrate:fresh', ['--seed' => true]);
            $this->info('✅ Fresh migration and seeding completed!');
        } catch (\Exception $e) {
            $this->error("❌ Fresh migration failed: " . $e->getMessage());
        }
    }

    /**
     * Reload data with confirmation
     */
    private function reloadData()
    {
        $this->info('🔄 Reloading portfolio data...');

        if ($this->confirm('This will reload all portfolio data. Images will be preserved. Continue?')) {
            try {
                // Backup existing images before reloading
                $this->info('📸 Backing up existing images...');
                $imageBackup = $this->backupImages();
                
                // Run seeders
                Artisan::call('db:seed', ['--class' => 'AdminContentSeeder']);
                
                // Restore images after reloading
                $this->info('🔄 Restoring images...');
                $this->restoreImages($imageBackup);
                
                $this->info('✅ Portfolio data reloaded successfully! Images preserved.');
            } catch (\Exception $e) {
                $this->error("❌ Reload failed: " . $e->getMessage());
            }
        }
    }

    /**
     * Backup all images before data operations
     */
    private function backupImages()
    {
        $imageBackup = [];
        
        try {
            // Backup profile images
            $profileSettings = ProfileImageSetting::all();
            foreach ($profileSettings as $setting) {
                if ($setting->profile_image && \Storage::disk('public')->exists($setting->profile_image)) {
                    $imageBackup['profile'][$setting->id] = [
                        'path' => $setting->profile_image,
                        'content' => \Storage::disk('public')->get($setting->profile_image)
                    ];
                }
            }

            // Backup achievement images
            $achievements = Achievement::all();
            foreach ($achievements as $achievement) {
                if ($achievement->certificate_image && \Storage::disk('public')->exists($achievement->certificate_image)) {
                    $imageBackup['achievements'][$achievement->id] = [
                        'path' => $achievement->certificate_image,
                        'content' => \Storage::disk('public')->get($achievement->certificate_image)
                    ];
                }
            }

            // Backup academic images
            $academics = Academic::all();
            foreach ($academics as $academic) {
                if ($academic->certificate_image && \Storage::disk('public')->exists($academic->certificate_image)) {
                    $imageBackup['academics'][$academic->id] = [
                        'path' => $academic->certificate_image,
                        'content' => \Storage::disk('public')->get($academic->certificate_image)
                    ];
                }
            }

            // Backup about content images
            $aboutContents = AboutContent::all();
            foreach ($aboutContents as $content) {
                if ($content->image && \Storage::disk('public')->exists($content->image)) {
                    $imageBackup['about'][$content->id] = [
                        'path' => $content->image,
                        'content' => \Storage::disk('public')->get($content->image)
                    ];
                }
            }

        } catch (\Exception $e) {
            $this->error('Error backing up images: ' . $e->getMessage());
        }

        return $imageBackup;
    }

    /**
     * Restore images after data operations
     */
    private function restoreImages($imageBackup)
    {
        try {
            // Restore profile images
            if (isset($imageBackup['profile'])) {
                foreach ($imageBackup['profile'] as $id => $imageData) {
                    if (\Storage::disk('public')->exists($imageData['path'])) {
                        continue; // Image already exists
                    }
                    \Storage::disk('public')->put($imageData['path'], $imageData['content']);
                }
            }

            // Restore achievement images
            if (isset($imageBackup['achievements'])) {
                foreach ($imageBackup['achievements'] as $id => $imageData) {
                    if (\Storage::disk('public')->exists($imageData['path'])) {
                        continue; // Image already exists
                    }
                    \Storage::disk('public')->put($imageData['path'], $imageData['content']);
                }
            }

            // Restore academic images
            if (isset($imageBackup['academics'])) {
                foreach ($imageBackup['academics'] as $id => $imageData) {
                    if (\Storage::disk('public')->exists($imageData['path'])) {
                        continue; // Image already exists
                    }
                    \Storage::disk('public')->put($imageData['path'], $imageData['content']);
                }
            }

            // Restore about content images
            if (isset($imageBackup['about'])) {
                foreach ($imageBackup['about'] as $id => $imageData) {
                    if (\Storage::disk('public')->exists($imageData['path'])) {
                        continue; // Image already exists
                    }
                    \Storage::disk('public')->put($imageData['path'], $imageData['content']);
                }
            }

        } catch (\Exception $e) {
            $this->error('Error restoring images: ' . $e->getMessage());
        }
    }
}
