@extends('layouts.admin')

@section('content')

<div class="min-h-screen bg-gray-50 p-3 sm:p-4 md:p-6">
    <!-- Header - Responsive -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4 sm:mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">DASHBOARD OWNER</h1>
        <select id="periodeFilter" class="w-full sm:w-auto bg-white text-gray-700 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option value="bulan_ini" {{ ($periode ?? 'bulan_ini') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
            <option value="tahun_ini" {{ ($periode ?? '') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
            <option value="all" {{ ($periode ?? '') == 'all' ? 'selected' : '' }}>All Time</option>
        </select>
    </div>

    <!-- Stats Cards - Responsive Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6 mb-4 sm:mb-6">
        <div class="bg-teal-500 rounded-xl p-4 sm:p-6 shadow-md relative overflow-hidden">
            <div class="absolute top-2 right-2 sm:top-4 sm:right-4 opacity-20">
                <svg class="w-8 h-8 sm:w-12 sm:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="relative">
                <span class="text-white text-xs sm:text-sm font-medium block mb-2">Total Pendapatan</span>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-white" id="totalPendapatan">
                    Rp {{ number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') }}
                </h2>
            </div>
        </div>

        <div class="bg-teal-500 rounded-xl p-4 sm:p-6 shadow-md relative overflow-hidden">
            <div class="absolute top-2 right-2 sm:top-4 sm:right-4 opacity-20">
                <svg class="w-8 h-8 sm:w-12 sm:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <div class="relative">
                <span class="text-white text-xs sm:text-sm font-medium block mb-2">Total Pesanan</span>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-white" id="totalPesanan">
                    {{ $stats['total_pesanan'] ?? 0 }}
                </h2>
            </div>
        </div>

        <div class="bg-teal-500 rounded-xl p-4 sm:p-6 shadow-md relative overflow-hidden sm:col-span-2 lg:col-span-1">
            <div class="absolute top-2 right-2 sm:top-4 sm:right-4 opacity-20">
                <svg class="w-8 h-8 sm:w-12 sm:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <div class="relative">
                <span class="text-white text-xs sm:text-sm font-medium block mb-2">Pendapatan Bersih</span>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-white" id="pendapatanBersih">
                    Rp {{ number_format($stats['pendapatan_bersih'] ?? 0, 0, ',', '.') }}
                </h2>
            </div>
        </div>
    </div>

    <!-- Content Grid - Responsive Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6 mb-4 sm:mb-6">
        <!-- Paket Terpopuler -->
        <div class="bg-white rounded-xl p-4 sm:p-6 shadow-md border border-gray-200">
            <h3 class="text-lg sm:text-xl font-bold mb-3 sm:mb-4 text-gray-800" style="background: none;">Paket Terpopuler</h3>
            <div class="space-y-3 sm:space-y-4">
                @forelse($paket_populer ?? [] as $paket)
                <div class="space-y-2">
                    <div class="flex justify-between items-center text-xs sm:text-sm">
                        <span class="text-gray-700 font-medium truncate mr-2">{{ $paket['nama'] }}</span>
                        <span class="text-teal-600 font-semibold whitespace-nowrap">{{ $paket['total'] }} Pesanan</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 sm:h-2.5">
                        <div class="bg-teal-500 h-2 sm:h-2.5 rounded-full transition-all duration-300" 
                             style="width: {{ ($paket['total'] / ($max_pesanan ?? 1)) * 100 }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-gray-400 text-center py-4 text-sm" style="background: none;">Belum ada data paket</p>
                @endforelse
            </div>
        </div>

        <!-- Trend Pendapatan -->
        <div class="bg-white rounded-xl p-4 sm:p-6 shadow-md border border-gray-200 lg:col-span-2">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800" style="background: none;">Trend Pendapatan</h3>
                <div class="flex gap-1.5 sm:gap-2 w-full sm:w-auto">
                    <button onclick="changePeriod('bulan_ini')" id="btnBulanIni" class="flex-1 sm:flex-none px-2 sm:px-3 py-1.5 text-xs sm:text-sm bg-gray-200 text-gray-600 rounded-lg font-medium hover:bg-gray-300 transition">Bulan Ini</button>
                    <button onclick="changePeriod('tahun_ini')" id="btnTahunIni" class="flex-1 sm:flex-none px-2 sm:px-3 py-1.5 text-xs sm:text-sm bg-gray-200 text-gray-600 rounded-lg font-medium hover:bg-gray-300 transition">Tahun Ini</button>
                    <button onclick="changePeriod('all')" id="btnAllTime" class="flex-1 sm:flex-none px-2 sm:px-3 py-1.5 text-xs sm:text-sm bg-gray-200 text-gray-600 rounded-lg font-medium hover:bg-gray-300 transition">All Time</button>
                </div>
            </div>
            <div style="height: 200px; position: relative;" class="sm:h-64">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Layanan dan Performa - Responsive Grid -->
    <div class="mb-4 sm:mb-6">
        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Layanan dan Performa</h3>
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 md:gap-4">
            @forelse($layanan_performa ?? [] as $layanan)
            <div class="bg-teal-500 rounded-xl p-4 sm:p-6 text-center shadow-md">
                <div class="text-2xl sm:text-4xl mb-1 sm:mb-2">⭐</div>
                <h4 class="text-white font-bold text-sm sm:text-base lg:text-lg mb-1 truncate">{{ $layanan->nama }}</h4>
                <p class="text-white text-xs sm:text-sm">{{ $layanan->total_pesanan ?? 0 }} Pesanan</p>
            </div>
            @empty
            <div class="col-span-full text-center text-gray-400 py-4 text-sm">Belum ada data layanan</div>
            @endforelse
        </div>
    </div>

    <!-- Aktivitas Terbaru - Responsive -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 mb-4 sm:mb-6">
        <div class="p-4 sm:p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h3 class="text-lg sm:text-xl font-bold text-gray-800">Aktivitas Terbaru</h3>
            <button onclick="refreshData()" class="w-full sm:w-auto px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition font-medium text-sm">
                Refresh
            </button>
        </div>
        <div class="divide-y divide-gray-200" id="aktivitasList">
            @forelse($aktivitas ?? [] as $activity)
            <div class="p-3 sm:p-4 flex items-center justify-between hover:bg-gray-50 transition gap-2">
                <div class="flex items-center gap-2 sm:gap-4 flex-1 min-w-0">
                    @if($activity->user_foto_url)
                        <img src="{{ $activity->user_foto_url }}" 
                             alt="Profile" 
                             class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border-2 border-gray-200 flex-shrink-0">
                    @else
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 text-white flex items-center justify-center font-bold text-sm sm:text-lg flex-shrink-0">
                            {{ strtoupper(substr($activity->user_name ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <h4 class="font-semibold text-gray-800 text-sm sm:text-base truncate">{{ $activity->user_name ?? 'Unknown' }}</h4>
                        <p class="text-xs sm:text-sm text-gray-500 truncate">{{ $activity->paket_name ?? 'Paket tidak tersedia' }}</p>
                    </div>
                </div>
                <span class="text-xs sm:text-sm text-gray-400 whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</span>
            </div>
            @empty
            <div class="p-4 text-center text-gray-400 text-sm">Belum ada aktivitas</div>
            @endforelse
        </div>
    </div>

    <!-- Daftar User - Responsive Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200">
        <div class="p-4 sm:p-6 border-b border-gray-200">
            <h3 class="text-lg sm:text-xl font-bold text-gray-800">Daftar User</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="hidden sm:table-header-group bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Password</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users ?? [] as $user)
                    <!-- Mobile View -->
                    <tr class="sm:hidden">
                        <td colspan="5" class="px-4 py-3">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-start gap-3 flex-1 min-w-0">
                                    @if($user->foto_profile_url)
                                        <img src="{{ $user->foto_profile_url }}" 
                                             alt="Profile" 
                                             class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 flex-shrink-0">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 text-white flex items-center justify-center font-bold text-lg flex-shrink-0">
                                            {{ strtoupper(substr($user->display_name ?? 'U', 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <p class="font-medium text-gray-800 text-sm truncate">{{ $user->display_name ?? 'Unknown' }}</p>
                                        <p class="text-xs text-gray-600 truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <button onclick="deleteUser({{ $user->id }})" 
                                        class="p-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Desktop View -->
                    <tr class="hidden sm:table-row hover:bg-gray-50 transition">
                        <td class="px-4 py-3 sm:py-4">
                            @if($user->foto_profile_url)
                                <img src="{{ $user->foto_profile_url }}" 
                                     alt="Profile" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-gray-200">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 text-white flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($user->display_name ?? 'U', 0, 1)) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 sm:py-4 text-gray-800 font-medium text-sm">{{ $user->display_name ?? 'Unknown' }}</td>
                        <td class="px-4 py-3 sm:py-4 text-gray-600 text-sm">{{ $user->email }}</td>
                        <td class="px-4 py-3 sm:py-4 text-gray-400 text-sm hidden md:table-cell">••••••••••</td>
                        <td class="px-4 py-3 sm:py-4">
                            <button onclick="deleteUser({{ $user->id }})" 
                                    class="p-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 sm:px-6 py-4 text-center text-gray-400 text-sm">Belum ada user</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 sm:p-4 border-t border-gray-200 text-center">
            <a href="{{ route('admin.users.index') }}" class="inline-block w-full sm:w-auto px-4 sm:px-6 py-2 bg-teal-100 text-teal-700 rounded-lg hover:bg-teal-200 transition font-medium text-sm">
                Lihat Selengkapnya
            </a>
        </div>
    </div>
</div>

<style>
h3, h4, p, span { background: none !important; background-color: transparent !important; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const trendData = @json($trend ?? []);
const currentPeriode = '{{ $periode ?? "bulan_ini" }}';
const ctx = document.getElementById('trendChart');

if (ctx) {
    let chartLabels, chartData;
    
    if (!trendData || trendData.length === 0) {
        const today = new Date();
        const daysInMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();
        chartLabels = Array.from({length: Math.min(daysInMonth, 30)}, (_, i) => (i + 1) + '/' + (today.getMonth() + 1));
        chartData = Array(chartLabels.length).fill(0);
    } else {
        if (currentPeriode === 'bulan_ini') {
            chartLabels = trendData.map(item => {
                const date = new Date(item.tanggal + 'T00:00:00');
                const day = date.getDate();
                const month = date.getMonth() + 1;
                return day + '/' + month;
            });
            chartData = trendData.map(item => parseInt(item.pendapatan) || 0);
        } else if (currentPeriode === 'tahun_ini') {
            chartLabels = trendData.map(item => {
                if (item.bulan) return item.bulan;
                const date = new Date(item.tanggal);
                const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                return monthNames[date.getMonth()];
            });
            chartData = trendData.map(item => parseInt(item.pendapatan) || 0);
        } else if (currentPeriode === 'all') {
            chartLabels = trendData.map(item => {
                if (item.tahun) return item.tahun.toString();
                if (item.bulan) return item.bulan;
                const date = new Date(item.tanggal);
                const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                return monthNames[date.getMonth()] + ' ' + date.getFullYear();
            });
            chartData = trendData.map(item => parseInt(item.pendapatan) || 0);
        }
    }
    
    const chart = new Chart(ctx.getContext('2d'), {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Pendapatan',
                data: chartData,
                borderColor: '#14b8a6',
                backgroundColor: 'rgba(20, 184, 166, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#14b8a6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: window.innerWidth < 640 ? 2 : 4,
                pointHoverRadius: window.innerWidth < 640 ? 4 : 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                            else if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + 'k';
                            return 'Rp ' + value;
                        },
                        font: {
                            size: window.innerWidth < 640 ? 10 : 12
                        }
                    },
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: { 
                    grid: { display: false },
                    ticks: {
                        maxRotation: 45,
                        minRotation: window.innerWidth < 640 ? 45 : 0,
                        font: {
                            size: window.innerWidth < 640 ? 9 : 11
                        }
                    }
                }
            }
        }
    });
}

function changePeriod(period) {
    window.location.href = '{{ route("dashboard.owner") }}?periode=' + period;
}

document.getElementById('periodeFilter').addEventListener('change', function() {
    window.location.href = '{{ route("dashboard.owner") }}?periode=' + this.value;
});

function refreshData(e) {
    if (e) e.preventDefault();
    
    const periode = document.getElementById('periodeFilter').value;
    const btn = document.querySelector('button[onclick="refreshData()"]');
    
    if (!btn) return;
    
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.innerHTML = '<span class="animate-pulse">Loading...</span>';
    
    const url = '{{ route("owner.dashboard.refresh") }}' + '?periode=' + periode;
    
    fetch(url, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error('Network response was not ok: ' + res.status);
        return res.json();
    })
    .then(data => {
        if (data.success) {
            document.getElementById('totalPendapatan').textContent = 'Rp ' + data.stats.total_pendapatan;
            document.getElementById('totalPesanan').textContent = data.stats.total_pesanan;
            document.getElementById('pendapatanBersih').textContent = 'Rp ' + data.stats.pendapatan_bersih;
            
            const list = document.getElementById('aktivitasList');
            if (data.aktivitas && data.aktivitas.length > 0) {
                list.innerHTML = data.aktivitas.map(activity => `
                    <div class="p-3 sm:p-4 flex items-center justify-between hover:bg-gray-50 transition gap-2">
                        <div class="flex items-center gap-2 sm:gap-4 flex-1 min-w-0">
                            ${activity.user_foto ? 
                                `<img src="${activity.user_foto}" alt="Profile" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border-2 border-gray-200 flex-shrink-0">` :
                                `<div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 text-white flex items-center justify-center font-bold text-sm sm:text-lg flex-shrink-0">${activity.user_initial || 'U'}</div>`
                            }
                            <div class="min-w-0 flex-1">
                                <h4 class="font-semibold text-gray-800 text-sm sm:text-base truncate">${activity.user_name}</h4>
                                <p class="text-xs sm:text-sm text-gray-500 truncate">${activity.paket_nama}</p>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm text-gray-400 whitespace-nowrap">${activity.time}</span>
                    </div>
                `).join('');
            } else {
                list.innerHTML = '<div class="p-4 text-center text-gray-400 text-sm">Belum ada aktivitas</div>';
            }
            
            btn.classList.remove('bg-teal-500');
            btn.classList.add('bg-green-500');
            btn.textContent = '✓ Berhasil';
            
            setTimeout(() => {
                btn.classList.remove('bg-green-500');
                btn.classList.add('bg-teal-500');
                btn.textContent = originalText;
                btn.disabled = false;
            }, 1500);
        } else {
            throw new Error(data.message || 'Refresh failed');
        }
    })
    .catch(err => {
        console.error('Refresh error:', err);
        
        btn.classList.remove('bg-teal-500');
        btn.classList.add('bg-red-500');
        btn.textContent = '✗ Gagal';
        
        setTimeout(() => {
            btn.classList.remove('bg-red-500');
            btn.classList.add('bg-teal-500');
            btn.textContent = originalText;
            btn.disabled = false;
        }, 1500);
    });
}

function deleteUser(userId) {
    if(confirm('Yakin ingin menghapus user ini?')) {
        fetch('/owner/users/' + userId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                alert('User berhasil dihapus');
                location.reload();
            } else {
                alert(data.message || 'Gagal menghapus user');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat menghapus user');
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const currentPeriod = '{{ $periode ?? "bulan_ini" }}';
    
    document.querySelectorAll('#btnBulanIni, #btnTahunIni, #btnAllTime').forEach(btn => {
        btn.classList.remove('bg-teal-500', 'text-white');
        btn.classList.add('bg-gray-200', 'text-gray-600');
    });
    
    if (currentPeriod === 'bulan_ini') {
        const btn = document.getElementById('btnBulanIni');
        btn.classList.remove('bg-gray-200', 'text-gray-600');
        btn.classList.add('bg-teal-500', 'text-white');
    } else if (currentPeriod === 'tahun_ini') {
        const btn = document.getElementById('btnTahunIni');
        btn.classList.remove('bg-gray-200', 'text-gray-600');
        btn.classList.add('bg-teal-500', 'text-white');
    } else if (currentPeriod === 'all') {
        const btn = document.getElementById('btnAllTime');
        btn.classList.remove('bg-gray-200', 'text-gray-600');
        btn.classList.add('bg-teal-500', 'text-white');
    }
});
</script>
@endsection