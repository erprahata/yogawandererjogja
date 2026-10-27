<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsContent;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function index()
    {
        // Mengambil semua data CMS dan mengubahnya menjadi key-value pair agar mudah dibaca Vue
        $contents = CmsContent::pluck('value', 'key');

        return response()->json(['success' => true, 'data' => $contents]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|exists:cms_contents,key',
            'value' => 'required',
        ]);

        $content = CmsContent::where('key', $validated['key'])->first();
        $content->update(['value' => $validated['value']]);

        return response()->json(['success' => true, 'message' => 'Konten berhasil diperbarui']);
    }

    public function uploadHero(Request $request)
    {
        // 1. Validasi eksplisit untuk webp dan perbesar batas ukuran ke 5MB
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120'
        ], [
            'image.mimes' => 'Format file harus berupa jpeg, png, jpg, atau webp.',
            'image.max' => 'Ukuran file maksimal adalah 5MB.'
        ]);

        try {
            // 2. Simpan gambar ke folder storage
            $path = $request->file('image')->store('hero', 'public');
            $url = asset('storage/' . $path);

            // 3. Simpan ke database
            $key = 'hero_image_' . time();
            \App\Models\CmsContent::create([
                'section' => 'hero', 
                'key' => $key, 
                'value' => $url, 
                'type' => 'image'
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Gambar berhasil diupload',
                'url' => $url, 
                'key' => $key
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error Server: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteContent(Request $request)
    {
        $request->validate(['key' => 'required']);
        
        $content = \App\Models\CmsContent::where('key', $request->key)->first();
        
        if ($content) {
            $content->delete();
            return response()->json(['success' => true, 'message' => 'Konten berhasil dihapus.']);
        }

        return response()->json(['success' => false, 'message' => 'Konten tidak ditemukan.'], 404);
    }

    public function uploadSponsor(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048'
        ]);

        try {
            $path = $request->file('image')->store('sponsors', 'public');
            $url = asset('storage/' . $path);
            $key = 'sponsor_logo_' . time();
            
            \App\Models\CmsContent::create([
                'section' => 'sponsorship', 
                'key' => $key, 
                'value' => $url, 
                'type' => 'image'
            ]);

            return response()->json(['success' => true, 'url' => $url, 'key' => $key]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
