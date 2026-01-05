<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TMDBApiService
{
    protected $apiKey;
    protected $baseUrl;
    protected $imageBaseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.api_key');
        $this->baseUrl = config('services.tmdb.base_url', 'https://api.themoviedb.org/3');
        $this->imageBaseUrl = config('services.tmdb.image_base_url', 'https://image.tmdb.org/t/p');
    }

    /**
     * Search for movies/shows
     */
    public function searchContent($query, $type = 'movie', $page = 1)
    {
        try {
            $response = Http::get("{$this->baseUrl}/search/{$type}", [
                'api_key' => $this->apiKey,
                'query' => $query,
                'page' => $page,
                'language' => 'en-US',
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('TMDB API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('TMDB API Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get trending content
     */
    public function getTrending($type = 'all', $timeWindow = 'day')
    {
        try {
            $response = Http::get("{$this->baseUrl}/trending/{$type}/{$timeWindow}", [
                'api_key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('TMDB Trending API Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get popular content
     */
    public function getPopular($type = 'movie', $page = 1)
    {
        try {
            $response = Http::get("{$this->baseUrl}/{$type}/popular", [
                'api_key' => $this->apiKey,
                'page' => $page,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('TMDB Popular API Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get content details
     */
    public function getContentDetails($id, $type = 'movie')
    {
        try {
            $response = Http::get("{$this->baseUrl}/{$type}/{$id}", [
                'api_key' => $this->apiKey,
                'append_to_response' => 'credits,videos,similar',
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('TMDB Content Details API Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get image URL
     */
    public function getImageUrl($path, $size = 'w500')
    {
        if (!$path) {
            return null;
        }

        return "{$this->imageBaseUrl}/{$size}{$path}";
    }

    /**
     * Get top rated content
     */
    public function getTopRated($type = 'movie', $page = 1)
    {
        try {
            $response = Http::get("{$this->baseUrl}/{$type}/top_rated", [
                'api_key' => $this->apiKey,
                'page' => $page,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('TMDB Top Rated API Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
