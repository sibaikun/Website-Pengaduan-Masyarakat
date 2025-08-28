<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{

    /**
     * Display a listing of complaints for authenticated users
     */
    public function index(Request $request)
    {
        // Mulai dengan filter user yang sedang login (kecuali admin)
        $query = Complaint::with('user')->latest();
        
        // Jika bukan admin, selalu filter hanya pengaduan user sendiri
        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        // Filter berdasarkan kategori
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan lokasi
        if ($request->filled('location') && $request->location !== 'all') {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%');
            });
        }

        $complaints = $query->paginate(10);

        // Data untuk filter dropdown
        $categories = $this->getCategories();
        $statuses = $this->getStatuses();
        $locations = $this->getLocations();

        // Statistics
        $stats = $this->getUserStats();

        return view('complaints.index', compact('complaints', 'categories', 'statuses', 'locations', 'stats'));
    }

    /**
     * Display complaints for public (non-authenticated users)
     */
    public function publicIndex()
    {
        // Ambil 10 pengaduan publik terbaru
        $recentComplaints = \App\Models\Complaint::where('is_public', 1)
                                ->latest()
                                ->take(10)
                                ->get();

        // Statistik (opsional, kalau mau tampil di halaman)
        $stats = [
            'total' => \App\Models\Complaint::where('is_public', 1)->count(),
            'processing' => \App\Models\Complaint::where('is_public', 1)->where('status', 'processing')->count(),
            'resolved' => \App\Models\Complaint::where('is_public', 1)->where('status', 'resolved')->count(),
            'average_days' => \App\Models\Complaint::whereNotNull('responded_at')
                                ->avg(\DB::raw('DATEDIFF(responded_at, created_at)')),
        ];

        return view('complaints.public', compact('recentComplaints', 'stats'));
    }
    
    /**
     * Show the form for creating a new complaint
     */
    public function create()
    {
        $categories = $this->getCategories();
        $locations = $this->getLocations();

        return view('complaints.create', compact('categories', 'locations'));
    }

    /**
     * Store a newly created complaint
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:20',
            'category' => 'required|string|in:' . implode(',', array_keys($this->getCategories())),
            'location' => 'required|string|max:255',
            'is_public' => 'boolean',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image_path')) {
                $imagePath = $request->file('image_path')->store('complaints', 'public');
            }

            // Create complaint
            $complaint = Complaint::create([
                'title' => $validatedData['title'],
                'content' => $validatedData['content'],
                'category' => $validatedData['category'],
                'location' => $validatedData['location'],
                'user_id' => Auth::id(),
                'is_public' => $request->has('is_public') ? true : false,
                'image_path' => $imagePath,
                'status' => 'pending'
            ]);

            return redirect()->route('complaints.index')
                    ->with('success', 'Keluhan berhasil dibuat dan akan segera ditinjau oleh admin.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat membuat keluhan. Silakan coba lagi.')
                ->withInput();
        }
    }
    
    /**
     * Display the specified complaint
     */
    public function show($id)
    {
        $complaint = Complaint::with('user')->findOrFail($id);

        // Check if user can view this complaint
        if (!$complaint->is_public && (!Auth::check() || (Auth::id() !== $complaint->user_id && !Auth::user()->is_admin))) {
            abort(403, 'Anda tidak memiliki akses untuk melihat keluhan ini.');
        }

        // Increment view count
        $complaint->increment('views');

        // Get related complaints
        $relatedComplaints = Complaint::where('category', $complaint->category)
            ->where('id', '!=', $complaint->id)
            ->where('is_public', true)
            ->latest()
            ->take(3)
            ->get();

        return view('complaints.show', compact('complaint', 'relatedComplaints'));
    }

    /**
     * Show the form for editing the specified complaint
     */
    public function edit(Complaint $complaint)
    {
        // Pastikan user hanya bisa edit complaint miliknya
        if ($complaint->user_id !== auth()->id()) {
            return redirect()->route('complaints.index')
                ->with('error', 'Anda tidak berhak mengedit pengaduan ini.');
        }

        // Hapus pengecekan status agar bisa edit semua
        // if ($complaint->status !== 'pending' && !Auth::user()->is_admin) { ... }

        $categories = $this->getCategories();
        $locations = $this->getLocations();
        
        return view('complaints.edit', compact('complaint', 'categories', 'locations'));
    }

    /**
     * Update the specified complaint
     */
    public function update(Request $request, Complaint $complaint)
    {
        // Validasi ownership
        if ($complaint->user_id !== auth()->id()) {
            return redirect()->route('complaints.index')
                ->with('error', 'Anda tidak berhak mengupdate pengaduan ini.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:' . implode(',', array_keys($this->getCategories())),
            'location' => 'required|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_public' => 'boolean',
        ]);
        
        $data = $request->except(['image_path', 'remove_image']);
        $data['is_public'] = $request->has('is_public');
        
        // Handle image upload
        if ($request->hasFile('image_path')) {
            // Delete old image
            if ($complaint->image_path) {
                Storage::disk('public')->delete($complaint->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('complaints', 'public');
        }
        
        // Handle image removal
        if ($request->has('remove_image') && $complaint->image_path) {
            Storage::disk('public')->delete($complaint->image_path);
            $data['image_path'] = null;
        }
        
        $complaint->update($data);
        
        return redirect()->route('complaints.index')
            ->with('success', 'Pengaduan berhasil diupdate!');
    }

    /**
     * Remove the specified complaint
     */
    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);

        // Check authorization
        if (Auth::id() !== $complaint->user_id && !Auth::user()->is_admin) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus keluhan ini.');
        }

        try {
            // Delete image if exists
            if ($complaint->image_path) {
                Storage::disk('public')->delete($complaint->image_path);
            }

            $complaint->delete();

            return redirect()->route('complaints.index')
                ->with('success', 'Keluhan berhasil dihapus.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus keluhan.');
        }
    }

    /**
     * Like/Unlike a complaint
     */
    public function like(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        if (!Auth::check()) {
            return response()->json(['error' => 'Anda harus login untuk memberikan like.'], 401);
        }

        try {
            // Simple like increment (you might want to implement a proper like system with user tracking)
            $complaint->increment('likes');

            return response()->json([
                'success' => true,
                'likes' => $complaint->likes,
                'message' => 'Terima kasih atas dukungan Anda!'
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat memberikan like.'], 500);
        }
    }

    /**
     * Admin dashboard for managing complaints
     */
    public function adminDashboard()
    {
        // Check if user is admin
        if (!Auth::user()->is_admin) {
            abort(403, 'Akses ditolak.');
        }

        $stats = [
            'total' => Complaint::count(),
            'pending' => Complaint::where('status', 'pending')->count(),
            'processing' => Complaint::where('status', 'processing')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
            'rejected' => Complaint::where('status', 'rejected')->count(),
        ];

        $recentComplaints = Complaint::with('user')
            ->latest()
            ->take(5)
            ->get();

        $categoryStats = Complaint::selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();

        return view('complaints.admin-dashboard', compact('stats', 'recentComplaints', 'categoryStats'));
    }

    /**
     * Bulk update status (for admin)
     */
    public function bulkUpdateStatus(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'complaint_ids' => 'required|array',
            'complaint_ids.*' => 'exists:complaints,id',
            'status' => 'required|in:pending,processing,resolved,rejected'
        ]);

        try {
            Complaint::whereIn('id', $request->complaint_ids)
                ->update([
                    'status' => $request->status,
                    'responded_at' => now()
                ]);

            return back()->with('success', 'Status keluhan berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperbarui status.');
        }
    }

    /**
     * Update complaint status (for admin)
     */
    public function updateStatus(Request $request, $id)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Akses ditolak.');
        }

        $complaint = Complaint::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,processing,resolved,rejected',
            'admin_response' => 'nullable|string|max:1000'
        ]);

        try {
            $complaint->update([
                'status' => $request->status,
                'admin_response' => $request->admin_response,
                'responded_at' => now()
            ]);

            return back()->with('success', 'Status dan respon berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperbarui status.');
        }
    }

    /**
     * Admin view all complaints
     */
    public function adminIndex(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Akses ditolak.');
        }

        $query = Complaint::with('user')->latest();

        // Filter berdasarkan kategori
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        $complaints = $query->paginate(15);

        // Data untuk filter dropdown
        $categories = $this->getCategories();
        $statuses = $this->getStatuses();

        // Statistics
        $stats = [
            'total' => Complaint::count(),
            'pending' => Complaint::where('status', 'pending')->count(),
            'processing' => Complaint::where('status', 'processing')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
            'rejected' => Complaint::where('status', 'rejected')->count(),
        ];

        return view('complaints.admin-index', compact('complaints', 'categories', 'statuses', 'stats'));
    }

    /**
     * Get available categories
     */
    private function getCategories()
    {
        return [
            'infrastruktur' => 'Infrastruktur',
            'kebersihan' => 'Kebersihan',
            'utilitas' => 'Utilitas',
            'keamanan' => 'Keamanan',
            'layanan_publik' => 'Layanan Publik',
            'transportasi' => 'Transportasi',
            'kesehatan' => 'Kesehatan',
            'pendidikan' => 'Pendidikan',
            'lingkungan' => 'Lingkungan',
            'pelayanan' => 'Pelayanan',
            'lainnya' => 'Lainnya'
        ];
    }

    /**
     * Get available statuses
     */
    private function getStatuses()
    {
        return [
            'pending' => 'Menunggu',
            'processing' => 'Sedang Diproses',
            'resolved' => 'Selesai',
            'rejected' => 'Ditolak'
        ];
    }

    /**
     * Get available locations
     */
    private function getLocations()
    {
        return [
            'Jakarta Pusat',
            'Jakarta Selatan',
            'Jakarta Timur',
            'Jakarta Barat',
            'Jakarta Utara',
            'Bekasi',
            'Depok',
            'Tangerang',
            'Tangerang Selatan',
            'Bogor'
        ];
    }

    /**
     * Get user statistics
     */
    private function getUserStats()
    {
        $userId = Auth::id();
        
        return [
            'total' => Complaint::where('user_id', $userId)->count(),
            'pending' => Complaint::where('user_id', $userId)->where('status', 'pending')->count(),
            'processing' => Complaint::where('user_id', $userId)->where('status', 'processing')->count(),
            'resolved' => Complaint::where('user_id', $userId)->where('status', 'resolved')->count(),
        ];
    }

    /**
     * Get public statistics
     */
    private function getPublicStats()
    {
        return [
            'total' => Complaint::where('is_public', true)->count(),
            'pending' => Complaint::where('is_public', true)->where('status', 'pending')->count(),
            'processing' => Complaint::where('is_public', true)->where('status', 'processing')->count(),
            'resolved' => Complaint::where('is_public', true)->where('status', 'resolved')->count(),
            'avg_response_days' => $this->getAverageResponseDays()
        ];
    }

    /**
     * Calculate average response days
     */
    private function getAverageResponseDays()
    {
        $avgDays = Complaint::whereNotNull('responded_at')
            ->selectRaw('AVG(DATEDIFF(responded_at, created_at)) as avg_days')
            ->value('avg_days');

        return round($avgDays ?? 0, 1);
    }

    /**
     * Export complaints data (for admin)
     */
    public function export(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Akses ditolak.');
        }

        $format = $request->input('format', 'csv');
        
        // This would typically use a package like Laravel Excel
        // For now, we'll return a basic CSV export
        
        $complaints = Complaint::with('user')->get();
        
        $filename = 'complaints_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($complaints) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'ID', 'Judul', 'Kategori', 'Lokasi', 'Status', 
                'Pengirim', 'Tanggal Dibuat', 'Likes', 'Views'
            ]);

            // Data rows
            foreach ($complaints as $complaint) {
                fputcsv($file, [
                    $complaint->id,
                    $complaint->title,
                    $complaint->category,
                    $complaint->location,
                    $complaint->status,
                    $complaint->user->name,
                    $complaint->created_at->format('Y-m-d H:i:s'),
                    $complaint->likes,
                    $complaint->views
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Search complaints (AJAX)
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $complaints = Complaint::where('title', 'like', '%' . $query . '%')
            ->orWhere('content', 'like', '%' . $query . '%')
            ->where('is_public', true)
            ->take(10)
            ->get(['id', 'title', 'category', 'status']);

        return response()->json($complaints);
    }

    /**
     * Get complaints by category (AJAX)
     */
    public function getByCategory(Request $request, $category)
    {
        $complaints = Complaint::where('category', $category)
            ->where('is_public', true)
            ->latest()
            ->take(6)
            ->get();

        return response()->json($complaints);
    }

    /**
     * Toggle complaint visibility (admin only)
     */
    public function toggleVisibility($id)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Akses ditolak.');
        }

        $complaint = Complaint::findOrFail($id);
        $complaint->update([
            'is_public' => !$complaint->is_public
        ]);

        return back()->with('success', 'Visibilitas pengaduan berhasil diubah.');
    }

    /**
     * Assign complaint to admin (for workflow)
     */
    public function assign(Request $request, $id)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Akses ditolak.');
        }

        $complaint = Complaint::findOrFail($id);
        
        $request->validate([
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        $complaint->update([
            'assigned_to' => $request->assigned_to,
            'assigned_at' => $request->assigned_to ? now() : null
        ]);

        return back()->with('success', 'Pengaduan berhasil diassign.');
    }
    



}
