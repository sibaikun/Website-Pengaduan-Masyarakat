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
        
        .my-complaints-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px solid #28a745;
        }
        
        .complaint-header {
            display: flex;
            justify-content: between;
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
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .status-processing {
            background: #cce5ff;
            color: #0056b3;
            border: 1px solid #74c0fc;
        }
        
        .status-resolved {
            background: #d4edda;
            color: #155724;
            border: 1px solid #51cf66;
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
                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i>Keluar</a></li>
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
                        <div class="quick-stat-number">3</div>
                        <div class="quick-stat-label">Pengaduan Saya</div>
                    </div>
                    <div class="col-3 quick-stat-item">
                        <div class="quick-stat-number">1</div>
                        <div class="quick-stat-label">Menunggu</div>
                    </div>
                    <div class="col-3 quick-stat-item">
                        <div class="quick-stat-number">1</div>
                        <div class="quick-stat-label">Diproses</div>
                    </div>
                    <div class="col-3 quick-stat-item">
                        <div class="quick-stat-number">1</div>
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
                    <button class="btn btn-success-custom" data-bs-toggle="modal" data-bs-target="#createComplaintModal">
                        <i class="fas fa-plus me-2"></i>Buat Pengaduan Baru
                    </button>
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
                    <div class="stat-number">245</div>
                    <div class="stat-label">Total Pengaduan</div>
                </div>
                <div class="col-md-3 stat-card">
                    <div class="stat-number">89</div>
                    <div class="stat-label">Sedang Diproses</div>
                </div>
                <div class="col-md-3 stat-card">
                    <div class="stat-number">156</div>
                    <div class="stat-label">Telah Selesai</div>
                </div>
                <div class="col-md-3 stat-card">
                    <div class="stat-number">7</div>
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
                            <!-- Sample Complaints -->
                            <div class="complaint-card">
                                <div class="complaint-header">
                                    <div class="flex-grow-1">
                                        <h5 class="complaint-title">Jalan Rusak di Kawasan Perumahan Indah</h5>
                                        <div class="complaint-meta">
                                            <span><i class="fas fa-user me-1"></i>Ahmad Susilo</span>
                                            <span><i class="fas fa-map-marker-alt me-1"></i>Jakarta Selatan</span>
                                            <span><i class="fas fa-clock me-1"></i>2 hari yang lalu</span>
                                        </div>
                                    </div>
                                    <span class="category-badge">Infrastruktur</span>
                                </div>
                                <p class="complaint-content">
                                    Jalan di Perumahan Indah blok C sudah rusak parah dengan banyak lubang. Hal ini sangat mengganggu kenyamanan berkendara dan berpotensi menyebabkan kecelakaan...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="complaint-status status-processing">Sedang Diproses</span>
                                    <div>
                                        <button class="btn btn-sm btn-outline-success me-2"><i class="fas fa-thumbs-up"></i> 23</button>
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-comment"></i> Komentar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="complaint-card">
                                <div class="complaint-header">
                                    <div class="flex-grow-1">
                                        <h5 class="complaint-title">Lampu Jalan Mati di Jalan Raya Utama</h5>
                                        <div class="complaint-meta">
                                            <span><i class="fas fa-user me-1"></i>Sari Dewi</span>
                                            <span><i class="fas fa-map-marker-alt me-1"></i>Jakarta Pusat</span>
                                            <span><i class="fas fa-clock me-1"></i>1 minggu yang lalu</span>
                                        </div>
                                    </div>
                                    <span class="category-badge">Utilitas</span>
                                </div>
                                <p class="complaint-content">
                                    Lampu penerangan jalan di sepanjang Jalan Raya Utama sudah mati sejak seminggu lalu. Kondisi ini sangat membahayakan pengguna jalan terutama di malam hari...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="complaint-status status-resolved">Selesai</span>
                                    <div>
                                        <button class="btn btn-sm btn-outline-success me-2"><i class="fas fa-thumbs-up"></i> 45</button>
                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-comment"></i> Komentar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- My Complaints Tab -->
                        <div class="tab-pane fade" id="mine" role="tabpanel">
                            <div class="complaint-card my-complaints-card">
                                <div class="complaint-header">
                                    <div class="flex-grow-1">
                                        <h5 class="complaint-title">Sampah Menumpuk di TPS Wilayah RW 05</h5>
                                        <div class="complaint-meta">
                                            <span><i class="fas fa-user me-1"></i>{{ auth()->user()->name ?? 'User' }}</span>
                                            <span><i class="fas fa-map-marker-alt me-1"></i>Jakarta Timur</span>
                                            <span><i class="fas fa-clock me-1"></i>3 hari yang lalu</span>
                                        </div>
                                    </div>
                                    <span class="my-complaint-badge"><i class="fas fa-user me-1"></i>Milik Saya</span>
                                </div>
                                <p class="complaint-content">
                                    Sampah di TPS RW 05 sudah menumpuk tinggi dan mulai berbau. Hal ini mengganggu kenyamanan warga sekitar dan berpotensi menjadi sarang penyakit...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="complaint-status status-pending">Menunggu</span>
                                    <div>
                                        <button class="btn btn-sm btn-outline-warning me-2"><i class="fas fa-edit"></i> Edit</button>
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i> Hapus</button>
                                    </div>
                                </div>
                            </div>

                            <div class="complaint-card my-complaints-card">
                                <div class="complaint-header">
                                    <div class="flex-grow-1">
                                        <h5 class="complaint-title">Drainase Tersumbat di Jalan Mawar</h5>
                                        <div class="complaint-meta">
                                            <span><i class="fas fa-user me-1"></i>{{ auth()->user()->name ?? 'User' }}</span>
                                            <span><i class="fas fa-map-marker-alt me-1"></i>Jakarta Selatan</span>
                                            <span><i class="fas fa-clock me-1"></i>1 minggu yang lalu</span>
                                        </div>
                                    </div>
                                    <span class="my-complaint-badge"><i class="fas fa-user me-1"></i>Milik Saya</span>
                                </div>
                                <p class="complaint-content">
                                    Drainase di Jalan Mawar tersumbat sampah dan daun kering. Saat hujan, air menggenang dan menyebabkan banjir kecil di area tersebut...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="complaint-status status-resolved">Selesai</span>
                                    <div>
                                        <button class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i> Detail</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Load More Button -->
                    <div class="text-center mt-4">
                        <button class="btn btn-outline-light">
                            <i class="fas fa-arrow-down me-2"></i>Muat Lebih Banyak
                        </button>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <div class="complaint-card">
                        <h5><i class="fas fa-filter me-2"></i>Filter Pengaduan</h5>
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select">
                                    <option>Semua Kategori</option>
                                    <option>Infrastruktur</option>
                                    <option>Kebersihan</option>
                                    <option>Utilitas</option>
                                    <option>Keamanan</option>
                                    <option>Layanan Publik</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select">
                                    <option>Semua Status</option>
                                    <option>Menunggu</option>
                                    <option>Sedang Diproses</option>
                                    <option>Selesai</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Wilayah</label>
                                <select class="form-select">
                                    <option>Semua Wilayah</option>
                                    <option>Jakarta Pusat</option>
                                    <option>Jakarta Selatan</option>
                                    <option>Jakarta Timur</option>
                                    <option>Jakarta Barat</option>
                                    <option>Jakarta Utara</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary-custom w-100">
                                <i class="fas fa-search me-2"></i>Terapkan Filter
                            </button>
                        </form>
                    </div>

                    <div class="complaint-card">
                        <h5><i class="fas fa-chart-bar me-2"></i>Kategori Populer</h5>
                        <div class="mb-2 d-flex justify-content-between">
                            <span>Infrastruktur</span>
                            <span class="badge bg-primary">45</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span>Kebersihan</span>
                            <span class="badge bg-success">32</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span>Utilitas</span>
                            <span class="badge bg-warning">28</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span>Keamanan</span>
                            <span class="badge bg-danger">15</span>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="complaint-card">
                        <h5><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
                        <div class="d-grid gap-2">
                            <button class="btn btn-success-custom" data-bs-toggle="modal" data-bs-target="#createComplaintModal">
                                <i class="fas fa-plus me-2"></i>Buat Pengaduan
                            </button>
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>Pengaduan Saya
                            </button>
                            <button class="btn btn-outline-info">
                                <i class="fas fa-chart-line me-2"></i>Statistik
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <div class="floating-action">
        <button class="floating-btn" data-bs-toggle="modal" data-bs-target="#createComplaintModal" title="Buat Pengaduan Baru">
            <i class="fas fa-plus"></i>
        </button>
    </div>

    <!-- Create Complaint Modal -->
    <div class="modal fade" id="createComplaintModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Buat Pengaduan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Judul Pengaduan</label>
                                <input type="text" class="form-control" placeholder="Masukkan judul pengaduan" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    <option>Infrastruktur</option>
                                    <option>Kebersihan</option>
                                    <option>Utilitas</option>
                                    <option>Keamanan</option>
                                    <option>Layanan Publik</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi</label>
                                <input type="text" class="form-control" placeholder="Alamat/lokasi pengaduan" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tingkat Urgensi</label>
                                <select class="form-select" required>
                                    <option value="">Pilih Tingkat Urgensi</option>
                                    <option>Rendah</option>
                                    <option>Sedang</option>
                                    <option>Tinggi</option>
                                    <option>Sangat Urgent</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Pengaduan</label>
                            <textarea class="form-control" rows="4" placeholder="Jelaskan pengaduan Anda secara detail..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Foto (Opsional)</label>
                            <input type="file" class="form-control" accept="image/*" multiple>
                            <small class="form-text text-muted">Format: JPG, PNG, maksimal 5MB per file</small>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                <label class="form-check-label" for="agreeTerms">
                                    Saya menyetujui bahwa informasi yang saya berikan adalah benar dan dapat dipertanggungjawabkan
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success-custom">
                        <i class="fas fa-paper-plane me-1"></i>Kirim Pengaduan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-close alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);

        // Form validation
        document.getElementById('createComplaintModal').addEventListener('show.bs.modal', function() {
            // Reset form when modal opens
            this.querySelector('form').reset();
        });

        // Handle form submission
        document.querySelector('#createComplaintModal form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Here you would normally send the data to your Laravel backend
            // For demo purposes, we'll just show a success message
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('createComplaintModal'));
            modal.hide();
            
            // Show success message (you can replace this with a proper notification system)
            alert('Pengaduan berhasil dikirim! Anda akan mendapat notifikasi ketika ada update.');
        });

        // Handle tab switching
        document.querySelectorAll('#complaintTabs button').forEach(tab => {
            tab.addEventListener('shown.bs.tab', function(e) {
                // You can add logic here to load different content based on the active tab
                console.log('Active tab:', e.target.id);
            });
        });

        // Handle like button clicks
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-outline-success')) {
                const button = e.target.closest('.btn-outline-success');
                if (button.innerHTML.includes('thumbs-up')) {
                    // Toggle like state
                    const currentCount = parseInt(button.textContent.match(/\d+/)[0]);
                    const isLiked = button.classList.contains('btn-success');
                    
                    if (isLiked) {
                        button.classList.remove('btn-success');
                        button.classList.add('btn-outline-success');
                        button.innerHTML = `<i class="fas fa-thumbs-up"></i> ${currentCount - 1}`;
                    } else {
                        button.classList.remove('btn-outline-success');
                        button.classList.add('btn-success');
                        button.innerHTML = `<i class="fas fa-thumbs-up"></i> ${currentCount + 1}`;
                    }
                }
            }
        });

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

        // Add loading state to buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-primary-custom, .btn-success-custom')) {
                const button = e.target.closest('.btn-primary-custom, .btn-success-custom');
                const originalText = button.innerHTML;
                
                button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                button.disabled = true;
                
                // Re-enable after 2 seconds (replace with actual API call completion)
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 2000);
            }
        });
    </script>
</body>
</html>