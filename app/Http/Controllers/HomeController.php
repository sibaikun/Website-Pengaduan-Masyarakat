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

        if ($user && $user->is_admin) {
            // Redirect ke route admin agar AdminDashboardController yang menyiapkan datanya
            return redirect()->route('admin.dashboard');
        }

        // Data khusus user biasa
        $stats = [
            'total' => Complaint::where('user_id', $user->id)->count(),
            'processing' => Complaint::where('user_id', $user->id)->where('status', 'processing')->count(),
            'resolved' => Complaint::where('user_id', $user->id)->where('status', 'resolved')->count(),
            'average_days' => Complaint::where('user_id', $user->id)->where('status', 'resolved')
                ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
                ->value('avg_days') ?? 7,
        ];

        $myComplaints = Complaint::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Recent public complaints (ditampilkan juga di user dashboard)
        $recentComplaints = Complaint::where('is_public', true)
            ->latest()
            ->take(5)
            ->get();

        return view('user.index', compact('stats', 'myComplaints', 'recentComplaints'));
    }
}