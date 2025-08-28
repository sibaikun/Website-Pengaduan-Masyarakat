<!-- resources/views/complaints/public.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Terbaru - Portal Pengaduan Masyarakat</title>
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
                        <a href="{{ route('login') }}" 
                           class="bg-red-600 px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                           <i class="fas fa-sign-in-alt mr-1"></i>Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-yellow-500 text-black px-4 py-2 rounded-lg hover:bg-yellow-400 transition-colors">
                           <i class="fas fa-user-plus mr-1"></i>Register
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Pengaduan Terbaru -->
        <section class="py-8">
            <div class="container mx-auto px-4">
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
                                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($complaint->content, 80) }}</p>
                                    
                                    {{-- Info pengaduan --}}
                                    <div class="flex justify-between items-center text-xs text-gray-500 mb-2">
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
                                                <p class="text-sm text-gray-700">{{ $complaint->admin_response }}</p>
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
        </section>

        <!-- Modal untuk menampilkan gambar full -->
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50">
            <span class="absolute top-4 right-6 text-white text-3xl cursor-pointer" onclick="closeImageModal()">&times;</span>
            <img id="modalImage" src="" class="max-h-[90%] max-w-[90%] rounded-lg shadow-lg">
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="container mx-auto px-4 text-center">
                <div class="flex justify-center items-center mb-4">
                    <div class="bg-white p-2 rounded-lg mr-3">
                        <img src="{{ asset('images/Lambang_Kota_Semarang.png') }}" 
                            alt="Logo Semarang" 
                            class="h-12 bg-white p-1 rounded-lg shadow">
                    </div>
                    <span class="text-xl font-bold">Kelurahan Sawah Besar</span>
                </div>
                <p class="text-gray-400 mb-4">Portal Pengaduan Masyarakat</p>
                <p class="text-gray-500 text-sm">
                    © 2025 Kelurahan Sawah Besar - Kota Semarang. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
    <script>
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
