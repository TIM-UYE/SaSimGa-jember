<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Testimoni;
use App\Models\Video;
use App\Services\GoogleExtractorService;

class HomeController extends Controller
{
    public function index(GoogleExtractorService $extractor)
    {
        $menus = Menu::where('is_available', true)
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->get();

        $kategoris = KategoriMenu::where('is_active', true)
            ->withCount(['menus' => function($query) {
                $query->where('is_available', true);
            }])
            ->get();

        $dbTestimonis = Testimoni::where('is_active', true)
            ->orderByDesc('review_date')
            ->limit(6)
            ->get()
            ->map(function ($t) {
                return [
                    'author_name' => $t->author_name,
                    'text' => $t->text,
                    'rating' => (int) $t->rating,
                    'profile_photo_url' => $t->profile_photo_url ?: asset('images/avatar-default.png'),
                    'relative_time_description' => $t->relative_time_description ?: ($t->review_date?->diffForHumans() ?? 'Baru saja'),
                    'source' => $t->source ?? 'Manual',
                ];
            });

        $googleReviews = $extractor->getReviews(6);

        // merge DB + Google reviews, prefer DB first, then Google
        $testimonis = collect($dbTestimonis)->merge($googleReviews)->take(6);

        $galeris = Galeri::where('is_active', true)
            ->orderByDesc('created_at')
            ->get();

        $videos = Video::where('is_active', true)
            ->orderByDesc('created_at')
            ->get();

        return view('frontend.pages.home', compact('menus', 'kategoris', 'testimonis', 'galeris', 'videos'));
    }
}
