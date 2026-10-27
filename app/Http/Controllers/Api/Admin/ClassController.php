<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\YogaClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{

    // Tambahkan method ini untuk merespons request GET /api/classes/active
    public function index()
    {
        $classes = YogaClass::orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'data' => $classes]);
    }

    public function store(Request $request)
    {
        // 1. Tangkap error secara eksplisit dengan try-catch
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'type' => 'required|in:regular,event',
                'price' => 'required|numeric',
                'quota' => 'required|numeric',
                'location' => 'required|string|max:255',
                // Longgarkan validasi gambar hingga 5MB (5120 KB)
                'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120'
            ]);

            $data = $request->only(['name', 'description', 'type', 'price', 'quota', 'location']);

            if ($request->type === 'regular') {
                $data['recurring_days'] = json_decode($request->recurring_days, true);
                // Laravel terkadang sensitif dengan format H:i (misal 16:30). 
                // Jika error time berlanjut, pastikan dikirim sebagai string utuh
                $data['start_time'] = $request->start_time; 
            } else {
                $data['schedule'] = $request->schedule;
            }

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('classes', 'public');
                $data['image'] = asset('storage/' . $path);
            }

            YogaClass::create($data);
            return response()->json(['success' => true]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Ini akan melempar pesan error spesifik jika validasi 422 terjadi
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $yogaClass = YogaClass::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'type' => 'required|in:regular,event',
                'price' => 'required|numeric',
                'quota' => 'required|numeric',
                'location' => 'required|string|max:255',
                // Perhatikan: image dibuat 'nullable' karena pengguna mungkin tidak mengganti poster
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
            ]);

            $data = $request->only(['name', 'description', 'type', 'price', 'quota', 'location']);

            if ($request->type === 'regular') {
                $data['recurring_days'] = json_decode($request->recurring_days, true);
                $data['start_time'] = $request->start_time; 
                $data['schedule'] = null; // Bersihkan jadwal event jika tipe diubah ke reguler
            } else {
                $data['schedule'] = $request->schedule;
                $data['recurring_days'] = null; // Bersihkan hari rutin jika tipe diubah ke event
                $data['start_time'] = null;
            }

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('classes', 'public');
                $data['image'] = asset('storage/' . $path);
            }

            $yogaClass->update($data);
            return response()->json(['success' => true, 'message' => 'Tiket berhasil diperbarui']);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $yogaClass = YogaClass::findOrFail($id);

            // Hapus semua transaksi/tiket pembeli yang terikat dengan kelas ini terlebih dahulu
            // agar tidak terkena bentrok relasi (Foreign Key Constraint)
            \App\Models\Transaction::where('yoga_class_id', $id)->delete();

            // Setelah transaksi bersih, baru hapus kelas yoganya
            $yogaClass->delete();

            return response()->json(['success' => true, 'message' => 'Tiket dan data terkait berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal menghapus tiket: ' . $e->getMessage()
            ], 500);
        }
    }
}