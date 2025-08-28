<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        // Ambil keluhan terbaru untuk ditampilkan di halaman utama
        // Sesuaikan dengan struktur tabel Anda
        $complaints = $this->getSampleComplaints();
        
        // Statistik keluhan
        $stats = [
        'total' => Complaint::count(),
        'processing' => Complaint::where('status', 'processing')->count(),
        'resolved' => Complaint::where('status', 'resolved')->count(),
        'average_days' => Complaint::where('status', 'resolved')
            ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
            ->value('avg_days') ?? 0,
        ];

        // Ambil pengaduan terbaru (yang public)
        $recentComplaints = Complaint::where('is_public', true)
            ->latest()
            ->take(5)
            ->get();

        return view('welcome', compact('stats', 'recentComplaints'));
    }
    
    private function getSampleComplaints()
    {
        // Data contoh - nanti ganti dengan data dari database
        return [
            [
                'id' => 1,
                'title' => 'Jalan Rusak di Kawasan Perumahan Indah',
                'content' => 'Jalan di Perumahan Indah blok C sudah rusak parah dengan banyak lubang. Hal ini sangat mengganggu kenyamanan berkendara dan berpotensi menyebabkan kecelakaan...',
                'user_name' => 'Ahmad Susilo',
                'location' => 'Jakarta Selatan',
                'category' => 'Infrastruktur',
                'status' => 'processing',
                'likes' => 23,
                'views' => 156,
                'created_at' => now()->subDays(2)
            ],
            [
                'id' => 2,
                'title' => 'Lampu Jalan Mati di Jalan Raya Utama',
                'content' => 'Lampu penerangan jalan di sepanjang Jalan Raya Utama sudah mati sejak seminggu lalu. Kondisi ini sangat membahayakan pengguna jalan terutama di malam hari...',
                'user_name' => 'Sari Dewi',
                'location' => 'Jakarta Pusat',
                'category' => 'Utilitas',
                'status' => 'resolved',
                'likes' => 45,
                'views' => 234,
                'created_at' => now()->subWeek()
            ],
            [
                'id' => 3,
                'title' => 'Sampah Menumpuk di TPS Wilayah RW 05',
                'content' => 'Sampah di TPS RW 05 sudah menumpuk tinggi dan mulai berbau. Hal ini mengganggu kenyamanan warga sekitar dan berpotensi menjadi sarang penyakit...',
                'user_name' => 'Budi Santoso',
                'location' => 'Jakarta Timur',
                'category' => 'Kebersihan',
                'status' => 'pending',
                'likes' => 67,
                'views' => 189,
                'created_at' => now()->subDays(3)
            ]
        ];
    }
    
    // Method untuk filter keluhan via AJAX
    public function filterComplaints(Request $request)
    {
        $category = $request->input('category');
        $status = $request->input('status');
        $location = $request->input('location');
        
        // Query untuk filter data keluhan
        // Sesuaikan dengan struktur database Anda
        
        // Contoh response
        $filteredComplaints = $this->getSampleComplaints();
        
        return response()->json([
            'complaints' => $filteredComplaints,
            'count' => count($filteredComplaints)
        ]);
    }
}