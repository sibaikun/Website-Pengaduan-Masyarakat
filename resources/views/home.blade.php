<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Pengaduan</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            font-family: 'Figtree', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #ea6666 0%, #a2574b 100%);
            min-height: 100vh;
        }
        
        .hero-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem 2rem;
            margin: 2rem 0;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 4px 8px rgba(0,0,0,0.3);
            margin-bottom: 1rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .welcome-user {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .user-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: white;
        }
        
        .user-role {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }
        
        .complaint-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .complaint-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        /* Card dengan border berdasarkan status */
        .complaint-card.pending-complaint {
            border-left: 4px solid #ffc107;
            background: linear-gradient(135deg, #fffef7 0%, #fff9e6 100%);
        }
        
        .complaint-card.processing-complaint {
            border-left: 4px solid #0d6efd;
            background: linear-gradient(135deg, #f8f9fa 0%, #e7f3ff 100%);
        }
        
        .complaint-card.resolved-complaint {
            border-left: 4px solid #28a745;
            background: linear-gradient(135deg, #f8f9fa 0%, #e8f5e9 100%);
        }
        
        .complaint-card.rejected-complaint {
            border-left: 4px solid #dc3545;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffe8e8 100%);
        }
        
        .my-complaints-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px solid #28a745;
        }
        
        .complaint-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .complaint-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .complaint-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }
        
        .complaint-content {
            color: #495057;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .complaint-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        /* Status dengan warna kuning untuk pending */
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffc107;
        }
        
        .status-processing {
            background: #cce5ff;
            color: #0056b3;
            border: 1px solid #0d6efd;
        }
        
        .status-resolved {
            background: #d4edda;
            color: #155724;
            border: 1px solid #28a745;
        }
        
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #dc3545;
        }
        
        .stats-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem 0;
        }
        
        .stat-card {
            text-align: center;
            padding: 1rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #e93515;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #eadb66 0%, #e1c02d 100%);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            color: #333;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(234, 131, 102, 0.4);
            color: #333;
        }
        
        .btn-success-custom {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }
        
        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
            color: white;
        }
        
        .category-badge {
            background: #f8f9fa;
            color: #495057;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
            font-size: 0.75rem;
            border: 1px solid #dee2e6;
        }
        
        .my-complaint-badge {
            background: #28a745;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
            font-size: 0.75rem;
        }
        
        .floating-action {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
        }
        
        .floating-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }
        
        .floating-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
        }
        
        .dropdown-menu {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .quick-stats {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .quick-stat-item {
            text-align: center;
            color: white;
        }
        
        .quick-stat-number {
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .quick-stat-label {
            font-size: 0.8rem;
            opacity: 0.8;
        }
        
        .tab-content {
            margin-top: 1rem;
        }
        
        .nav-pills .nav-link {
            border-radius: 20px;
            margin-right: 0.5rem;
        }
        
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <span class="fw-bold">Kelurahan Sawah Besar</span>
            </a>
            
            <div class="navbar-nav ms-auto d-flex align-items-center">
                <!-- User Info Dropdown -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar me-2">
                            {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                        </div>
                        <span>{{ auth()->user()->name ?? 'User' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil Saya</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-list me-2"></i>Pengaduan Saya</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Hero Section with Welcome -->
        <div class="hero-section">
            <div class="welcome-user d-flex align-items-center">
                <div class="user-avatar me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
                <div>
                    <div class="user-name">Selamat datang, {{ auth()->user()->name ?? 'User' }}!</div>
                    <div class="user-role">Member Aktif • Bergabung sejak {{ auth()->user()->created_at->format('M Y') ?? 'Januari 2025' }}</div>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="row">
                    <div class="col-3 quick-stat-item">
                        <div class="quick-stat-number">{{ $stats['total'] ?? 0 }}</div>
                        <div class="quick-stat-label">Pengaduan Saya</div>
                    </div>
                    <div class="col-3 quick-stat-item">
                        <div class="quick-stat-number">{{ $stats['pending'] ?? 0 }}</div>
                        <div class="quick-stat-label">Menunggu</div>
                    </div>
                    <div class="col-3 quick-stat-item">
                        <div class="quick-stat-number">{{ $stats['processing'] ?? 0 }}</div>
                        <div class="quick-stat-label">Diproses</div>
                    </div>
                    <div class="col-3 quick-stat-item">
                        <div class="quick-stat-number">{{ $stats['resolved'] ?? 0 }}</div>
                        <div class="quick-stat-label">Selesai</div>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <h1 class="hero-title">Dashboard Pengaduan</h1>
                <p class="hero-subtitle">
                    Kelola pengaduan Anda dan pantau pengaduan masyarakat lainnya
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('complaints.create') }}" class="btn btn-success-custom">
                        <i class="fas fa-plus me-2"></i>Buat Pengaduan Baru
                    </a>
                    <a href="#keluhan" class="btn btn-primary-custom">
                        <i class="fas fa-eye me-2"></i>Lihat Semua Pengaduan
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="stats-section">
            <div class="row">
                <div class="col-md-3 stat-card">
                    <div class="stat-number">{{ $publicStats['total'] ?? 0 }}</div>
                    <div class="stat-label">Total Pengaduan</div>
                </div>
                <div class="col-md-3 stat-card">
                    <div class="stat-number">{{ $publicStats['processing'] ?? 0 }}</div>
                    <div class="stat-label">Sedang Diproses</div>
                </div>
                <div class="col-md-3 stat-card">
                    <div class="stat-number">{{ $publicStats['resolved'] ?? 0 }}</div>
                    <div class="stat-label">Telah Selesai</div>
                </div>
                <div class="col-md-3 stat-card">
                    <div class="stat-number">{{ $publicStats['average_days'] ?? 0 }}</div>
                    <div class="stat-label">Rata-rata Hari</div>
                </div>
            </div>
        </div>

        <!-- Complaints Section with Tabs -->
        <div id="keluhan" class="complaints-section">
            <div class="row">
                <div class="col-md-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="text-white mb-0">
                            <i class="fas fa-comments me-2"></i>Pengaduan
                        </h2>
                        <!-- Tabs for filtering -->
                        <ul class="nav nav-pills" id="complaintTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab">Semua</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="mine-tab" data-bs-toggle="pill" data-bs-target="#mine" type="button" role="tab">Pengaduan Saya</button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="complaintTabContent">
                        <!-- All Complaints Tab -->
                        <div class="tab-pane fade show active" id="all" role="tabpanel">
                            @forelse($allComplaints ?? [] as $complaint)
                                <div class="complaint-card {{ $complaint->status }}-complaint">
                                    <div class="complaint-header">
                                        <div class="flex-grow-1">
                                            <h5 class="complaint-title">{{ $complaint->title }}</h5>
                                            <div class="complaint-meta">
                                                <span><i class="fas fa-user me-1"></i>{{ $complaint->user->name }}</span>
                                                <span><i class="fas fa-map-marker-alt me-1"></i>{{ $complaint->location }}</span>
                                                <span><i class="fas fa-clock me-1"></i>{{ $complaint->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <span class="category-badge">{{ ucfirst(str_replace('_', ' ', $complaint->category)) }}</span>
                                    </div>
                                    <p class="complaint-content">
                                        {{ Str::limit($complaint->content, 150) }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="complaint-status status-{{ $complaint->status }}">
                                            @if($complaint->status == 'pending') Menunggu
                                            @elseif($complaint->status == 'processing') Sedang Diproses
                                            @elseif($complaint->status == 'resolved') Selesai
                                            @else Ditolak
                                            @endif
                                        </span>
                                        <div>
                                            <button class="btn btn-sm btn-outline-success me-2">
                                                <i class="fas fa-thumbs-up"></i> {{ $complaint->likes ?? 0 }}
                                            </button>
                                            <a href="{{ route('complaints.show', $complaint->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="complaint-card">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p class="mb-0">Belum ada pengaduan tersedia.</p>
                                    </div>
                                </div>
                            @endforelse

                            @if(isset($allComplaints) && $allComplaints->hasPages())
                                <div class="text-center mt-4">
                                    {{ $allComplaints->links() }}
                                </div>
                            @endif
                        </div>

                        <!-- My Complaints Tab -->
                        <div class="tab-pane fade" id="mine" role="tabpanel">
                            @forelse($myComplaints ?? [] as $complaint)
                                <div class="complaint-card my-complaints-card {{ $complaint->status }}-complaint">
                                    <div class="complaint-header">
                                        <div class="flex-grow-1">
                                            <h5 class="complaint-title">{{ $complaint->title }}</h5>
                                            <div class="complaint-meta">
                                                <span><i class="fas fa-user me-1"></i>{{ $complaint->user->name }}</span>
                                                <span><i class="fas fa-map-marker-alt me-1"></i>{{ $complaint->location }}</span>
                                                <span><i class="fas fa-clock me-1"></i>{{ $complaint->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <span class="my-complaint-badge"><i class="fas fa-user me-1"></i>Milik Saya</span>
                                    </div>
                                    <p class="complaint-content">
                                        {{ Str::limit($complaint->content, 150) }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="complaint-status status-{{ $complaint->status }}">
                                            @if($complaint->status == 'pending') Menunggu
                                            @elseif($complaint->status == 'processing') Sedang Diproses
                                            @elseif($complaint->status == 'resolved') Selesai
                                            @else Ditolak
                                            @endif
                                        </span>
                                        <div>
                                            @if($complaint->status == 'pending')
                                                <a href="{{ route('complaints.edit', $complaint->id) }}" class="btn btn-sm btn-outline-warning me-2">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form method="POST" action="{{ route('complaints.destroy', $complaint->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('complaints.show', $complaint->id) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="complaint-card">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p class="mb-0">Anda belum membuat pengaduan.</p>
                                        <a href="{{ route('complaints.create') }}" class="btn btn-success-custom mt-3">
                                            <i class="fas fa-plus me-2"></i>Buat Pengaduan Pertama
                                        </a>
                                    </div>
                                </div>
                            @endforelse

                            @if(isset($myComplaints) && $myComplaints->hasPages())
                                <div class="text-center mt-4">
                                    {{ $myComplaints->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <div class="complaint-card">
                        <h5><i class="fas fa-filter me-2"></i>Filter Pengaduan</h5>
                        <form method="GET" action="{{ route('dashboard') }}">
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="category" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories ?? [] as $key => $label)
                                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cari</label>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari pengaduan...">
                            </div>
                            <button type="submit" class="btn btn-primary-custom w-100">
                                <i class="fas fa-search me-2"></i>Terapkan Filter
                            </button>
                        </form>
                    </div>

                    @if(isset($categoryStats) && count($categoryStats) > 0)
                    <div class="complaint-card">
                        <h5><i class="fas fa-chart-bar me-2"></i>Kategori Populer</h5>
                        @foreach($categoryStats as $stat)
                            <div class="mb-2 d-flex justify-content-between">
                                <span>{{ ucfirst(str_replace('_', ' ', $stat->category)) }}</span>
                                <span class="badge bg-primary">{{ $stat->count }}</span>
                            </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="complaint-card">
                        <h5><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
                        <div class="d-grid gap-2">
                            <a href="{{ route('complaints.create') }}" class="btn btn-success-custom">
                                <i class="fas fa-plus me-2"></i>Buat Pengaduan
                            </a>
                            <a href="{{ route('complaints.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>Pengaduan Saya
                            </a>
                            <a href="{{ route('complaints.public') }}" class="btn btn-outline-info">
                                <i class="fas fa-eye me-2"></i>Lihat Semua
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <div class="floating-action">
        <a href="{{ route('complaints.create') }}" class="floating-btn" title="Buat Pengaduan Baru">
            <i class="fas fa-plus"></i>
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>