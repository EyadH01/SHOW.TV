<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleImagesApiService
{
    protected $apiKey;
    protected $searchEngineId;

    public function __construct()
    {
        $this->apiKey = config('services.google.images_api_key');
        $this->searchEngineId = config('services.google.search_engine_id');
    }

    /**
     * Search for images
     */
    public function searchImages($query, $start = 1, $numResults = 10)
    {
        try {
            if (!$this->apiKey || !$this->searchEngineId) {
                Log::warning('Google Images API credentials not configured');
                return null;
            }

            $response = Http::get('https://www.googleapis.com/customsearch/v1', [
                'key' => $this->apiKey,
                'cx' => $this->searchEngineId,
                'q' => $query,
                'searchType' => 'image',
                'start' => $start,
                'num' => $numResults,
                'safe' => 'active',
                'fileType' => 'jpg|png|gif',
                'imgSize' => 'large',
                'imgType' => 'photo',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Transform the response to include formatted URLs
                if (isset($data['items'])) {
                    foreach ($data['items'] as &$item) {
                        $item['formatted_url'] = $item['link'] ?? '';
                        $item['formatted_display_link'] = $item['displayLink'] ?? '';
                        $item['thumb_height'] = $item['image']['height'] ?? 0;
                        $item['thumb_width'] = $item['image']['width'] ?? 0;
                    }
                }

                return $data;
            }

            Log::error('Google Images API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Google Images API Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Search for specific image types
     */
    public function searchMovieImages($movieTitle, $year = null, $type = 'poster')
    {
        $query = "{$movieTitle} {$year} {$type} movie";
        if ($type === 'backdrop') {
            $query = "{$movieTitle} {$year} movie wallpaper backdrop";
        }

        return $this->searchImages($query);
    }

    /**
     * Search for TV show images
     */
    public function searchTvImages($showTitle, $year = null, $type = 'poster')
    {
        $query = "{$showTitle} {$year} tv show {$type}";
        if ($type === 'backdrop') {
            $query = "{$showTitle} {$year} tv show wallpaper backdrop";
        }

        return $this->searchImages($query);
    }

    /**
     * Get random image from search results
     */
    public function getRandomImage($query, $type = 'poster')
    {
        $results = $this->searchImages($query, 1, 10);
        
        if ($results && isset($results['items']) && count($results['items']) > 0) {
            $randomIndex = array_rand($results['items']);
            return $results['items'][$randomIndex];
        }

        return null;
    }

    /**
     * Validate image URL
     */
    public function validateImageUrl($url)
    {
        try {
            $response = Http::head($url, [
                'timeout' => 10,
                'verify' => false,
            ]);

            return $response->successful() && 
                   strpos($response->header('Content-Type'), 'image/') === 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Download and store image
     */
    public function downloadImage($url, $filename)
    {
        try {
            $response = Http::timeout(30)->get($url);
            
            if ($response->successful()) {
                $imagePath = "show-images/{$filename}";
                \Illuminate\Support\Facades\Storage::disk('public')->put($imagePath, $response->body());
                return $imagePath;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Image download failed', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Search for actor images
     */
    public function searchActorImages($actorName)
    {
        $query = "{$actorName} actor headshot photo";
        return $this->searchImages($query, 1, 5);
    }

    /**
     * Get high quality movie poster
     */
    public function getHighQualityPoster($movieTitle, $year = null)
    {
        $query = "{$movieTitle} {$year} movie poster high quality";
        return $this->getRandomImage($query, 'poster');
    }

    /**
     * Get movie backdrop/wallpaper
     */
    public function getMovieBackdrop($movieTitle, $year = null)
    {
        $query = "{$movieTitle} {$year} movie backdrop wallpaper hd";
        return $this->getRandomImage($query, 'backdrop');
    }
}
