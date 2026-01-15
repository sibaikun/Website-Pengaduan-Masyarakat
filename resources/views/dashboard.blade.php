<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Sabes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">

        <!-- Header -->
        <header class="bg-gray-800 text-white shadow-lg">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/Lambang_Kota_Semarang.png') }}" 
                         alt="Logo Semarang" 
                         class="h-12 bg-white p-1 rounded-lg shadow">
                    <h1 class="text-xl font-bold">Kelurahan Sawah Besar - Admin</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="hidden md:inline">Halo, {{ auth()->user()->name }}</span>
                    <div class="relative inline-block">
                        <button id="userMenuButton" class="bg-red-600 px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-user-cog"></i>
                        </button>
                        <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden">
                            <a href="{{ route('admin.complaints.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <i class="fas fa-database mr-2"></i>Kelola Pengaduan
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Welcome Section -->
        <section class="bg-gray-700 text-white py-12">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl font-bold mb-2">Kelola Pengaduan</h1>
                <p class="text-lg">Kelola & pantau seluruh pengaduan masyarakat</p>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-8 -mt-6 relative z-10">
            <div class="container mx-auto px-4">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                        <div class="p-4">
                            <div class="text-4xl font-bold text-red-500 mb-2">{{ $stats['total'] ?? 0 }}</div>
                            <div class="text-gray-600 font-medium">Total Pengaduan</div>
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-chart-line mr-1"></i>Semua waktu
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="text-4xl font-bold text-orange-500 mb-2">{{ $stats['processing'] ?? 0 }}</div>
                            <div class="text-gray-600 font-medium">Sedang Diproses</div>
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-clock mr-1"></i>Dalam antrian
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="text-4xl font-bold text-green-500 mb-2">{{ $stats['resolved'] ?? 0 }}</div>
                            <div class="text-gray-600 font-medium">Telah Selesai</div>
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-check-circle mr-1"></i>Terselesaikan
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="text-4xl font-bold text-blue-500 mb-2">{{ $stats['pending'] ?? 0 }}</div>
                            <div class="text-gray-600 font-medium">Menunggu</div>
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-hourglass-half mr-1"></i>Perlu tindakan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Complaints Overview -->
        <section class="py-8">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
                    
                    <!-- Pengaduan Terbaru -->
                    <div class="bg-white rounded-lg shadow-lg h-full flex flex-col">
                        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-2xl font-bold flex items-center text-gray-800">
                                <i class="fas fa-list text-gray-600 mr-3"></i>
                                Pengaduan Terbaru
                            </h2>
                            <a href="{{ route('admin.complaints.dashboard') }}" 
                            class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                                <i class="fas fa-arrow-right mr-1"></i>Kelola Semua
                            </a>
                        </div>
                        <div class="p-6 space-y-4 max-h-96 overflow-y-auto flex-1">
                            @forelse($recentComplaints as $complaint)
                                <div class="border-l-4 
                                    @if($complaint->status == 'resolved') border-green-500 bg-green-50
                                    @elseif($complaint->status == 'processing') border-blue-500 bg-blue-50
                                    @elseif($complaint->status == 'pending') border-yellow-500 bg-yellow-50
                                    @else border-red-500 bg-red-50 @endif
                                    pl-4 py-3 rounded-r-lg hover:shadow-sm transition-all flex space-x-4">

                                    {{-- Thumbnail gambar jika ada, kalau tidak tampilkan kotak kosong --}}
                                    @if($complaint->image_path)
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('storage/'.$complaint->image_path) }}" 
                                                alt="Complaint Image" 
                                                class="w-16 h-16 rounded-lg object-cover border border-gray-200 cursor-pointer"
                                                onclick="openImageModal('{{ asset('storage/'.$complaint->image_path) }}')">
                                        </div>
                                    @else
                                        <div class="flex-shrink-0 w-16 h-16 rounded-lg border border-dashed border-gray-300 flex items-center justify-center text-xs text-gray-500 bg-gray-50">
                                            Tidak ada foto
                                        </div>
                                    @endif

                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-semibold text-gray-800">{{ $complaint->title }}</h4>
                                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                                @if($complaint->status == 'resolved') bg-green-100 text-green-800
                                                @elseif($complaint->status == 'processing') bg-blue-100 text-blue-800
                                                @elseif($complaint->status == 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($complaint->status) }}
                                            </span>
                                        </div>

                                        <p class="text-gray-600 text-sm mb-2">
                                            {{ Str::limit($complaint->content, 80) }}
                                        </p>

                                        {{-- Tanggapan admin jika ada --}}
                                        @if($complaint->admin_response)
                                            <div class="text-sm text-blue-700 bg-blue-50 border border-blue-200 rounded p-2 mb-2">
                                                <i class="fas fa-reply mr-1"></i> {{ Str::limit($complaint->admin_response, 80) }}
                                            </div>
                                        @endif

                                        <div class="flex justify-between items-center text-xs text-gray-500">
                                            <div class="flex items-center">
                                                <i class="fas fa-user mr-1"></i> {{ $complaint->user->name }}
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-clock mr-1"></i> {{ $complaint->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <i class="fas fa-inbox text-gray-300 text-4xl mb-4"></i>
                                    <p class="text-gray-500">Belum ada pengaduan terbaru.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Statistik Kategori -->
                    <div class="bg-white rounded-lg shadow-lg h-full flex flex-col">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                                <i class="fas fa-chart-pie text-blue-500 mr-3"></i>
                                Statistik Kategori
                            </h2>
                        </div>
                        <div class="p-6 flex-1">
                            @forelse($categoryStats ?? [] as $category)
                                <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-blue-500 mr-3"></div>
                                        <span class="text-gray-700 capitalize">{{ str_replace('_', ' ', $category->category) }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="font-semibold text-gray-800">{{ $category->count }}</span>
                                        <span class="text-xs text-gray-500">pengaduan</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <i class="fas fa-chart-bar text-gray-300 text-4xl mb-4"></i>
                                    <p class="text-gray-500">Belum ada data statistik kategori.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="container mx-auto px-4 text-center">
                <p class="text-gray-400 mb-2">Portal Pengaduan Masyarakat - Admin</p>
                <p class="text-gray-500 text-sm">© 2025 Kelurahan Sawah Besar - Kota Semarang. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Modal Gambar -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden justify-center items-center z-50">
        <div class="relative">
            <button onclick="closeImageModal()" 
                    class="absolute top-2 right-2 bg-white rounded-full p-2 shadow hover:bg-gray-100">
                <i class="fas fa-times text-gray-700"></i>
            </button>
            <img id="modalImage" src="" alt="Preview" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-lg">
        </div>
    </div>

    <script>
    // User Menu
    document.addEventListener("DOMContentLoaded", function () {
        const button = document.getElementById("userMenuButton");
        const menu = document.getElementById("userMenu");

        button.addEventListener("click", function () {
            menu.classList.toggle("hidden");
        });

        document.addEventListener("click", function (e) {
            if (!button.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add("hidden");
            }
        });
    });

    // Klik Foto
    function openImageModal(src) {
    const modal = document.getElementById("imageModal");
    const modalImage = document.getElementById("modalImage");

    modalImage.src = src;
    modal.classList.remove("hidden");
    modal.classList.add("flex"); // supaya modal muncul dengan flexbox center
    }

    function closeImageModal() {
    const modal = document.getElementById("imageModal");
    modal.classList.remove("flex");
    modal.classList.add("hidden");
    }
    </script>
</body>
</html>