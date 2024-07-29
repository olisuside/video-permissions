<?php

// database/seeders/VideoSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Video;

class VideoSeeder extends Seeder
{
    public function run()
    {
        Video::create([
            'title' => 'Sample Video 1',
            'description' => 'This is a description for sample video 1.',
            'url' => 'https://example.com/sample-video-1.mp4',
        ]);

        Video::create([
            'title' => 'Sample Video 2',
            'description' => 'This is a description for sample video 2.',
            'url' => 'https://example.com/sample-video-2.mp4',
        ]);

        // Tambahkan lebih banyak video jika diperlukan
    }
}

