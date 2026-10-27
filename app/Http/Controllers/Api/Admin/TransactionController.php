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
}
