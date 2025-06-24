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
                                    {{ __("Users Management") }}
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
                                        <h2 class="text-xl font-semibold">User Table</h2>
                                    </div>
                                    <div class="flex gap-4">
                                        <!-- Button with icon (Edit) -->
                                        <!-- Tombol Tambah Data -->
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
                                                <th class="px-6 py-3 text-center">Name</th>
                                                <th class="px-6 py-3 text-center">Email</th>
                                                <th class="px-6 py-3 text-center">Role</th>
                                                <th class="px-6 py-3 text-center">Tools</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody" class="divide-y divide-gray-200">
                                            @foreach($data as $d)
                                            <tr>
                                                <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                                <td class="px-6 py-4 text-center">{{ $d->name }}</td>
                                                <td class="px-6 py-4 text-center">{{ $d->email }}</td>
                                                <td class="px-6 py-4 text-center">{{ $d->role }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    <div class="flex justify-center items-center space-x-4">
                                                        <!-- Edit Button -->
                                                        <a href="{{route('Users.edit', $d->id)}}" class="text-blue-500 hover:text-white transition-colors duration-300 p-1 rounded hover:bg-blue-500">
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
                                            <x-modal name="confirm-delete-{{ $d->id }}" focusable>
                                                <div class="p-8 mx-auto rounded-lg shadow-lg">
                                                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Konfirmasi Hapus</h2>
                                                    <p class="text-gray-700">
                                                        Apakah kamu yakin ingin menghapus user <strong class="font-semibold">{{ $d->name }}</strong>?<br>
                                                        Tindakan ini <span class="text-red-600 font-semibold">tidak dapat dibatalkan</span>.
                                                    </p>

                                                    <div class="mt-8 flex justify-end space-x-4">
                                                        <button
                                                            x-on:click="$dispatch('close')"
                                                            type="button"
                                                            class="px-5 py-2 rounded-md bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 transition focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                                            Batal
                                                        </button>

                                                        <form action="{{ route('Users.destroy', $d->id) }}" method="POST" class="inline">
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
        <form method="POST" action="{{ route('Users.store') }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-black">Tambah User Baru</h2>

            <!-- Nama -->
            <div class="mt-4">
                <x-input-label for="name" value="Name" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('password')" />
            </div>

            <!-- Role -->
            <div class="mt-4">
                <x-input-label for="role" value="Role" />
                <select id="role" name="role"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    required>
                    <option value="">-- Pilih Role --</option>
                    <option value="sdm">SDM</option>
                    <option value="keuangan">Keuangan</option>
                    <option value="kepala cabang">Kepala Cabang</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('role')" />
            </div>

            <!-- Aksi -->
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button class="ml-3">Simpan</x-primary-button>
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

</x-app-layout>