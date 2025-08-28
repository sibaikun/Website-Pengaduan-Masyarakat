<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengaduan - Portal Pengaduan Masyarakat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .modal-enter {
            animation: modalEnter 0.2s ease-out;
        }
        @keyframes modalEnter {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body class="bg-gray-100">
<div class="min-h-screen flex flex-col">
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
                                <a href="/home" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                    <i class="fas fa-home mr-2"></i>Home
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

    <!-- Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-list text-red-500 mr-3"></i> Daftar Pengaduan Saya
                </h2>
                <a href="{{ route('complaints.create') }}" class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition">
                    <i class="fas fa-plus mr-2"></i>Buat Pengaduan
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Foto</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Judul</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Isi Pengaduan</th> {{-- Kolom baru --}}
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kategori</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Lokasi</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Balasan Admin</th> {{-- Kolom baru --}}
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Dibuat</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($complaints as $complaint)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3">
                                @if($complaint->image_path)
                                    <img src="{{ asset('storage/'.$complaint->image_path) }}" 
                                        alt="Complaint Image" 
                                        class="w-12 h-12 rounded-lg object-cover border border-gray-200 cursor-pointer hover:shadow-lg transition-shadow"
                                        onclick="openImageModal('{{ asset('storage/'.$complaint->image_path) }}')">
                                @else
                                    <div class="w-12 h-12 rounded-lg border border-dashed border-gray-300 flex items-center justify-center text-[10px] text-gray-500 bg-gray-50">
                                        No Photo
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="max-w-xs">
                                    <p class="font-medium text-gray-800">{{ $complaint->title }}</p>
                                </div>
                            </td>

                            {{-- Isi Pengaduan --}}
                            <td class="px-4 py-3">
                                <div class="max-w-sm">
                                    <p id="user-content-preview-{{ $complaint->id }}" class="text-sm text-gray-700 leading-relaxed">
                                        {{ Str::limit($complaint->content, 100, '...') }}
                                    </p>
                                    <p id="user-content-full-{{ $complaint->id }}" class="text-sm text-gray-700 leading-relaxed hidden">
                                        {{ $complaint->content }}
                                    </p>
                                    @if(strlen($complaint->content) > 100)
                                        <button onclick="toggleUserContent({{ $complaint->id }})" 
                                                class="text-blue-500 text-xs hover:underline mt-1">
                                            <span id="user-toggle-text-{{ $complaint->id }}">Lihat selengkapnya</span>
                                        </button>
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $categories[$complaint->category] ?? ucfirst(str_replace('_', ' ', $complaint->category)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-start text-sm text-gray-600 max-w-xs">
                                    <i class="fas fa-map-marker-alt text-red-500 mr-1 mt-0.5 flex-shrink-0"></i>
                                    <div>
                                        <span id="location-preview-{{ $complaint->id }}" class="text-sm text-gray-700">
                                            {{ Str::limit($complaint->location, 50, '...') }}
                                        </span>
                                        <span id="location-full-{{ $complaint->id }}" class="text-sm text-gray-700 hidden">
                                            {{ $complaint->location }}
                                        </span>
                                        @if(strlen($complaint->location) > 50)
                                            <button onclick="toggleLocationContent({{ $complaint->id }})" 
                                                    class="text-blue-500 text-xs hover:underline ml-1">
                                                <span id="location-toggle-text-{{ $complaint->id }}">Lihat selengkapnya</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if ($complaint->status == 'pending')
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full font-medium">Pending</span>
                                @elseif ($complaint->status == 'processing')
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full font-medium">Diproses</span>
                                @elseif ($complaint->status == 'resolved')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">Selesai</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full font-medium">Ditolak</span>
                                @endif
                            </td>

                            {{-- Balasan Admin --}}
                            <td class="px-4 py-3">
                                <div class="max-w-xs">
                                    @if($complaint->admin_response)
                                        <div class="bg-blue-50 p-3 rounded-lg border-l-4 border-blue-400">
                                            <p class="text-sm text-blue-800 font-medium mb-1">
                                                <i class="fas fa-user-tie mr-1"></i>Balasan Admin:
                                            </p>
                                            <p class="text-sm text-gray-700">{{ $complaint->admin_response }}</p>
                                            @if($complaint->responded_at)
                                                <p class="text-xs text-gray-500 mt-1">
                                                    <i class="fas fa-clock mr-1"></i>{{ $complaint->responded_at->diffForHumans() }}
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-center py-2">
                                            <i class="fas fa-hourglass-half text-gray-300 text-lg mb-1"></i>
                                            <p class="text-xs text-gray-400">Menunggu balasan</p>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-500">
                                <div class="flex flex-col">
                                    <span>{{ $complaint->created_at->format('d M Y') }}</span>
                                    <span class="text-xs text-gray-400">{{ $complaint->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('complaints.edit', $complaint->id) }}" 
                                       class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition inline-flex items-center text-xs">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('complaints.destroy', $complaint->id) }}" 
                                          method="POST" class="inline" 
                                          onsubmit="return showDeleteConfirmation(event, '{{ addslashes($complaint->title) }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition inline-flex items-center text-xs">
                                            <i class="fas fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                                <i class="fas fa-inbox text-gray-300 text-2xl mb-2"></i><br>
                                Belum ada pengaduan yang dibuat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $complaints->links() }}</div>
        </div>
    </main>

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
            <p class="text-gray-500 text-sm">© 2025 Kelurahan Sawah Besar - Kota Semarang. All rights reserved.</p>
        </div>
    </footer>
