<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function verifyPayment(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status === 'paid') {
            return response()->json(['success' => false, 'message' => 'Transaksi sudah berstatus Paid.'], 400);
        }

        $transaction->update([
            'status' => 'paid',
            // Di tahap selanjutnya, generate QR Code path dan simpan di sini
            // 'qr_code_path' => '/storage/tickets/...'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil diverifikasi. E-Ticket telah diterbitkan.',
            'data' => $transaction,
        ]);
    }

    public function scanTicket(Request $request)
    {
        $request->validate([
            'transaction_code' => 'required|string'
        ]);

        // Cari transaksi berdasarkan kode dari QR Code
        $transaction = Transaction::with(['user', 'yogaClass'])
                        ->where('transaction_code', $request->transaction_code)
                        ->first();

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Tiket tidak ditemukan atau kode tidak valid.'], 404);
        }

        if ($transaction->status === 'pending') {
            return response()->json(['success' => false, 'message' => 'Gagal! Tiket belum dibayar atau diverifikasi oleh Admin.'], 400);
        }

        if ($transaction->status === 'attended') {
            return response()->json(['success' => false, 'message' => 'Gagal! Tiket ini sudah digunakan untuk check-in sebelumnya.'], 400);
        }

        // Update status menjadi attended (hadir)
        $transaction->update([
            'status' => 'attended'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil!',
            'data' => [
                'customer_name' => $transaction->user->name,
                'class_name' => $transaction->yogaClass->name,
                'transaction_code' => $transaction->transaction_code
            ]
        ]);
    }
}
