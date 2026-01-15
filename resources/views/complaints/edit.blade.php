<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengaduan - Portal Pengaduan Masyarakat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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

        <!-- Content -->
        <main class="flex-grow container mx-auto px-4 py-8">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-edit text-red-500 mr-3"></i>
                    {{ in_array($complaint->status, ['processing', 'resolved']) ? 'Detail Pengaduan' : 'Edit Pengaduan' }}
                </h2>

                {{-- Notifikasi Error --}}
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-6">
                        <strong>Terjadi kesalahan!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Info Status --}}
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Status pengaduan saat ini: 
                                @if ($complaint->status == 'pending')
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded font-semibold">Pending</span>
                                @elseif ($complaint->status == 'processing')
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded font-semibold">Diproses</span>
                                @elseif ($complaint->status == 'resolved')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded font-semibold">Selesai</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded font-semibold">Ditolak</span>
                                @endif
                            </p>
                            @if (in_array($complaint->status, ['processing', 'resolved']))
                                <p class="text-sm text-red-600 mt-1 font-medium">
                                    <i class="fas fa-lock mr-1"></i>
                                    Pengaduan tidak dapat diedit karena sudah {{ $complaint->status == 'processing' ? 'sedang diproses' : 'selesai ditangani' }}.
                                </p>
                            @elseif ($complaint->status == 'rejected')
                                <p class="text-sm text-orange-600 mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Pengaduan telah ditolak. Anda masih bisa mengedit untuk diajukan kembali.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Form atau View Only --}}
                @if (in_array($complaint->status, ['processing', 'resolved']))
                    {{-- View Only Mode --}}
                    <div class="space-y-6">
                        <!-- Judul -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Judul Pengaduan</label>
                            <div class="mt-1 p-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900">
                                {{ $complaint->title }}
                            </div>
                        </div>

                        <!-- Konten -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Isi Pengaduan</label>
                            <div class="mt-1 p-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 whitespace-pre-wrap">{{ $complaint->content }}</div>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <div class="mt-1 p-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900">
                                @if(isset($categories[$complaint->category]))
                                    {{ $categories[$complaint->category] }}
                                @else
                                    {{ $complaint->category }}
                                @endif
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                            <div class="mt-1 p-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900">
                                {{ $complaint->location }}
                            </div>
                        </div>

                        <!-- Foto -->
                        @if ($complaint->image_path)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Pengaduan</label>
                                <div class="flex justify-center">
                                    <img src="{{ asset('storage/' . $complaint->image_path) }}" 
                                         alt="Foto Pengaduan" 
                                         class="max-w-md h-auto rounded-lg shadow-lg border border-gray-300">
                                </div>
                            </div>
                        @endif

                        <!-- Status Publik -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status Publikasi</label>
                            <div class="mt-1 p-3 bg-gray-50 border border-gray-300 rounded-lg">
                                @if ($complaint->is_public)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-eye mr-1"></i>Publik
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-eye-slash mr-1"></i>Privat
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Editable Form --}}
                    <form action="{{ route('complaints.update', $complaint->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Judul -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul Pengaduan</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $complaint->title) }}"
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500" required>
                        </div>

                        <!-- Konten -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Isi Pengaduan</label>
                            <textarea id="content" name="content" rows="5"
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500" required>{{ old('content', $complaint->content) }}</textarea>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select id="category" name="category"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" 
                                        {{ old('category', $complaint->category) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Lokasi -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Lokasi</label>
                            <input type="text" id="location" name="location" value="{{ old('location', $complaint->location) }}"
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500" required>
                        </div>

                        <!-- Foto Saat Ini -->
                        @if ($complaint->image_path)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Foto Saat Ini</label>
                                <div class="mt-2 flex justify-center">
                                    <img src="{{ asset('storage/' . $complaint->image_path) }}" 
                                         alt="Foto Pengaduan" 
                                         class="max-w-md h-auto rounded-lg shadow-lg border border-gray-300">
                                </div>
                            </div>
                        @endif

                        <!-- Upload Foto -->
                        <div>
                            <label for="image_path" class="block text-sm font-medium text-gray-700">
                                @if ($complaint->image_path)
                                    Upload Foto Baru (Opsional)
                                @else
                                    Upload Foto <span class="text-red-500">*</span>
                                @endif
                            </label>
                            <div class="mt-1 flex items-center space-x-3">
                                <input type="file" id="image_path" name="image_path" accept="image/*" 
                                    {{ !$complaint->image_path ? 'required' : '' }}
                                    class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <div id="imagePreview" class="hidden">
                                    <img id="previewImg" class="h-20 w-20 object-cover rounded-lg border border-gray-300" alt="Preview">
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                                @if ($complaint->image_path)
                                    Kosongkan jika ingin tetap menggunakan foto yang ada. Upload foto baru akan mengganti foto lama. Format: JPG, PNG, JPEG (Maks 2MB)
                                @else
                                    Wajib upload foto sebagai bukti pengaduan. Format yang didukung: JPG, PNG, JPEG (Maksimal 2MB)
                                @endif
                            </p>
                        </div>

                        <!-- Apakah Publik -->
                        <div class="flex items-center">
                            <input id="is_public" name="is_public" type="checkbox" value="1"
                                {{ old('is_public', $complaint->is_public) ? 'checked' : '' }}
                                class="h-4 w-4 text-red-600 border-gray-300 rounded">
                            <label for="is_public" class="ml-2 text-sm text-gray-700">Tampilkan secara publik</label>
                        </div>

                        <!-- Tombol -->
                        <div class="flex justify-between">
                            <a href="{{ route('complaints.index') }}" 
                               class="px-6 py-2 rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 transition inline-flex items-center">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition inline-flex items-center">
                                <i class="fas fa-save mr-2"></i>Update Pengaduan
                            </button>
                        </div>
                    </form>
                @endif

                <!-- Info Tambahan -->
                <div class="bg-gray-50 p-4 rounded-lg mt-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-clock mr-2"></i>Informasi Pengaduan
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <span class="font-medium">Dibuat:</span> {{ $complaint->created_at->format('d M Y, H:i') }}
                        </div>
                        <div>
                            <span class="font-medium">Terakhir diubah:</span> {{ $complaint->updated_at->format('d M Y, H:i') }}
                        </div>
                        <div>
                            <span class="font-medium">Views:</span> {{ number_format($complaint->views) }}
                        </div>
                        <div>
                            <span class="font-medium">Likes:</span> {{ number_format($complaint->likes) }}
                        </div>
                    </div>
                    
                    @if ($complaint->admin_response)
                        <div class="mt-4 p-3 bg-blue-50 border-l-4 border-blue-400 rounded">
                            <h5 class="text-sm font-medium text-blue-800 mb-1">
                                <i class="fas fa-reply mr-1"></i>Respon Admin
                            </h5>
                            <p class="text-sm text-blue-700">{{ $complaint->admin_response }}</p>
                            @if ($complaint->responded_at)
                                <p class="text-xs text-blue-600 mt-1">
                                    Direspon: {{ $complaint->responded_at->format('d M Y, H:i') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Tombol untuk mode view-only -->
                @if (in_array($complaint->status, ['processing', 'resolved']))
                    <div class="flex justify-center mt-6">
                        <a href="{{ route('complaints.index') }}" 
                           class="px-6 py-2 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition inline-flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Pengaduan
                        </a>
                    </div>
                @endif
            </div>
        </main>

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

            // Image preview functionality (hanya jika dalam mode edit)
            const imageInput = document.getElementById('image_path');
            if (imageInput) {
                const imagePreview = document.getElementById("imagePreview");
                const previewImg = document.getElementById("previewImg");

                imageInput.addEventListener("change", function(e) {
                    const file = e.target.files[0];
                    
                    if (file) {
                        // Show preview tanpa client-side validation
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            imagePreview.classList.remove("hidden");
                        };
                        reader.readAsDataURL(file);
                    } else {
                        imagePreview.classList.add("hidden");
                    }
                });
            }
        });
    </script>
</body>
</html>