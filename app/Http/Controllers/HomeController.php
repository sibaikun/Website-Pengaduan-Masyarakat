<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Complaint;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->is_admin) {
            // Jika admin, langsung ke dashboard admin
            return view('dashboard');
        } else {
            $stats = [
                'total' => Complaint::count(),
                'processing' => Complaint::where('status', 'processing')->count(),
                'resolved' => Complaint::where('status', 'resolved')->count(),
                'average_days' => Complaint::where('status', 'resolved')
                    ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
                    ->value('avg_days') ?? 7,
            ];

            $myComplaints = Complaint::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();

            $recentComplaints = Complaint::where('is_public', true)
                ->latest()
                ->take(5)
                ->get();

            return view('user.index', compact('stats', 'myComplaints', 'recentComplaints'));
        }

    }
}
