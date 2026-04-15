{{-- resources/views/settings/index.blade.php --}}
@extends('layouts.dashboard.index')

@section('title', 'Pengaturan - LaporinAja')

@section('dashboard-content')
<div class="py-8">
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Success Message -->
        @if(session('status'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg" data-auto-dismiss>
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    {{ session('status') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg">
                <div class="flex items-start gap-2">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                    <div>
                        <p class="font-medium">Terjadi kesalahan:</p>
                        <ul class="text-sm list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-amber-500 to-orange-600 flex items-center justify-center text-white font-bold text-lg">
                    <i class="fas fa-cog"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Pengaturan</h1>
                    <p class="text-gray-600">Sesuaikan preferensi dan konfigurasi aplikasi</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('settings.update') }}">
            @csrf
            @method('PUT')

            <!-- Notification Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <i class="fas fa-bell text-blue-500 text-xl"></i>
                    <h2 class="text-xl font-semibold text-gray-900">Notifikasi</h2>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <h3 class="font-medium text-gray-900">Email Notifikasi</h3>
                            <p class="text-sm text-gray-600">Terima notifikasi melalui email</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="notifications[email]" value="1"
                                   {{ (old('notifications.email', $user->settings['notifications']['email'] ?? false)) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <h3 class="font-medium text-gray-900">Push Notifikasi</h3>
                            <p class="text-sm text-gray-600">Terima notifikasi push di browser</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="notifications[push]" value="1"
                                   {{ (old('notifications.push', $user->settings['notifications']['push'] ?? false)) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <h3 class="font-medium text-gray-900">Notifikasi Laporan</h3>
                            <p class="text-sm text-gray-600">Dapatkan update tentang laporan Anda</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="notifications[reports]" value="1"
                                   {{ (old('notifications.reports', $user->settings['notifications']['reports'] ?? true)) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Appearance Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <i class="fas fa-palette text-purple-500 text-xl"></i>
                    <h2 class="text-xl font-semibold text-gray-900">Tampilan</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tema</label>
                        <select name="theme" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="light" {{ old('theme', $user->settings['theme'] ?? 'light') == 'light' ? 'selected' : '' }}>Terang</option>
                            <option value="dark" {{ old('theme', $user->settings['theme'] ?? 'light') == 'dark' ? 'selected' : '' }}>Gelap</option>
                            <option value="auto" {{ old('theme', $user->settings['theme'] ?? 'light') == 'auto' ? 'selected' : '' }}>Otomatis</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bahasa</label>
                        <select name="language" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="id" {{ old('language', $user->settings['language'] ?? 'id') == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                            <option value="en" {{ old('language', $user->settings['language'] ?? 'id') == 'en' ? 'selected' : '' }}>English</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Privacy Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <i class="fas fa-shield-alt text-green-500 text-xl"></i>
                    <h2 class="text-xl font-semibold text-gray-900">Privasi</h2>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <h3 class="font-medium text-gray-900">Profile Publik</h3>
                            <p class="text-sm text-gray-600">Izinkan orang lain melihat profile Anda</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="privacy[public_profile]" value="1"
                                   {{ (old('privacy.public_profile', $user->settings['privacy']['public_profile'] ?? true)) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <h3 class="font-medium text-gray-900">Data Analytics</h3>
                            <p class="text-sm text-gray-600">Bantu kami meningkatkan aplikasi dengan data penggunaan anonim</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="privacy[analytics]" value="1"
                                   {{ (old('privacy.analytics', $user->settings['privacy']['analytics'] ?? false)) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition duration-200 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection