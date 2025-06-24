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
                                    {{ __("Management User") }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <!-- Your main content here -->
                            <div class="w-full mx-auto p-6 bg-white rounded shadow ">
                                <h2 class="text-2xl font-semibold mb-6">Edit User</h2>

                                <form method="POST" action="{{ route('Users.update', $user->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <!-- Name -->
                                    <div class="mb-4">
                                        <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                                        <input
                                            id="name"
                                            name="name"
                                            type="text"
                                            value="{{ old('name', $user->name) }}"
                                            required
                                            autofocus
                                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                                        @error('name')
                                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-4">
                                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                                        <input
                                            id="email"
                                            name="email"
                                            type="email"
                                            value="{{ old('email', $user->email) }}"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                                        @error('email')
                                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-4">
                                        <label for="password" class="block text-gray-700 font-medium mb-2">
                                            Password (biarkan kosong jika tidak ingin ganti)
                                        </label>
                                        <input
                                            id="password"
                                            name="password"
                                            type="password"
                                            autocomplete="new-password"
                                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                                        @error('password')
                                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Role -->
                                    <div class="mb-6">
                                        <label for="role" class="block text-gray-700 font-medium mb-2">Role</label>
                                        <select
                                            id="role"
                                            name="role"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                            <option value="">-- Pilih Role --</option>
                                            <option value="sdm" {{ old('role', $user->role) === 'sdm' ? 'selected' : '' }}>SDM</option>
                                            <option value="keuangan" {{ old('role', $user->role) === 'keuangan' ? 'selected' : '' }}>Keuangan</option>
                                            <option value="kepala cabang" {{ old('role', $user->role) === 'kepala cabang' ? 'selected' : '' }}>Kepala Cabang</option>
                                        </select>
                                        @error('role')
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