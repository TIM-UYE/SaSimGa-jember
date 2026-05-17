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
     * Normalize review item
     */
    protected function normalizeReview(array $r): array
    {
        return [
            'author_name' => data_get($r, 'user_name', 'Anonymous'),
            'text' => data_get($r, 'text', ''),
            'rating' => (int) data_get($r, 'rating', 0),
            'profile_photo_url' => data_get($r, 'user_avatar')
                ?: asset('images/avatar-default.png'),

            'relative_time_description' => data_get($r, 'time', ''),
            'source' => 'Google',
        ];
    }

    /**
     * Get limited reviews
     */
    public function getReviews(int $limit = 6): Collection
    {
        return $this->getAllReviews()->take($limit);
    }

    /**
     * Fetch ALL reviews with pagination support
     */
    public function getAllReviews(): Collection
{
    if (empty($this->apiKey) || empty($this->businessId)) {
        return collect();
    }

    $cacheKey = 'rapidapi_google_reviews_all_' . md5($this->businessId);

    $result = Cache::remember($cacheKey, now()->addHour(), function () {

        $url = "https://{$this->host}/business_reviews";

        $allReviews = collect();

        $nextPageToken = null;

        do {

            $query = [
                'business_id' => $this->businessId,
                'lang' => 'id',
                'limit' => 100,
            ];

            if ($nextPageToken) {
                $query['next_page_token'] = $nextPageToken;
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'x-rapidapi-host' => $this->host,
                    'x-rapidapi-key' => $this->apiKey,
                ])
                ->get($url, $query);

            if (! $response->ok()) {
                break;
            }

            $json = $response->json();

            $items = collect(data_get($json, 'data', []));

            if ($items->isEmpty()) {
                break;
            }

            $normalized = $items->map(function ($r) {
                return $this->normalizeReview($r);
            });

            $allReviews = $allReviews->merge($normalized);

            $nextPageToken = data_get($json, 'next_page_token');

        } while ($nextPageToken);

        return $allReviews
            ->unique(function ($item) {
                return md5(
                    $item['author_name'] .
                    $item['text']
                );
            })
            ->values()
            ->toArray();
    });

    return collect($result);
}
}
