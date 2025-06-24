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
                    <!-- Main Content -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <!-- Your main content here -->
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 ">Welcome to Dashboard</h2>
                            <p class="text-gray-600">Selamat Bekerja di PT.Bulog</p>
                        </div>
                    </div>
                    <div class="w-full flex justify-center mt-6">
                        <img src="{{asset('images/logo.jpg')}}" class="w-60 rounded-full" alt="">
                    </div>
                    <div class="flex w-full mt-4">
                        <div class="bg-white p-6 rounded-lg w-full shadow-md">
                            <h2 class="text-lg font-semibold mb-4">Grafik Karyawan Aktif per Bulan</h2>
                            <canvas id="karyawanChart" class="w-full h-64"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md mt-8">
                        <h2 class="text-lg font-semibold mb-4">Grafik Pajak (PPH21) Dibayarkan per Bulan</h2>
                        <canvas id="pajakChart" class="w-full h-64"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Script Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('karyawanChart').getContext('2d');
        const karyawanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Karyawan Aktif',
                    data: @json($jumlahAktif),
                    backgroundColor: 'rgba(99, 102, 241, 0.7)', // Indigo
                    borderRadius: 8,
                    hoverBackgroundColor: 'rgba(79, 70, 229, 0.9)',
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#fff',
                        bodyColor: '#fff'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: '#374151',
                            font: {
                                size: 14
                            }
                        },
                        grid: {
                            color: '#E5E7EB'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#374151',
                            font: {
                                size: 14
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
    <script>
        const ctxPajak = document.getElementById('pajakChart').getContext('2d');
        const pajakChart = new Chart(ctxPajak, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Total PPH21 (Rp)',
                    data: @json($jumlahPajak),
                    backgroundColor: 'rgba(251, 191, 36, 0.7)', // amber
                    hoverBackgroundColor: 'rgba(202, 138, 4, 0.9)',
                    borderRadius: 8,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        },
                        backgroundColor: '#1F2937',
                        titleColor: '#fff',
                        bodyColor: '#fff'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            },
                            color: '#374151'
                        },
                        grid: {
                            color: '#E5E7EB'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#374151'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>