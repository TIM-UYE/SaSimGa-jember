<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class GoogleExtractorService
{
    protected string $apiKey;
    protected string $host;
    protected string $businessId;

    public function __construct()
    {
        $this->apiKey = env('RAPIDAPI_KEY', '');
        $this->host = env('RAPIDAPI_HOST', 'google-maps-extractor2.p.rapidapi.com');
        $this->businessId = env('RAPIDAPI_BUSINESS_ID', '');
    }

    /**
     * Fetch reviews from RapidAPI Google Maps extractor
     * Returns a Collection of normalized reviews or empty collection on failure.
     */
    public function getReviews(int $limit = 6): Collection
    {
        if (empty($this->apiKey) || empty($this->businessId)) {
            return collect();
        }

        $cacheKey = 'rapidapi_google_reviews_' . md5($this->businessId);

        $result = Cache::remember($cacheKey, 60 * 60, function () use ($limit) {
            $url = "https://{$this->host}/business_reviews";

            $response = Http::withHeaders([
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->apiKey,
            ])->get($url, [
                'business_id' => $this->businessId,
                'lang' => 'id',
                'limit' => $limit,
            ]);

            if (! $response->ok()) {
                return [];
            }

            $json = $response->json();

            $items = data_get($json, 'data', []);

            return collect($items)->map(function ($r) {
                return [
                    'author_name' => data_get($r, 'user_name', 'Anonymous'),
                    'text' => data_get($r, 'text', ''),
                    'rating' => (int) data_get($r, 'rating', 0),
                    'profile_photo_url' => data_get($r, 'user_avatar') ?: asset('images/avatar-default.png'),
                    'relative_time_description' => data_get($r, 'time', ''),
                    'source' => 'Google',
                ];
            })->take($limit)->toArray();
        });

        return collect($result);
    }
}
