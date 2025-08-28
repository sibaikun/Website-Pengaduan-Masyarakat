{{-- resources/views/complaints/show.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                {{ $complaint->title }}
            </h1>

            {{-- Metadata --}}
            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                <span>Kategori: {{ ucfirst($complaint->category) }}</span> • 
                <span>Lokasi: {{ $complaint->location }}</span> • 
                <span>Status: 
                    <span class="px-2 py-1 rounded text-white
                        @if($complaint->status == 'pending') bg-yellow-500 
                        @elseif($complaint->status == 'processing') bg-blue-500
                        @elseif($complaint->status == 'resolved') bg-green-600
                        @else bg-red-500 @endif">
                        {{ ucfirst($complaint->status) }}
                    </span>
                </span>
            </div>

            {{-- Isi konten --}}
            <p class="text-gray-800 dark:text-gray-200 mb-6">
                {{ $complaint->content }}
            </p>

            {{-- Gambar dengan modal preview --}}
            @if($complaint->image_path)
                <div x-data="{ open: false }">
                    <img src="{{ asset('storage/'.$complaint->image_path) }}" 
                        alt="Complaint Image" 
                        class="w-full max-h-96 object-cover rounded-lg mb-6 cursor-pointer"
                        @click="open = true">

                    <!-- Modal -->
                    <div x-show="open" 
                        class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50"
                        @click.self="open = false">
                        <img src="{{ asset('storage/'.$complaint->image_path) }}" 
                            class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-lg">
                    </div>
                </div>
            @endif


            {{-- Admin Response --}}
            @if($complaint->admin_response)
                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg mb-6">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Tanggapan Admin</h3>
                    <p class="text-gray-700 dark:text-gray-200">{{ $complaint->admin_response }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        Ditanggapi pada {{ \Carbon\Carbon::parse($complaint->responded_at)->format('d M Y H:i') }}
                    </p>
                </div>
            @endif

            {{-- Likes & Views --}}
            <div class="flex justify-between items-center mt-6">
                <div class="flex items-center space-x-4">
                    <form action="{{ route('complaints.like', $complaint->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            👍 Like ({{ $complaint->likes }})
                        </button>
                    </form>
                    <span class="text-gray-600 dark:text-gray-400">
                        👁 {{ $complaint->views }} views
                    </span>
                </div>

                <a href="{{ route('complaints.index') }}" 
                   class="text-blue-600 hover:underline">
                    ← Kembali ke daftar
                </a>
            </div>
        </div>

        {{-- Related complaints --}}
        @if(isset($relatedComplaints) && $relatedComplaints->count())
            <div class="mt-10">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Keluhan Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($relatedComplaints as $related)
                        <a href="{{ route('complaints.show', $related->id) }}" 
                           class="block p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:shadow">
                            <h3 class="font-semibold text-gray-800 dark:text-white">
                                {{ $related->title }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                {{ Str::limit($related->content, 80) }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
