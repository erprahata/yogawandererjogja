<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\YogaClass;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'yoga_class_id' => 'required|exists:yoga_classes,id',
        ]);

        $yogaClass = YogaClass::findOrFail($request->yoga_class_id);

        // Cek Kuota
        $bookedCount = Transaction::where('yoga_class_id', $yogaClass->id)
            ->whereIn('status', ['pending', 'paid'])
            ->count();

        if ($bookedCount >= $yogaClass->quota) {
            return response()->json(['success' => false, 'message' => 'Maaf, kuota kelas ini sudah penuh.'], 400);
        }

        // Generate Nomor Transaksi Unik (Format: YWJ-TahunBulanTanggal-RandomStr)
        $transactionCode = 'YWJ-'.now()->format('Ymd').'-'.strtoupper(Str::random(5));

        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'yoga_class_id' => $yogaClass->id,
            'transaction_code' => $transactionCode,
            'status' => 'pending',
            'payment_method' => 'manual_transfer',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil, silakan lakukan pembayaran.',
            'data' => $transaction,
        ]);
    }
}
