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
                'title' => 'Deadpool & Wolverine',
                'description' => 'This is a description for sample video 1.',
                'url' => 'https://www.youtube.com/watch?v=Idh8n5XuYIA&ab_channel=MarvelEntertainment', 
            ],
            [
                'title' => 'Venom: The Last Dance',
                'description' => 'This is a description for sample video 2.',
                'url' => 'https://www.youtube.com/watch?v=STScKOUpXR8&ab_channel=MarvelEntertainment', 
            ],
            [
                'title' => 'Joker: Folie À Deux',
                'description' => 'This is a description for sample video 3.',
                'url' => 'https://www.youtube.com/watch?v=_OKAwz2MsJs&ab_channel=WarnerBros.Pictures', 
            ],
            [
                'title' => 'TRANSFORMERS ONE',
                'description' => 'This is a description for sample video 4.',
                'url' => 'https://www.youtube.com/watch?v=u2NuUWuwPCM&ab_channel=ParamountPictures', 
            ],
            [
                'title' => 'Despicable Me 4',
                'description' => 'This is a description for sample video 5.',
                'url' => 'https://www.youtube.com/watch?v=LtNYaH61dXY&ab_channel=Illumination', 
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


