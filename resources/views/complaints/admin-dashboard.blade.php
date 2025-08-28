<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengaduan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

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
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                            <i class="fas fa-house mr-2"></i>Home
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

    <!-- Title Section -->
    <section class="bg-gray-700 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-2">Kelola Pengaduan</h1>
            <p class="text-lg">Pantau & tindaklanjuti pengaduan masyarakat</p>
        </div>
    </section>

    <!-- Table Section -->
    <section class="py-8 -mt-6 relative z-10">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-database text-blue-500 mr-3"></i>
                    Daftar Pengaduan
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border text-left">Pelapor</th>
                                <th class="px-4 py-2 border text-left">Judul</th>
                                <th class="px-4 py-2 border text-left">Isi Pengaduan</th> {{-- Kolom baru untuk keterangan --}}
                                <th class="px-4 py-2 border text-left">Kategori</th> {{-- Kolom kategori --}}
                                <th class="px-4 py-2 border text-left">Lokasi</th> {{-- Kolom lokasi --}}
                                <th class="px-4 py-2 border text-center">Foto</th>
                                <th class="px-4 py-2 border text-center">Status</th>
                                <th class="px-4 py-2 border text-left">Balasan Admin</th>
                                <th class="px-4 py-2 border text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentComplaints as $complaint)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-2 border">{{ $complaint->user->name ?? 'Anonim' }}</td>
                                    <td class="px-4 py-2 border">
                                        <div class="max-w-xs">
                                            <p class="font-semibold text-gray-800">{{ $complaint->title }}</p>
                                        </div>
                                    </td>

                                    {{-- Isi Pengaduan / Keterangan --}}
                                    <td class="px-4 py-2 border">
                                        <div class="max-w-sm">
                                            <p class="text-sm text-gray-700 leading-relaxed">
                                                {{ Str::limit($complaint->content, 150, '...') }}
                                            </p>
                                            @if(strlen($complaint->content) > 150)
                                                <button onclick="toggleContent({{ $complaint->id }})" 
                                                        class="text-blue-500 text-xs hover:underline mt-1">
                                                    <span id="toggle-text-{{ $complaint->id }}">Lihat selengkapnya</span>
                                                </button>
                                                <div id="full-content-{{ $complaint->id }}" class="hidden mt-2 text-sm text-gray-700">
                                                    {{ $complaint->content }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Kategori --}}
                                    <td class="px-4 py-2 border">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ ucfirst($complaint->category) }}
                                        </span>
                                    </td>

                                    {{-- Lokasi --}}
                                    <td class="px-4 py-2 border">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                                            {{ $complaint->location }}
                                        </div>
                                    </td>

                                    {{-- Thumbnail Foto --}}
                                    <td class="px-4 py-2 border text-center">
                                        @if($complaint->image_path)
                                            <a href="{{ asset('storage/' . $complaint->image_path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $complaint->image_path) }}" 
                                                    alt="Lampiran" 
                                                    class="h-16 w-16 object-cover rounded shadow hover:scale-105 transition-transform">
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic text-xs">Tidak ada foto</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-4 py-2 border text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                            @if($complaint->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($complaint->status == 'processing') bg-blue-100 text-blue-800
                                            @elseif($complaint->status == 'resolved') bg-green-100 text-green-800
                                            @elseif($complaint->status == 'rejected') bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($complaint->status) }}
                                        </span>
                                    </td>

                                    {{-- Balasan --}}
                                    <td class="px-4 py-2 border">
                                        <div class="max-w-xs">
                                            @if($complaint->admin_response)
                                                <p class="text-gray-700 text-sm">{{ $complaint->admin_response }}</p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Dibalas: {{ $complaint->responded_at?->diffForHumans() }}
                                                </p>
                                            @else
                                                <span class="text-gray-400 italic text-sm">Belum ada balasan</span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-4 py-2 border">
                                        <form action="{{ route('admin.complaints.updateStatus', $complaint->id) }}" method="POST" class="space-y-2">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="border rounded px-2 py-1 text-sm w-full">
                                                <option value="pending" @selected($complaint->status == 'pending')>Ditunda</option>
                                                <option value="processing" @selected($complaint->status == 'processing')>Diproses</option>
                                                <option value="resolved" @selected($complaint->status == 'resolved')>Diterima</option>
                                                <option value="rejected" @selected($complaint->status == 'rejected')>Ditolak</option>
                                            </select>
                                            <textarea name="admin_response" placeholder="Tulis balasan..." rows="2"
                                                class="border rounded px-2 py-1 text-sm block w-full resize-none">{{ old('admin_response', $complaint->admin_response) }}</textarea>
                                            <button type="submit"
                                                class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 w-full transition-colors">
                                                <i class="fas fa-save mr-1"></i>Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                                        <i class="fas fa-inbox text-gray-300 text-2xl mb-2"></i><br>
                                        Belum ada laporan masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-8">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400 mb-2">Portal Pengaduan Masyarakat - Admin</p>
            <p class="text-gray-500 text-sm">© 2025 Kelurahan Sawah Besar - Kota Semarang. All rights reserved.</p>
        </div>
    </footer>

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
    });

    // Fungsi untuk toggle konten lengkap
    function toggleContent(complaintId) {
        const fullContent = document.getElementById(`full-content-${complaintId}`);
        const toggleText = document.getElementById(`toggle-text-${complaintId}`);
        
        if (fullContent.classList.contains('hidden')) {
            fullContent.classList.remove('hidden');
            toggleText.textContent = 'Sembunyikan';
        } else {
            fullContent.classList.add('hidden');
            toggleText.textContent = 'Lihat selengkapnya';
        }
    }
    </script>
</body>
</html>