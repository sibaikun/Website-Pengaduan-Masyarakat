<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pengaduan Masyarakat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-red-500 text-white shadow-lg">
            <div class="container mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/Lambang_Kota_Semarang.png') }}" 
                            alt="Logo Semarang" 
                            class="h-12 bg-white p-1 rounded-lg shadow">
                        <h1 class="text-xl font-bold text-white">Kelurahan Sawah Besar</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="hidden md:inline">Halo, {{ auth()->user()->name }}</span>
                        <div class="relative inline-block">
                            <button id="userMenuButton" class="bg-red-600 px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                <i class="fas fa-user"></i>
                            </button>
                            <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden">
                                <a href="/profile" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                    <i class="fas fa-user-edit mr-2"></i>Profile
                                </a>
                                <a href="/complaints" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                    <i class="fas fa-list mr-2"></i>Pengaduan Saya
                                </a>
                                <form method="POST" action="/logout" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Welcome Section -->
        <section class="bg-red-500 text-white py-12">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl font-bold mb-4">Portal Pengaduan Masyarakat</h1>
                <p class="text-xl mb-2">Suarakan aspirasi Anda untuk lingkungan yang lebih baik.</p>
                <p class="text-lg mb-8">Kami mendengar, kami tanggap, kami bertindak.</p>
                
                <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-4">
                    <a href="/complaints" class="bg-yellow-500 text-black px-6 py-3 rounded-lg font-semibold hover:bg-yellow-400 transition-colors inline-flex items-center justify-center">
                        <i class="fas fa-eye mr-2"></i>Lihat Pengaduan
                    </a>
                    <a href="/complaints/create" class="bg-red-600 px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors inline-flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i>Buat Pengaduan
                    </a>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-8 -mt-6 relative z-10">
            <div class="container mx-auto px-4">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                        <div class="p-4">
                            <div class="text-4xl font-bold text-red-500 mb-2">{{ $stats['total'] }}</div>
                            <div class="text-gray-600 font-medium">Total Pengaduan</div>
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-chart-line mr-1"></i>Semua waktu
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="text-4xl font-bold text-orange-500 mb-2">{{ $stats['processing'] }}</div>
                            <div class="text-gray-600 font-medium">Sedang Diproses</div>
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-clock mr-1"></i>Dalam antrian
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="text-4xl font-bold text-green-500 mb-2">{{ $stats['resolved'] }}</div>
                            <div class="text-gray-600 font-medium">Telah Selesai</div>
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-check-circle mr-1"></i>Terselesaikan
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="text-4xl font-bold text-blue-500 mb-2">{{ $stats['average_days'] }}</div>
                            <div class="text-gray-600 font-medium">Rata-rata Hari</div>
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-calendar-alt mr-1"></i>Waktu penyelesaian
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- User's Recent Complaints -->
        <section class="py-8">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Pengaduan Saya -->
                    <div class="bg-white rounded-lg shadow-lg">
                        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-2xl font-bold flex items-center text-gray-800">
                                <i class="fas fa-user-edit text-red-500 mr-3"></i>
                                Pengaduan Saya
                            </h2>
                            <a href="/complaints" class="bg-red-100 text-red-600 px-4 py-2 rounded-lg hover:bg-red-200 transition-colors text-sm">
                                <i class="fas fa-arrow-right mr-1"></i>Lihat Semua
                            </a>
                        </div>
                        <div class="p-6 space-y-4">
                            @forelse($myComplaints as $complaint)
                                <div class="flex items-start space-x-4 border-l-4 
                                    @if($complaint->status == 'resolved') border-green-500 bg-green-50
                                    @elseif($complaint->status == 'processing') border-yellow-500 bg-yellow-50
                                    @else border-red-500 bg-red-50 @endif
                                    pl-4 py-3 rounded-r-lg">
                                    
                                    {{-- Thumbnail gambar --}}
                                    @if($complaint->image_path)
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('storage/'.$complaint->image_path) }}" 
                                                alt="Complaint Image" 
                                                class="w-16 h-16 rounded-lg object-cover border border-gray-200 cursor-pointer"
                                                onclick="openImageModal('{{ asset('storage/'.$complaint->image_path) }}')">
                                        </div>
                                    @else
                                        <div class="flex-shrink-0 w-16 h-16 rounded-lg border border-dashed border-gray-300 flex items-center justify-center text-[10px] text-gray-500 bg-gray-50">
                                            Tidak ada foto
                                        </div>
                                    @endif

                                    {{-- Isi pengaduan --}}
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-semibold text-gray-800">{{ $complaint->title }}</h4>
                                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                                @if($complaint->status == 'resolved') bg-green-100 text-green-800
                                                @elseif($complaint->status == 'processing') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($complaint->status) }}
                                            </span>
                                        </div>
                                        
                                        <div class="complaint-content" data-full="{{ $complaint->content }}">
                                            <p class="text-gray-600 text-sm mb-2 complaint-text">{{ Str::limit($complaint->content, 100) }}</p>
                                            @if(strlen($complaint->content) > 100)
                                                <button class="read-more-btn text-red-500 text-xs font-medium hover:text-red-700 transition-colors">
                                                    <i class="fas fa-chevron-down mr-1"></i>Baca selengkapnya
                                                </button>
                                            @endif
                                        </div>

                                        <div class="flex items-center text-xs text-gray-500 mb-2 mt-2">
                                            <i class="fas fa-clock mr-1"></i>{{ $complaint->created_at->diffForHumans() }}
                                        </div>

                                        {{-- Balasan Admin --}}
                                        @if($complaint->admin_response)
                                            <div class="mt-2 border-t border-gray-200 pt-2">
                                                <div class="bg-gray-100 p-2 rounded-lg">
                                                    <div class="flex items-center text-xs text-gray-500 mb-1">
                                                        <i class="fas fa-user-shield text-blue-500 mr-1"></i> 
                                                        <span class="font-semibold">Admin</span> 
                                                        @if($complaint->responded_at)
                                                            <span class="ml-2">· {{ \Carbon\Carbon::parse($complaint->responded_at)->diffForHumans() }}</span>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="admin-response" data-full="{{ $complaint->admin_response }}">
                                                        <p class="text-sm text-gray-700 admin-text">{{ Str::limit($complaint->admin_response, 100) }}</p>
                                                        @if(strlen($complaint->admin_response) > 100)
                                                            <button class="admin-read-more-btn text-blue-500 text-xs font-medium hover:text-blue-700 transition-colors">
                                                                <i class="fas fa-chevron-down mr-1"></i>Baca selengkapnya
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">Belum ada pengaduan.</p>
                            @endforelse

                            <div class="mt-6 text-center">
                                <a href="{{ route('complaints.create') }}" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition-colors inline-flex items-center">
                                    <i class="fas fa-plus mr-2"></i>
                                    Buat Pengaduan Baru
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Pengaduan Terbaru -->
                    <div class="bg-white rounded-lg shadow-lg">
                        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-2xl font-bold flex items-center text-gray-800">
                                <i class="fas fa-comments text-blue-500 mr-3"></i>
                                Pengaduan Terbaru
                            </h2>
                        </div>
                        <div class="p-6 space-y-4 max-h-96 overflow-y-auto">
                            @forelse($recentComplaints as $complaint)
                                <div class="flex items-start space-x-4 border-l-4 border-blue-500 pl-4 py-3 hover:bg-blue-50 transition-colors rounded-lg">
                                    
                                    {{-- Thumbnail gambar --}}
                                    @if($complaint->image_path)
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('storage/'.$complaint->image_path) }}" 
                                                alt="Complaint Image" 
                                                class="w-16 h-16 rounded-lg object-cover border border-gray-200 cursor-pointer"
                                                onclick="openImageModal('{{ asset('storage/'.$complaint->image_path) }}')">
                                        </div>
                                    @else
                                        <div class="flex-shrink-0 w-16 h-16 rounded-lg border border-dashed border-gray-300 flex items-center justify-center text-[10px] text-gray-500 bg-gray-50">
                                            Tidak ada foto
                                        </div>
                                    @endif

                                    {{-- Isi pengaduan --}}
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-800 mb-1">{{ $complaint->title }}</h4>
                                        
                                        <div class="complaint-content" data-full="{{ $complaint->content }}">
                                            <p class="text-gray-600 text-sm mb-2 complaint-text">{{ Str::limit($complaint->content, 100) }}</p>
                                            @if(strlen($complaint->content) > 100)
                                                <button class="read-more-btn text-blue-500 text-xs font-medium hover:text-blue-700 transition-colors">
                                                    <i class="fas fa-chevron-down mr-1"></i>Baca selengkapnya
                                                </button>
                                            @endif
                                        </div>
                                        
                                        {{-- Info pengaduan --}}
                                        <div class="flex justify-between items-center text-xs text-gray-500 mb-2 mt-2">
                                            <div class="flex items-center">
                                                <i class="fas fa-user mr-1"></i> {{ $complaint->user->name }}
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-clock mr-1"></i> {{ $complaint->created_at->diffForHumans() }}
                                            </div>
                                        </div>

                                        {{-- Balasan Admin --}}
                                        @if($complaint->admin_response)
                                            <div class="mt-2 border-t border-gray-200 pt-2">
                                                <div class="bg-gray-100 p-2 rounded-lg">
                                                    <div class="flex items-center text-xs text-gray-500 mb-1">
                                                        <i class="fas fa-user-shield text-blue-500 mr-1"></i> 
                                                        <span class="font-semibold">Admin</span> 
                                                        @if($complaint->responded_at)
                                                            <span class="ml-2">· {{ \Carbon\Carbon::parse($complaint->responded_at)->diffForHumans() }}</span>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="admin-response" data-full="{{ $complaint->admin_response }}">
                                                        <p class="text-sm text-gray-700 admin-text">{{ Str::limit($complaint->admin_response, 100) }}</p>
                                                        @if(strlen($complaint->admin_response) > 100)
                                                            <button class="admin-read-more-btn text-blue-500 text-xs font-medium hover:text-blue-700 transition-colors">
                                                                <i class="fas fa-chevron-down mr-1"></i>Baca selengkapnya
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">Belum ada pengaduan terbaru.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Modal untuk menampilkan gambar full -->
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50">
            <span class="absolute top-4 right-6 text-white text-3xl cursor-pointer" onclick="closeImageModal()">&times;</span>
            <img id="modalImage" src="" class="max-h-[90%] max-w-[90%] rounded-lg shadow-lg">
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="container mx-auto px-4 text-center">
                <p class="text-gray-400 mb-4">Portal Pengaduan Masyarakat</p>
                <p class="text-gray-500 text-sm">© 2025 Kelurahan Sawah Besar - Kota Semarang. All rights reserved.</p>
            </div>
        </footer>
    </div>
    
    <script>
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

            // Fungsi Read More untuk pengaduan
            initializeReadMore();
        });

        function initializeReadMore() {
            // Proses semua elemen dengan class complaint-content
            document.querySelectorAll('.complaint-content').forEach(function(element) {
                const fullText = element.getAttribute('data-full');
                const textElement = element.querySelector('.complaint-text');
                const button = element.querySelector('.read-more-btn');
                
                if (fullText && fullText.length > 100) {
                    const shortText = fullText.substring(0, 100) + '...';
                    let isExpanded = false;
                    
                    textElement.textContent = shortText;
                    
                    button.addEventListener('click', function() {
                        if (!isExpanded) {
                            textElement.textContent = fullText;
                            button.innerHTML = '<i class="fas fa-chevron-up mr-1"></i>Tutup';
                            isExpanded = true;
                        } else {
                            textElement.textContent = shortText;
                            button.innerHTML = '<i class="fas fa-chevron-down mr-1"></i>Baca selengkapnya';
                            isExpanded = false;
                        }
                    });
                } else {
                    // Jika teks pendek, sembunyikan tombol
                    if (button) button.style.display = 'none';
                }
            });

            // Proses semua elemen admin-response
            document.querySelectorAll('.admin-response').forEach(function(element) {
                const fullText = element.getAttribute('data-full');
                const textElement = element.querySelector('.admin-text');
                const button = element.querySelector('.admin-read-more-btn');
                
                if (fullText && fullText.length > 100) {
                    const shortText = fullText.substring(0, 100) + '...';
                    let isExpanded = false;
                    
                    textElement.textContent = shortText;
                    
                    button.addEventListener('click', function() {
                        if (!isExpanded) {
                            textElement.textContent = fullText;
                            button.innerHTML = '<i class="fas fa-chevron-up mr-1"></i>Tutup';
                            isExpanded = true;
                        } else {
                            textElement.textContent = shortText;
                            button.innerHTML = '<i class="fas fa-chevron-down mr-1"></i>Baca selengkapnya';
                            isExpanded = false;
                        }
                    });
                } else {
                    // Jika teks pendek, sembunyikan tombol
                    if (button) button.style.display = 'none';
                }
            });
        }

        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
    </script>
</body>
</html>