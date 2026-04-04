@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-[#FFFDF5]">
    {{-- Sidebar --}}
    <aside class="w-64 bg-white shadow-md min-h-screen">
        <div class="p-5">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-blue-600">LaporinAja</h2>
                <p class="text-sm text-gray-500">Warga Panel</p>
            </div>
            
            <nav class="space-y-2">
                <a href="{{ route('laporan.create') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition group">
                    <i class="fas fa-file-alt w-5"></i>
                    <span>Laporan Masalah</span>
                </a>
                
                <a href="{{ route('laporan.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition group">
                    <i class="fas fa-eye w-5"></i>
                    <span>Pantau Aduan</span>
                </a>
                
                <a href="{{ route('relawan.create') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition group">
                    <i class="fas fa-hands-helping w-5"></i>
                    <span>Gabung Relawan</span>
                </a>
            </nav>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 p-6">
        @yield('dashboard-content')
    </main>
</div>
@endsection