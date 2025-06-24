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
                                    {{ __("Management Penggajian") }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <!-- Your main content here -->
                            <div class="w-full mx-auto p-6 bg-white rounded shadow ">
                                <h2 class="text-2xl font-semibold mb-6">Edit Penggajian</h2>

                                <form method="POST" action="{{ route('Penggajian.update', $penggajian->id) }}" class="p-6">
                                    @csrf
                                    @method('PUT')

                                    <h2 class="text-lg font-medium text-black mb-4">Edit Data Penggajian</h2>

                                    <!-- Karyawan -->
                                    <div class="mt-4">
                                        <x-input-label for="karyawan_id" value="Karyawan" />
                                        <select id="karyawan_id" name="karyawan_id"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            required>
                                            <option value="">-- Pilih Karyawan --</option>
                                            @foreach($karyawan as $k)
                                            <option value="{{ $k->id }}"
                                                {{ old('karyawan_id', $penggajian->karyawan_id) == $k->id ? 'selected' : '' }}>
                                                {{ $k->identitas }} | {{ $k->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('karyawan_id')" />
                                    </div>

                                    <!-- Kegiatan -->
                                    <div class="mt-4">
                                        <x-input-label for="kegiatan" value="Kegiatan" />
                                        <select id="kegiatan" name="kegiatan"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            required>
                                            <option value="">-- Pilih Kegiatan --</option>
                                            @foreach (['eksternal', 'movereg', 'handling'] as $item)
                                            <option value="{{ $item }}"
                                                {{ old('kegiatan', $penggajian->kegiatan) == $item ? 'selected' : '' }}>
                                                {{ ucfirst($item) }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('kegiatan')" />
                                    </div>

                                    <!-- Tanggal -->
                                    <div class="mt-4">
                                        <x-input-label for="tanggal" value="Tanggal" />
                                        <x-text-input id="tanggal" name="tanggal" type="date"
                                            value="{{ old('tanggal', $penggajian->tanggal) }}"
                                            class="mt-1 block w-full" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
                                    </div>

                                    <!-- Upah Diajukan -->
                                    <div class="mt-4">
                                        <x-input-label for="diajukan" value="Upah Diajukan" />
                                        <x-text-input id="diajukan" name="diajukan" type="text"
                                            value="{{ old('diajukan', $penggajian->diajukan) }}"
                                            class="mt-1 block w-full" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('diajukan')" />
                                    </div>

                                    <!-- Tombol Aksi -->
                                    <div class="mt-6 flex justify-end">
                                        <a href="{{ route('Penggajian.index') }}"
                                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-gray-800">
                                            Batal
                                        </a>
                                        <x-primary-button class="ml-3">Simpan Perubahan</x-primary-button>
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