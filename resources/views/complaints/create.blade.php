<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengaduan - Portal Pengaduan Masyarakat</title>
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
                    <i class="fas fa-plus text-red-500 mr-3"></i>
                    Buat Pengaduan Baru
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

                {{-- Form --}}
                <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Judul -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Pengaduan</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500" required>
                    </div>

                    <!-- Konten -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Isi Pengaduan</label>
                        <textarea id="content" name="content" rows="5"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500" required>{{ old('content') }}</textarea>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select id="category" name="category"
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Lokasi</label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500" required>
                    </div>

                    <!-- Upload Foto - WAJIB -->
                    <div>
                        <label for="image_path" class="block text-sm font-medium text-gray-700">
                            Upload Foto <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 flex items-center space-x-3">
                            <input type="file" id="image_path" name="image_path" accept="image/*" required
                                class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <div id="imagePreview" class="hidden">
                                <img id="previewImg" class="h-20 w-20 object-cover rounded-lg border border-gray-300" alt="Preview">
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                            Wajib upload foto sebagai bukti pengaduan. Format yang didukung: JPG, PNG, JPEG (Maksimal 2MB)
                        </p>
                    </div>

                    <!-- Apakah Publik -->
                    <div class="flex items-center">
                        <input id="is_public" name="is_public" type="checkbox" value="1"
                            {{ old('is_public', true) ? 'checked' : '' }}
                            class="h-4 w-4 text-red-600 border-gray-300 rounded">
                        <label for="is_public" class="ml-2 text-sm text-gray-700">Tampilkan secara publik</label>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-between">
                        <a href="{{ route('complaints.index') }}" class="px-6 py-2 rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition">
                            Kirim Pengaduan
                        </button>
                    </div>
                </form>
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
                <p class="text-gray-500 text-sm">
                    © 2025 Kelurahan Sawah Besar - Kota Semarang. All rights reserved.
                </p>
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

            // Image preview functionality (tanpa client-side validation)
            const imageInput = document.getElementById("image_path");
            const imagePreview = document.getElementById("imagePreview");
            const previewImg = document.getElementById("previewImg");

            imageInput.addEventListener("change", function(e) {
                const file = e.target.files[0];
                
                if (file) {
                    // Hanya tampilkan preview, validasi diserahkan ke Laravel
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
        });
    </script>
</body>
</html>