<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
public function index()
{
    $stats = [
        'total' => Complaint::count(),
        'processing' => Complaint::where('status', 'processing')->count(),
        'resolved' => Complaint::where('status', 'resolved')->count(),
        'average_days' => $this->getAverageProcessingDays()
    ];

    // konsisten pakai nama myComplaints
    $myComplaints = Complaint::where('user_id', auth()->id())
                            ->latest()
                            ->limit(5)
                            ->get();

    $recentComplaints = Complaint::latest()->limit(10)->get();

    return view('user.index', compact('stats', 'myComplaints', 'recentComplaints'));
}

    private function getAverageProcessingDays()
    {
        return Complaint::where('status', 'resolved')
            ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
            ->value('avg_days') ?? 7;
    }
}