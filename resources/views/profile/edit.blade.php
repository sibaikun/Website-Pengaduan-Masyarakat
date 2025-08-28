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

    <!-- Profile Forms -->
    <main class="container mx-auto px-4 py-12 space-y-6">

        <!-- Update Profile -->
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-user-edit text-red-500 mr-3"></i>
                Perbarui Informasi Profil
            </h2>
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-lock text-red-500 mr-3"></i>
                Perbarui Password
            </h2>
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete User -->
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-trash-alt text-red-500 mr-3"></i>
                Hapus Akun
            </h2>
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400 mb-4">Portal Pengaduan Masyarakat</p>
            <p class="text-gray-500 text-sm">© 2025 Kelurahan Sawah Besar - Kota Semarang. All rights reserved.</p>
        </div>
    </footer>
</div>

<!-- Dropdown Script -->
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
</script>