</div>

<!-- Modal untuk menampilkan gambar full -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50">
    <span class="absolute top-4 right-6 text-white text-3xl cursor-pointer" onclick="closeImageModal()">&times;</span>
    <img id="modalImage" src="" class="max-h-[90%] max-w-[90%] rounded-lg shadow-lg">
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 modal-enter">
        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
            <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Konfirmasi Penghapusan</h3>
        <p class="text-gray-600 text-center mb-6">
            Yakin ingin menghapus pengaduan "<span id="itemTitle" class="font-semibold text-gray-800"></span>"? 
            <br><span class="text-sm text-red-600">Tindakan ini tidak dapat dibatalkan.</span>
        </p>
        <div class="flex space-x-3">
            <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium">
                <i class="fas fa-times mr-2"></i>Batal
            </button>
            <button onclick="confirmDelete()" class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-medium">
                <i class="fas fa-trash mr-2"></i>Hapus
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // User menu toggle
    const button = document.getElementById("userMenuButton");
    const menu = document.getElementById("userMenu");
    button.addEventListener("click", () => menu.classList.toggle("hidden"));
    document.addEventListener("click", (e) => {
        if (!button.contains(e.target) && !menu.contains(e.target)) menu.classList.add("hidden");
    });

    // Image modal functions
    window.openImageModal = function(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
    };
    
    window.closeImageModal = function() {
        document.getElementById('imageModal').classList.add('hidden');
    };

    // Close modal when clicking outside or pressing escape
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });

    // Toggle content function for user complaints
    window.toggleUserContent = function(complaintId) {
        const previewContent = document.getElementById(`user-content-preview-${complaintId}`);
        const fullContent = document.getElementById(`user-content-full-${complaintId}`);
        const toggleText = document.getElementById(`user-toggle-text-${complaintId}`);
        
        if (previewContent.classList.contains('hidden')) {
            // Tampilkan preview, sembunyikan full
            previewContent.classList.remove('hidden');
            fullContent.classList.add('hidden');
            toggleText.textContent = 'Lihat selengkapnya';
        } else {
            // Sembunyikan preview, tampilkan full
            previewContent.classList.add('hidden');
            fullContent.classList.remove('hidden');
            toggleText.textContent = 'Sembunyikan';
        }
    };

    // Toggle location content function
    window.toggleLocationContent = function(complaintId) {
        const previewLocation = document.getElementById(`location-preview-${complaintId}`);
        const fullLocation = document.getElementById(`location-full-${complaintId}`);
        const toggleText = document.getElementById(`location-toggle-text-${complaintId}`);
        
        if (previewLocation.classList.contains('hidden')) {
            // Tampilkan preview, sembunyikan full
            previewLocation.classList.remove('hidden');
            fullLocation.classList.add('hidden');
            toggleText.textContent = 'Lihat selengkapnya';
        } else {
            // Sembunyikan preview, tampilkan full
            previewLocation.classList.add('hidden');
            fullLocation.classList.remove('hidden');
            toggleText.textContent = 'Sembunyikan';
        }
    };

    // Delete modal
    let currentDeleteForm = null;
    window.showDeleteConfirmation = function(event, title) {
        event.preventDefault();
        currentDeleteForm = event.target;
        document.getElementById('itemTitle').textContent = title;
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        return false;
    };
    window.closeDeleteModal = function() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    };
    window.confirmDelete = function() {
        if (currentDeleteForm && typeof currentDeleteForm.submit === 'function') {
            const formToSubmit = currentDeleteForm;
            closeDeleteModal();
            setTimeout(() => {
                formToSubmit.submit();
                currentDeleteForm = null;
            }, 100);
        }
    };
    document.getElementById('deleteModal').addEventListener('click', e => {
        if (e.target === e.currentTarget) closeDeleteModal();
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeDeleteModal();
    });
});
</script>
</body>
</html>