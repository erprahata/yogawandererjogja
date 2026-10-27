<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\YogaClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'this_month');
        
        if ($filter === 'last_month') {
            $startDate = Carbon::now()->subMonth()->startOfMonth();
            $endDate = Carbon::now()->subMonth()->endOfMonth();
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }

        // 1. MENGAMBIL METRIK ATAS
        // Total Pendapatan: Relasikan Transaction dengan YogaClass untuk mengambil kolom 'price'
        $totalPendapatan = Transaction::where('status', 'paid')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->join('yoga_classes', 'transactions.yoga_class_id', '=', 'yoga_classes.id')
            ->sum('yoga_classes.price');

        // Tiket Terjual
        $tiketTerjual = Transaction::where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Menunggu Verifikasi
        $menungguVerifikasi = Transaction::where('status', 'pending')->count();

        // Kelas Aktif (Semua kelas yang terdaftar)
        $kelasAktif = YogaClass::count();

        // 2. MENGAMBIL DATA GRAFIK (Tren Penjualan harian)
        $transactionsPerDay = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_tickets')
            )
            ->where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $chartCategories = [];
        $chartSeries = [];
        
        foreach ($transactionsPerDay as $trx) {
            $chartCategories[] = Carbon::parse($trx->date)->format('d M');
            $chartSeries[] = $trx->total_tickets;
        }

        // 3. MENGAMBIL JADWAL KELAS MENDATANG
        // Filter khusus untuk tipe 'event' yang memiliki 'schedule' spesifik
        $rawUpcomingClasses = YogaClass::where('type', 'event')
            ->whereNotNull('schedule')
            ->where('schedule', '>=', Carbon::now())
            ->orderBy('schedule', 'asc')
            ->take(5)
            ->get();

        $upcomingClasses = $rawUpcomingClasses->map(function ($kelas) {
            $date = Carbon::parse($kelas->schedule);
            return [
                'id' => $kelas->id,
                'month' => $date->translatedFormat('M'),
                'date' => $date->format('d'),
                'title' => $kelas->name,
                'quota' => $kelas->quota,
                'time' => $date->format('H:i')
            ];
        });

        // Ambil pendapatan bulan lalu
        $pendapatanBulanLalu = Transaction::where('status', 'paid')
            ->whereBetween('transactions.created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
            ->join('yoga_classes', 'transactions.yoga_class_id', '=', 'yoga_classes.id')
            ->sum('yoga_classes.price');

        // Hitung persentase
        $persentase = 0;
        if ($pendapatanBulanLalu > 0) {
            $persentase = (($totalPendapatan - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100;
        }
        $arah = $persentase >= 0 ? '+' : '';
        $teksPertumbuhan = $arah . number_format($persentase, 1) . '%';

        return response()->json([
            'success' => true,
            'metrics' => [
                'totalPendapatan' => 'Rp ' . number_format($totalPendapatan, 0, ',', '.'),
                'pertumbuhanPendapatan' => 'Data Realtime', 
                'tiketTerjual' => $tiketTerjual,
                'menungguVerifikasi' => $menungguVerifikasi,
                'kelasAktif' => $kelasAktif
            ],
            'chart' => [
                'categories' => empty($chartCategories) ? ['Belum ada data'] : $chartCategories,
                'series' => empty($chartSeries) ? [0] : $chartSeries
            ],
            'upcomingClasses' => $upcomingClasses
        ]);
    }
}