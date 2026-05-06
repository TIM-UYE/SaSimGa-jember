<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimonis = Testimoni::orderByDesc('review_date')->paginate(15);

        return view('admin.testimoni.index', compact('testimonis'));
    }

    public function create()
    {
        return view('admin.testimoni.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'author_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'text' => 'required|string',
            'profile_photo_url' => 'nullable|url|max:1000',
            'author_url' => 'nullable|url|max:1000',
            'relative_time_description' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:10',
            'review_date' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['source'] = 'manual';
        $data['review_date'] = $data['review_date'] ? Carbon::parse($data['review_date']) : now();
        $data['review_key'] = md5($data['author_name'] . '|' . $data['text'] . '|' . $data['rating'] . '|' . $data['review_date']->timestamp);

        Testimoni::firstOrCreate(['review_key' => $data['review_key']], $data);

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimoni $testimoni)
    {
        return view('admin.testimoni.edit', compact('testimoni'));
    }

    public function update(Request $request, Testimoni $testimoni)
    {
        $data = $request->validate([
            'author_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'text' => 'required|string',
            'profile_photo_url' => 'nullable|url|max:1000',
            'author_url' => 'nullable|url|max:1000',
            'relative_time_description' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:10',
            'review_date' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['review_date'] = $data['review_date'] ? Carbon::parse($data['review_date']) : now();
        $data['review_key'] = md5($data['author_name'] . '|' . $data['text'] . '|' . $data['rating'] . '|' . $data['review_date']->timestamp);

        $testimoni->update($data);

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimoni $testimoni)
    {
        $testimoni->delete();

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni berhasil dihapus.');
    }

    public function syncGoogleMaps()
    {
        $apiKey = Config::get('services.google_maps.api_key');
        $placeId = Config::get('services.google_maps.place_id');

        if (! $apiKey || ! $placeId) {
            return redirect()->route('admin.testimoni.index')
                ->with('error', 'Pengaturan Google Maps belum lengkap. Silakan atur GOOGLE_MAPS_API_KEY dan GOOGLE_PLACE_ID.');
        }

        $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
            'place_id' => $placeId,
            'fields' => 'reviews',
            'key' => $apiKey,
        ]);

        if (! $response->successful()) {
            return redirect()->route('admin.testimoni.index')
                ->with('error', 'Gagal mengambil data dari Google Maps.');
        }

        $payload = $response->json();
        if (data_get($payload, 'status') !== 'OK') {
            return redirect()->route('admin.testimoni.index')
                ->with('error', data_get($payload, 'error_message', 'Google Maps API menolak permintaan.'));
        }

        $reviews = data_get($payload, 'result.reviews', []);
        $newCount = 0;

        foreach ($reviews as $review) {
            $reviewDate = isset($review['time']) ? Carbon::createFromTimestamp($review['time']) : now();
            $reviewKey = md5(
                data_get($review, 'author_name', '') . '|' .
                data_get($review, 'text', '') . '|' .
                data_get($review, 'rating', '') . '|' .
                $reviewDate->timestamp
            );

            $attributes = [
                'review_key' => $reviewKey,
                'author_name' => data_get($review, 'author_name', 'Anonymous'),
                'author_url' => data_get($review, 'author_url'),
                'profile_photo_url' => data_get($review, 'profile_photo_url'),
                'rating' => (int) data_get($review, 'rating', 5),
                'text' => data_get($review, 'text', ''),
                'relative_time_description' => data_get($review, 'relative_time_description'),
                'language' => data_get($review, 'language'),
                'review_date' => $reviewDate,
                'source' => 'google_maps',
                'place_id' => $placeId,
                'is_active' => true,
            ];

            $testimoni = Testimoni::firstOrCreate(['review_key' => $reviewKey], $attributes);
            if ($testimoni->wasRecentlyCreated) {
                $newCount++;
            }
        }

        return redirect()->route('admin.testimoni.index')
            ->with('success', "Sinkronisasi Google Maps selesai. $newCount testimoni baru disimpan.");
    }
}
