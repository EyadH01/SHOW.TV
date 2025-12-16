<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Show;
use App\Models\Episode;

class AddEpisodeFromYoutube extends Command
{
    protected $signature = 'episode:add-youtube 
                          {show_id : The ID of the show}
                          {title : Episode title}
                          {youtube_id : YouTube video ID}
                          {--description= : Episode description}
                          {--duration=45 : Duration in minutes}
                          {--airing_time=Monday @ 8:00 PM : Airing time}';

    protected $description = 'Add an episode from a YouTube video ID with auto-generated thumbnail';

    public function handle()
    {
        $showId = $this->argument('show_id');
        $title = $this->argument('title');
        $youtubeId = $this->argument('youtube_id');
        $description = $this->option('description') ?: "Episode: $title";
        $duration = $this->option('duration');
        $airingTime = $this->option('airing_time');

        // Verify show exists
        $show = Show::find($showId);
        if (!$show) {
            $this->error("Show with ID $showId not found!");
            return 1;
        }

        // Create episode
        $episode = Episode::create([
            'show_id' => $showId,
            'title' => $title,
            'description' => $description,
            'duration' => $duration,
            'airing_time' => $airingTime,
            'youtube_video_id' => $youtubeId,
            'video_url' => "https://www.youtube.com/embed/$youtubeId",
            'thumbnail' => "https://img.youtube.com/vi/$youtubeId/maxresdefault.jpg",
        ]);

        $this->info("✅ Episode added successfully!");
        $this->info("Show: {$show->title}");
        $this->info("Title: {$episode->title}");
        $this->info("YouTube ID: {$youtubeId}");
        $this->info("Thumbnail: {$episode->thumbnail}");
        $this->info("ID: {$episode->id}");

        return 0;
    }
}
