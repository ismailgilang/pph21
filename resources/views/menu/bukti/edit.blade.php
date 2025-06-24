<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Sidebar (Fixed width) -->
        <div class="w-64 flex-shrink-0 bg-indigo-800">
            <!-- Sidebar content here -->
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 overflow-x-hidden">
            <!-- Padding untuk konten utama -->
            <div class="p-8">
                <!-- Container dengan margin yang aman -->
                <div class="max-w-7xl mx-auto">
                    <!-- Notification Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex items-center">
                                <span class="text-lg font-medium text-gray-900">
                                    {{ __("Management Karyawan") }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <!-- Your main content here -->
                            <div class="w-full mx-auto p-6 bg-white rounded shadow ">
                                <h2 class="text-2xl font-semibold mb-6">Edit Karyawan</h2>

                                <form method="POST" action="{{ route('Bukti.update', $bukti->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="users" value="{{$bukti->users}}">

                                    <div class="mb-4">
                                        <label for="file" class="block text-gray-700 font-medium mb-2">File (Gambar atau PDF)</label>
                                        <input
                                            type="file"
                                            id="file"
                                            name="file"
                                            accept="image/*,.pdf"
                                            class="w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />

                                        @error('file')
                                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror

                                        {{-- Preview file lama --}}
                                        <div id="new-file-preview" class="mt-4 hidden">
                                            <p class="text-sm text-gray-500 mb-2">Preview file baru:</p>
                                            <img id="preview-img" class="max-w-xs rounded shadow border hidden" alt="Preview Gambar">
                                            <iframe id="preview-pdf" class="w-full h-96 border rounded shadow hidden" frameborder="0"></iframe>
                                        </div>
                                        @if($bukti->file)
                                        <div class="mt-3">
                                            <p class="text-sm text-gray-500 mb-1">File saat ini:</p>
                                            @php
                                            $ext = pathinfo($bukti->file, PATHINFO_EXTENSION);
                                            @endphp

                                            @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                            <img src="{{ asset('storage/' . $bukti->file) }}" alt="File Lama" class="max-w-xs rounded shadow border">
                                            @elseif($ext === 'pdf')
                                            <iframe src="{{ asset('storage/' . $bukti->file) }}" class="w-full h-96 border rounded shadow" frameborder="0"></iframe>
                                            @else
                                            <a href="{{ asset('storage/' . $bukti->file) }}" target="_blank" class="text-indigo-600 underline">
                                                Lihat File
                                            </a>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('Bukti.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-gray-800">Batal</a>
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 rounded text-white hover:bg-indigo-700">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const fileInput = document.getElementById('file');
        const previewWrapper = document.getElementById('new-file-preview');
        const previewImg = document.getElementById('preview-img');
        const previewPdf = document.getElementById('preview-pdf');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file) return;

            const fileType = file.type;

            previewImg.classList.add('hidden');
            previewPdf.classList.add('hidden');
            previewWrapper.classList.remove('hidden');

            const reader = new FileReader();
            reader.onload = function(e) {
                if (fileType.startsWith('image/')) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                } else if (fileType === 'application/pdf') {
                    previewPdf.src = e.target.result;
                    previewPdf.classList.remove('hidden');
                } else {
                    previewWrapper.classList.add('hidden');
                }
            };

            reader.readAsDataURL(file);
        });
    </script>
</x-app-layout>