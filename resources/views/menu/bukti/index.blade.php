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
                                    {{ __("Bukti Pembayaran Management") }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="p-4">
                                <div class="mb-4 flex justify-between items-center">
                                    <div>
                                        <h2 class="text-xl font-semibold">Bukti Pembayaran Table</h2>
                                    </div>
                                    <div class="flex gap-4">
                                        <!-- Button with icon (Edit) -->
                                        <!-- Tombol Tambah Data -->
                                        <button
                                            x-data
                                            x-on:click.prevent="$dispatch('open-modal', 'cetak-user')"
                                            class="flex items-center px-4 py-2 bg-sky-100 hover:bg-sky-600 rounded text-sm text-sky-700 hover:text-white transition-colors duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 512 512" fill="currentColor">
                                                <path d="M64 464l48 0 0 48-48 0c-35.3 0-64-28.7-64-64L0 64C0 28.7 28.7 0 64 0L229.5 0c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3L384 304l-48 0 0-144-80 0c-17.7 0-32-14.3-32-32l0-80L64 48c-8.8 0-16 7.2-16 16l0 384c0 8.8 7.2 16 16 16zM176 352l32 0c30.9 0 56 25.1 56 56s-25.1 56-56 56l-16 0 0 32c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-48 0-80c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24l-16 0 0 48 16 0zm96-80l32 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-32 0c-8.8 0-16-7.2-16-16l0-128c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16l0-64c0-8.8-7.2-16-16-16l-16 0 0 96 16 0zm80-112c0-8.8 7.2-16 16-16l48 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 32 32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 48c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-64 0-64z" />
                                            </svg>

                                            <span>Cetak Laporan</span>
                                        </button>
                                        <button
                                            x-data
                                            x-on:click.prevent="$dispatch('open-modal', 'tambah-user')"
                                            class="flex items-center px-4 py-2 bg-green-100 hover:bg-green-600 rounded text-sm text-green-700 hover:text-white transition-colors duration-300">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            <span>Tambah Data</span>
                                        </button>
                                        <input type="text" id="searchInput" placeholder="Search..." class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                                    </div>

                                </div>

                                <div class="overflow-x-auto rounded-lg shadow">
                                    <table id="userTable" class="min-w-full bg-white text-sm text-left text-gray-700">
                                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                                            <tr>
                                                <th class="px-6 py-3 text-center">No</th>
                                                <th class="px-6 py-3 text-center">Users</th>
                                                <th class="px-6 py-3 text-center">File</th>
                                                <th class="px-6 py-3 text-center">Tanggal Upload</th>
                                                <th class="px-6 py-3 text-center">Tanggal Edit</th>
                                                <th class="px-6 py-3 text-center">Tools</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody" class="divide-y divide-gray-200">
                                            @foreach($data as $d)
                                            <tr>
                                                <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                                <td class="px-6 py-4 text-center">{{ $d->users }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    @if($d->file)
                                                    <div class="flex items-center justify-center space-x-2">
                                                        <!-- Link Preview -->
                                                        <a href="{{ asset('storage/' . $d->file) }}" target="_blank"
                                                            class="text-indigo-600 hover:underline">
                                                            Preview
                                                        </a>

                                                        <!-- Tombol Download -->
                                                        <a href="{{ asset('storage/' . $d->file) }}" download
                                                            class="text-blue-500 hover:text-blue-700 transition-colors p-1 rounded"
                                                            title="Download File">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 4v12" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    @else
                                                    <span class="text-gray-400">Tidak ada file</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ $d->created_at }}</td>
                                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ $d->updated_at }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    <div class="flex justify-center items-center space-x-4">
                                                        <!-- Edit Button -->
                                                        <a href="{{route('Bukti.edit', $d->id)}}" class="text-blue-500 hover:text-white transition-colors duration-300 p-1 rounded hover:bg-blue-500">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                            </svg>
                                                        </a>
                                                        <!-- Tombol untuk buka modal konfirmasi -->
                                                        <button
                                                            x-data
                                                            @click.prevent="$dispatch('open-modal', 'confirm-delete-{{ $d->id }}')"
                                                            type="button"
                                                            class="text-red-500 hover:text-white transition-colors duration-300 p-1 rounded hover:bg-red-500">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <x-modal name="{{ $d->id ? 'confirm-delete-' . $d->id : null }}" focusable>
                                                <div class="p-8 mx-auto rounded-lg shadow-lg">
                                                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Konfirmasi Hapus</h2>
                                                    <p class="text-gray-700">
                                                        Apakah kamu yakin ingin menghapus data yang di upload <strong class="font-semibold">{{ $d->users }}</strong>?<br>
                                                        Tindakan ini <span class="text-red-600 font-semibold">tidak dapat dibatalkan</span>.
                                                    </p>

                                                    <div class="mt-8 flex justify-end space-x-4">
                                                        <button
                                                            x-on:click="$dispatch('close')"
                                                            type="button"
                                                            class="px-5 py-2 rounded-md bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 transition focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                                            Batal
                                                        </button>

                                                        <form action="{{ route('Bukti.destroy', $d->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                                type="submit"
                                                                class="px-5 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white font-semibold transition focus:outline-none focus:ring-2 focus:ring-red-500">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </x-modal>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination controls -->
                                <div class="mt-4 flex justify-end items-center space-x-2" id="pagination"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <x-modal name="tambah-user" focusable>
        <form method="POST" action="{{ route('Bukti.store') }}" class="p-6" enctype="multipart/form-data">
            @csrf
            <h2 class="text-lg font-medium text-black">Tambah Karyawan Baru</h2>

            <input type="hidden" name="users" value="{{Auth::user()->email}}">
            <!-- Nama -->
            <div class="mt-4">
                <label for="file" class="block text-sm font-medium text-gray-700 mb-1">
                    Upload Gambar atau PDF
                </label>
                <input
                    type="file"
                    id="file"
                    name="file"
                    accept="image/*,.pdf"
                    class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                    required
                    onchange="previewFile(event)">

                @error('file')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Preview Container -->
                <div id="file-preview" class="mt-4 hidden">
                    <p class="text-sm text-gray-500 mb-2">Preview:</p>

                    <!-- Preview Image -->
                    <img id="preview-img" src="#" alt="Preview" class="max-w-xs rounded shadow border hidden">

                    <!-- Preview PDF -->
                    <iframe id="preview-pdf" class="w-full h-64 border rounded shadow hidden" frameborder="0"></iframe>
                </div>
            </div>


            <!-- Aksi -->
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button class="ml-3">Simpan</x-primary-button>
            </div>
        </form>
    </x-modal>
    <x-modal name="cetak-user" focusable>
        <form method="GET" action="{{route('cetak.bukti')}}" class="p-6">
            <h2 class="text-lg font-medium text-black">Pilih Periode Laporan</h2>

            <div class="mt-4">
                <x-input-label for="periode" value="Periode" />
                <select id="periode" name="periode"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    required>
                    <option value="">-- Pilih Periode --</option>
                    <option value="bulan">Bulan Ini</option>
                    <option value="triwulan">Triwulan</option>
                    <option value="tahun">Tahun Ini</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('periode')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button class="ml-3">Cetak</x-primary-button>
            </div>
        </form>
    </x-modal>
    <script>
        const rowsPerPage = 5;
        let currentPage = 1;

        const table = document.getElementById('userTable');
        const tbody = document.getElementById('tableBody');
        const searchInput = document.getElementById('searchInput');
        const pagination = document.getElementById('pagination');

        const allRows = Array.from(tbody.querySelectorAll('tr'));

        function renderTable(rows) {
            tbody.innerHTML = '';
            rows.forEach(row => tbody.appendChild(row));
        }

        function paginate(rows) {
            const totalPages = Math.ceil(rows.length / rowsPerPage);
            const start = (currentPage - 1) * rowsPerPage;
            const paginatedRows = rows.slice(start, start + rowsPerPage);

            renderTable(paginatedRows);
            renderPagination(totalPages);
        }

        function renderPagination(totalPages) {
            pagination.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.className = `px-3 py-1 border rounded ${i === currentPage ? 'bg-blue-500 text-white' : 'bg-white text-blue-500'}`;
                btn.addEventListener('click', () => {
                    currentPage = i;
                    paginate(filterRows());
                });
                pagination.appendChild(btn);
            }
        }

        function filterRows() {
            const searchTerm = searchInput.value.toLowerCase();
            return allRows.filter(row => {
                return row.textContent.toLowerCase().includes(searchTerm);
            });
        }

        searchInput.addEventListener('input', () => {
            currentPage = 1;
            paginate(filterRows());
        });

        // Initial render
        paginate(allRows);
    </script>
    <script>
        function previewFile(event) {
            const input = event.target;
            const file = input.files[0];

            const previewContainer = document.getElementById('file-preview');
            const previewImage = document.getElementById('preview-img');
            const previewPDF = document.getElementById('preview-pdf');

            if (!file) return;

            const fileType = file.type;
            const reader = new FileReader();

            previewImage.classList.add('hidden');
            previewPDF.classList.add('hidden');

            reader.onload = function(e) {
                previewContainer.classList.remove('hidden');

                if (fileType.startsWith('image/')) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                } else if (fileType === 'application/pdf') {
                    previewPDF.src = e.target.result;
                    previewPDF.classList.remove('hidden');
                } else {
                    previewContainer.classList.add('hidden');
                }
            };

            reader.readAsDataURL(file);
        }
    </script>

</x-app-layout>