<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Show;
use App\Models\Episode;

class ShowsTableSeeder extends Seeder
{
    public function run()
    {
        $showsData = [
            [
                'title' => 'Friends',
                'description' => 'Sitcom about six friends living in New York City',
                'airing_time' => 'Mondays @ 8:00 PM',
                'episodes' => 5,
            ],
            [
                'title' => 'Breaking Bad',
                'description' => 'A high school chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine',
                'airing_time' => 'Sundays @ 10:00 PM',
                'episodes' => 5,
            ],
            [
                'title' => 'Game of Thrones',
                'description' => 'Nine noble families fight for control over the lands of Westeros',
                'airing_time' => 'Sundays @ 9:00 PM',
                'episodes' => 5,
            ],
            [
                'title' => 'Stranger Things',
                'description' => 'When a young boy disappears, his mother, a police chief, and his friends must confront terrifying supernatural forces',
                'airing_time' => 'Fridays @ 8:00 PM',
                'episodes' => 5,
            ],
            [
                'title' => 'The Mandalorian',
                'description' => 'The travels of a lone bounty hunter in the outer reaches of the galaxy',
                'airing_time' => 'Fridays @ 11:00 PM',
                'episodes' => 5,
            ],
        ];

        foreach ($showsData as $showData) {
            $show = Show::create([
                'title' => $showData['title'],
                'description' => $showData['description'],
                'airing_time' => $showData['airing_time'],
            ]);

            for ($i = 1; $i <= $showData['episodes']; $i++) {
                Episode::create([
                    'show_id' => $show->id,
                    'title' => "Episode {$i}",
                    'description' => "Description for episode {$i} of {$showData['title']}",
                    'duration' => rand(25, 50),
                    'airing_time' => "Monday @ 8:30 PM",
                    'video_url' => null,
                    'youtube_video_id' => null,
                ]);
            }
        }

        $this->command->info('Shows seeded successfully!');
    }
}
