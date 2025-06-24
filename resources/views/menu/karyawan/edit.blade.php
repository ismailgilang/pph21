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

                                <form method="POST" action="{{ route('Karyawan.update', $user->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <!-- Name -->
                                    <div class="mb-4">
                                        <label for="identitas" class="block text-gray-700 font-medium mb-2">Identitas</label>
                                        <input
                                            id="identitas"
                                            name="identitas"
                                            type="text"
                                            value="{{ old('identitas', $user->identitas) }}"
                                            required
                                            autofocus
                                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                                        @error('identitas')
                                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-4">
                                        <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                                        <input
                                            id="name"
                                            name="name"
                                            type="text"
                                            value="{{ old('name', $user->name) }}"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                                        @error('name')
                                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-4">
                                        <label for="hp" class="block text-gray-700 font-medium mb-2">
                                            No HP
                                        </label>
                                        <input
                                            id="hp"
                                            name="hp"
                                            type="text"
                                            value="{{ old('hp', $user->hp) }}"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                                        @error('hp')
                                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Role -->
                                    <div class="mb-6">
                                        <label for="jk" class="block text-gray-700 font-medium mb-2">Role</label>
                                        <select
                                            id="jk"
                                            name="jk"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                            <option value="">-- Pilih Role --</option>
                                            <option value="Laki-laki" {{ old('jk', $user->jk) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jk', $user->jk) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jk')
                                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="alamat" class="block text-gray-700 font-medium mb-2">
                                            Alamat
                                        </label>
                                        <input
                                            id="alamat"
                                            name="alamat"
                                            type="text"
                                            value="{{ old('alamat', $user->alamat) }}"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                                        @error('alamat')
                                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('Users.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-gray-800">Batal</a>
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
</x-app-layout>