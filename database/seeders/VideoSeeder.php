<?php
// database/seeders/VideoSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Video;

class VideoSeeder extends Seeder
{
    public function run()
    {
        // Fungsi untuk mengonversi URL YouTube menjadi embed URL
        function convertToEmbedUrl($url)
        {
            $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
            preg_match($pattern, $url, $matches);
            $videoId = $matches[1] ?? null;

            return $videoId ? 'https://www.youtube.com/embed/' . $videoId : $url;
        }

        // Fungsi untuk mendapatkan URL thumbnail dari URL YouTube
        function getThumbnailUrl($url)
        {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $matches);
            $videoId = $matches[1] ?? null;

            return $videoId ? 'https://img.youtube.com/vi/' . $videoId . '/maxresdefault.jpg' : null;
        }

        $videos = [
            [
                'title' => 'Sample Video 1',
                'description' => 'This is a description for sample video 1.',
                'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Ganti dengan URL video YouTube nyata
            ],
            [
                'title' => 'Sample Video 2',
                'description' => 'This is a description for sample video 2.',
                'url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0', // Ganti dengan URL video YouTube nyata
            ],
            // Tambahkan lebih banyak video jika diperlukan
        ];

        foreach ($videos as $videoData) {
            $videoData['url'] = convertToEmbedUrl($videoData['url']);
            $videoData['thumbnail'] = getThumbnailUrl($videoData['url']);

            Video::create($videoData);
        }
    }
}


