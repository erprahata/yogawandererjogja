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
            'payment_method' => 'required|in:bank,qris'
        ]);

        $yogaClass = YogaClass::findOrFail($request->yoga_class_id);

        $bookedCount = Transaction::where('yoga_class_id', $yogaClass->id)
            ->whereIn('status', ['pending', 'paid'])
            ->count();

        if ($bookedCount >= $yogaClass->quota) {
            return response()->json(['success' => false, 'message' => 'Maaf, kuota kelas ini sudah penuh.'], 400);
        }

        $transactionCode = 'YWJ-'.now()->format('Ymd').'-'.strtoupper(Str::random(5));

        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'yoga_class_id' => $yogaClass->id,
            'transaction_code' => $transactionCode,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        $dynamicQris = null;
        if ($request->payment_method === 'qris') {
            // String asli dari Anda, fungsi trim() memastikan tidak ada spasi tersembunyi
            $staticQris = trim("00020101021126610014COM.GO-JEK.WWW01189360091435697266230210G5697266230303UMI51440014ID.CO.QRIS.WWW0215ID10266243024970303UMI5204794153033605802ID5919Yoga Wanderer Jogja6006BANTUL61055518262140703A0111036216304AE6F"); 
            $dynamicQris = $this->generateDynamicQris($staticQris, $yogaClass->price);
        }

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil, silakan lakukan pembayaran.',
            'data' => [
                'transaction_code' => $transaction->transaction_code,
                'payment_method' => $transaction->payment_method,
                'dynamic_qris' => $dynamicQris
            ],
        ]);
    }

    private function generateDynamicQris($staticQris, $amount)
    {
        $qrisTanpaCrc = substr($staticQris, 0, -4);
        $qrisInti = substr($qrisTanpaCrc, 0, -4);
        $qrisInti = str_replace("010211", "010212", $qrisInti);

        $amountStr = (string) $amount;
        $amountLength = str_pad(strlen($amountStr), 2, "0", STR_PAD_LEFT);
        $tag54 = "54" . $amountLength . $amountStr;

        $newQrisString = $qrisInti . $tag54 . "6304";
        $crc = $this->calculateCRC16($newQrisString);

        return $newQrisString . strtoupper($crc);
    }

    private function calculateCRC16($str)
    {
        $crc = 0xFFFF;
        for ($i = 0; $i < strlen($str); $i++) {
            $x = (($crc >> 8) ^ ord($str[$i])) & 0xFF;
            $x ^= $x >> 4;
            $crc = (($crc << 8) ^ ($x << 12) ^ ($x << 5) ^ $x) & 0xFFFF;
        }
        return str_pad(dechex($crc), 4, '0', STR_PAD_LEFT);
    }
}