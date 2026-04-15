{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.dashboard.index')

@section('title', 'Pengaturan Profile - LaporinAja')

@section('dashboard-content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Flash Messages -->
    @if (session('status'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm" 
             role="alert" data-auto-dismiss>
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-green-500"></i>
                <p class="text-sm font-medium">{{ session('status') }}</p>
            </div>
        </div>
    @endif
    
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm" 
             role="alert">
            <div class="flex items-start gap-3">
                <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                <div>
                    <p class="text-sm font-medium mb-1">Terjadi kesalahan:</p>
                    <ul class="text-sm list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-xl ring-4 ring-blue-100">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900">Pengaturan Profile</h1>
                <p class="text-gray-600 mt-1">Kelola informasi akun dan preferensi Anda</p>
            </div>
            <div class="text-sm text-gray-400">
                <i class="fas fa-id-card"></i> ID: {{ Auth::user()->id }}
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
        <div class="border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-circle text-blue-500 text-lg"></i>
                </div>
                <h2 class="text-lg font-semibold text-gray-900">Informasi Profile</h2>
            </div>
        </div>
        <div class="p-6">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <!-- Password Update -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
        <div class="border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-lock text-amber-500 text-lg"></i>
                </div>
                <h2 class="text-lg font-semibold text-gray-900">Ubah Password</h2>
            </div>
        </div>
        <div class="p-6">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- Account Deletion -->
    <div class="bg-white rounded-xl shadow-sm border border-red-100 overflow-hidden hover:shadow-md transition-shadow">
        <div class="border-b border-red-100 bg-gradient-to-r from-red-50 to-white px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                </div>
                <h2 class="text-lg font-semibold text-red-900">Hapus Akun</h2>
            </div>
        </div>
        <div class="p-6">
            <p class="text-sm text-red-600 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle"></i>
                Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen.
            </p>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection