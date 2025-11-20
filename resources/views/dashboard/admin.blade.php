@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Welcome Header with Greeting -->
    <div class="mb-6 md:mb-8 mt-3 px-4 md:px-0">
        <div class="bg-gradient-to-r from-blue-600 to-blue-600 rounded-xl shadow-lg p-6 md:p-8 text-white">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex-1">
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2">
                        Selamat Datang, Admin! 👋
                    </h1>
                    <p class="text-sm md:text-base lg:text-lg text-blue-100">
                        Berikut adalah ringkasan sistem Anda hari ini, {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8 px-4 md:px-0">
        <!-- Total User -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-500 shadow-lg rounded-xl p-6 md:p-7 text-white transform hover:scale-105 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 md:w-6 md:h-6 opacity-90" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        <h3 class="text-sm md:text-base font-semibold opacity-90">Total User</h3>
                    </div>
                    <p class="text-4xl md:text-5xl font-bold mb-2">{{ $totalUser ?? 0 }}</p>
                    <p class="text-xs md:text-sm opacity-75">Semua pengguna terdaftar</p>
                </div>
                <div class="hidden sm:flex bg-blue-600 bg-opacity-20 rounded-full p-4 md:p-5 items-center justify-center">
                    <svg class="w-12 h-12 md:w-14 md:h-14" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Active User -->
        <div class="bg-teal-600 shadow-lg rounded-xl p-6 md:p-7 text-white transform hover:scale-105 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 md:w-6 md:h-6 opacity-90" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <h3 class="text-sm md:text-base font-semibold opacity-90">Active User</h3>
                    </div>
                    <p class="text-4xl md:text-5xl font-bold mb-2">{{ $activeUser ?? 0 }}</p>
                    <p class="text-xs md:text-sm opacity-75">User sudah verifikasi</p>
                </div>
                <div class="hidden sm:flex bg-teal-600 bg-opacity-20 rounded-full p-4 md:p-5 items-center justify-center">
                    <svg class="w-12 h-12 md:w-14 md:h-14" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- New User Today -->
        <div class="bg-teal-600 shadow-lg rounded-xl p-6 md:p-7 text-white transform hover:scale-105 hover:shadow-2xl transition-all duration-300 sm:col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 md:w-6 md:h-6 opacity-90" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                        </svg>
                        <h3 class="text-sm md:text-base font-semibold opacity-90">New User (Hari Ini)</h3>
                    </div>
                    <p class="text-4xl md:text-5xl font-bold mb-2">{{ $newUser ?? 0 }}</p>
                    <p class="text-xs md:text-sm opacity-75">Pengguna baru hari ini</p>
                </div>
                <div class="hidden sm:flex bg-teal-600 bg-opacity-20 rounded-2xl p-4 md:p-5 items-center justify-center">
                    <svg class="w-12 h-12 md:w-14 md:h-14" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid: Calendar & Recent Users -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8 px-4 md:px-0">
        <!-- Calendar -->
        <div class="lg:col-span-1 order-2 lg:order-1">
            <div class="bg-white rounded-xl shadow-lg p-5 md:p-6 border border-gray-100">
                <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-5 flex items-center">
                    <svg class="w-5 h-5 md:w-6 md:h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-base md:text-xl">Kalender</span>
                </h3>
                
                <!-- Calendar Header -->
                <div class="flex justify-between items-center mb-4">
                    <button onclick="previousMonth()" class="bg-blue-600 hover:bg-blue-700 text-white px-3 md:px-4 py-2 rounded-lg transition-all duration-200 font-medium shadow-sm hover:shadow-md">
                        ←
                    </button>
                    <h4 id="monthYear" class="text-base md:text-lg font-bold text-gray-800"></h4>
                    <button onclick="nextMonth()" class="bg-blue-600 hover:bg-blue-700 text-white px-3 md:px-4 py-2 rounded-lg transition-all duration-200 font-medium shadow-sm hover:shadow-md">
                        →
                    </button>
                </div>

                <!-- Weekdays -->
                <div class="grid grid-cols-7 gap-1 mb-2">
                    <div class="text-center text-xs font-bold text-gray-600 py-2">Min</div>
                    <div class="text-center text-xs font-bold text-gray-600 py-2">Sen</div>
                    <div class="text-center text-xs font-bold text-gray-600 py-2">Sel</div>
                    <div class="text-center text-xs font-bold text-gray-600 py-2">Rab</div>
                    <div class="text-center text-xs font-bold text-gray-600 py-2">Kam</div>
                    <div class="text-center text-xs font-bold text-gray-600 py-2">Jum</div>
                    <div class="text-center text-xs font-bold text-gray-600 py-2">Sab</div>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-1 mb-4" id="calendarGrid"></div>

                <!-- Selected Date Display -->
                <div class="p-4 bg-blue-100 rounded-lg border border-blue-200">
                    <p class="text-xs text-gray-600 mb-1 font-medium">Tanggal Terpilih:</p>
                    <p class="text-sm md:text-base font-bold text-blue-700" id="selectedDateDisplay">{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="lg:col-span-2 order-1 lg:order-2">
            <div class="bg-white rounded-xl shadow-lg p-5 md:p-6 border border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 md:mb-6 gap-3 sm:gap-0">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 md:w-6 md:h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        <span class="text-base md:text-xl">User Terbaru</span>
                    </h3>
                    <a href="{{ route('admin.users.index') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 md:px-5 py-2 md:py-2.5 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 flex items-center gap-2 w-full sm:w-auto justify-center shadow-sm hover:shadow-md">
                        Lihat Selengkapnya
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>

                <div class="space-y-3 md:space-y-4">
                    @forelse($users as $user)
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 md:p-5 bg-gradient-to-r from-gray-50 to-blue-50 hover:from-blue-50 hover:to-blue-100 rounded-xl transition-all duration-200 gap-3 sm:gap-4 border border-gray-200 hover:border-blue-300 hover:shadow-md">
                            <div class="flex items-center space-x-3 md:space-x-4 flex-1 min-w-0">
                                <img src="{{ $user->foto_profile_url }}" 
                                     class="w-12 h-12 md:w-14 md:h-14 rounded-full border-3 border-blue-300 shadow-sm flex-shrink-0 object-cover" 
                                     alt="{{ $user->name }}">
                                <div class="min-w-0 flex-1">
                                    <h4 class="font-bold text-gray-800 text-sm md:text-base truncate">{{ $user->nama_lengkap }}</h4>
                                    <p class="text-xs md:text-sm text-gray-600 truncate mt-0.5">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="flex sm:flex-col items-center sm:items-end gap-2 sm:gap-1.5 w-full sm:w-auto justify-between sm:justify-start">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-700 border border-teal-300">
                                    ✓ Aktif
                                </span>
                                <p class="text-xs text-gray-500 font-medium whitespace-nowrap">{{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 md:w-20 md:h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="text-base md:text-lg text-gray-500 font-medium">Belum ada user terdaftar</p>
                            <p class="text-sm text-gray-400 mt-1">User baru akan muncul di sini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
        
    <script>
       let currentDate = new Date();
let selectedDate = new Date();

const monthNames = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    document.getElementById('monthYear').textContent = 
        `${monthNames[month]} ${year}`;
    
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    
    const calendarGrid = document.getElementById('calendarGrid');
    calendarGrid.innerHTML = '';
    
    // Previous month days
    for (let i = firstDay - 1; i >= 0; i--) {
        const day = daysInPrevMonth - i;
        const cell = createDayCell(day, true);
        calendarGrid.appendChild(cell);
    }
    
    // Current month days
    const today = new Date();
    for (let day = 1; day <= daysInMonth; day++) {
        const cell = createDayCell(day, false);
        
        // Highlight today dengan warna abu-abu
        if (year === today.getFullYear() && 
            month === today.getMonth() && 
            day === today.getDate()) {
            cell.classList.add('bg-gray-300', 'text-gray-700', 'font-bold', 'ring-2', 'ring-gray-400', 'shadow-md');
        }
        
        // Highlight selected date dengan warna abu-abu
        if (selectedDate && 
            year === selectedDate.getFullYear() &&
            month === selectedDate.getMonth() &&
            day === selectedDate.getDate() &&
            !(year === today.getFullYear() && month === today.getMonth() && day === today.getDate())) {
            cell.classList.add('bg-gray-300', 'text-gray-700', 'font-bold', 'shadow-md');
        }
        
        cell.classList.add('hover:bg-gray-200', 'hover:scale-110', 'cursor-pointer', 'transition-all', 'duration-200');
        cell.addEventListener('click', () => selectDate(day));
        
        calendarGrid.appendChild(cell);
    }
    
    // Next month days
    const totalCells = calendarGrid.children.length;
    const remainingCells = 42 - totalCells;
    for (let day = 1; day <= remainingCells; day++) {
        const cell = createDayCell(day, true);
        calendarGrid.appendChild(cell);
    }
}

        function createDayCell(day, isOtherMonth) {
            const cell = document.createElement('div');
            cell.className = 'aspect-square flex items-center justify-center text-xs md:text-sm rounded-lg font-medium';
            cell.textContent = day;
            
            if (isOtherMonth) {
                cell.classList.add('text-gray-300', 'bg-gray-50');
            } else {
                cell.classList.add('text-gray-700', 'bg-white');
            }
            
            return cell;
        }

        function selectDate(day) {
            selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
            updateSelectedDateDisplay();
            renderCalendar();
        }

        function updateSelectedDateDisplay() {
            if (selectedDate) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const dateString = selectedDate.toLocaleDateString('id-ID', options);
                document.getElementById('selectedDateDisplay').textContent = dateString;
            }
        }

        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        }

        // Initialize calendar on page load
        document.addEventListener('DOMContentLoaded', function() {
            renderCalendar();
            updateSelectedDateDisplay();
        });
    </script>
@endsection