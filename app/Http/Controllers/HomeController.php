<?php

namespace App\Http\Controllers;

use App\Models\Pertandingan;
use App\Models\Player;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman home dengan grafik statistik pemain dan data tambahan.
     */
    public function Homepage()
    {
        // Mengecek apakah user adalah admin
        $isAdmin = Auth::user()->role === 'admin';

        // Query untuk menghitung kemenangan tim 1 dan tim 2 per bulan (untuk semua pertandingan)
        $winsPerMonthQuery = Pertandingan::selectRaw('MONTH(tanggal_pertandingan) as month, 
                                                    SUM(CASE WHEN gol_tim_1 > gol_tim_2 THEN 1 ELSE 0 END) as wins_tim_1,
                                                    SUM(CASE WHEN gol_tim_2 > gol_tim_1 THEN 1 ELSE 0 END) as wins_tim_2')
            ->groupBy('month')
            ->orderBy('month', 'asc');
    
        $winsPerMonth = $winsPerMonthQuery->get();
    
        // Memisahkan data untuk grafik
        $months = [];
        $winsTim1 = [];
        foreach ($winsPerMonth as $item) {
            $months[] = Carbon::create()->month($item->month)->format('F'); // Format bulan
            $winsTim1[] = $item->wins_tim_1; // Jumlah kemenangan tim 1
        }
    
        // Membuat grafik berdasarkan kemenangan
        $chart = LarapexChart::barChart()
            ->setTitle('Kemenangan per Bulan')
            ->setSubtitle('Statistik Kemenangan Tim per Bulan')
            ->addData('Kemenangan Tim Blue Lock', $winsTim1)
            ->setXAxis($months);
    
        // Query untuk menghitung total pertandingan dalam 1 tahun (tanpa filter user_id)
        $totalMatches = Pertandingan::count();
        
        // Query untuk menghitung total pemain (untuk admin, ambil semua, untuk user juga bisa lihat semua)
        $totalPlayers = Player::count();

        // Data tambahan untuk ditampilkan di dashboard
        $data = [
            'totalPlayers' => $totalPlayers, // Tampilkan total pemain
            'matchesToday' => Pertandingan::whereDate('tanggal_pertandingan', Carbon::today())->count(),
            'totalMatches' => $totalMatches, // Total pertandingan
            'totalGoals' => Pertandingan::sum(DB::raw('gol_tim_1')), // Jumlah gol dari tim 1
            'chart' => $chart // Grafik untuk view
        ];

        return view('home', $data);
    }
}
