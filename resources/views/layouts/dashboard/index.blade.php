@extends('layouts.dashboard.app')

@section('content')
<div class="flex min-h-screen bg-gray-100" x-data="{ sidebarOpen: false }">
    <!-- Include Sidebar Partial -->
    @include('partials.sidebar')
    
    <!-- Mobile overlay -->
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 md:hidden"></div>
    
    <!-- Main Content -->
    <main class="flex-1 min-w-0 transition-all duration-300" 
          :class="{
              'ml-[70px]': !sidebarOpen && window.innerWidth > 768,
              'ml-[280px]': sidebarOpen && window.innerWidth > 768,
              'ml-0': window.innerWidth <= 768
          }">
        <div class="p-8">
            @auth
                <div class="flex justify-end mb-6">
                    @include('partials.auth-dropdown', [
                        'profileRoute' => route('profile.edit'),
                        'profileLabel' => 'Profile',
                        'settingsRoute' => '#',
                        'settingsLabel' => 'Pengaturan',
                        'metaText' => 'Pengguna'
                    ])
                </div>
            @endauth

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @yield('dashboard-content')
        </div>
    </main>
</div>

<style>
    /* Transisi smooth untuk main content */
    main {
        transition: margin-left 0.3s ease-in-out;
    }
    
    /* Atur ulang margin untuk desktop */
    @media (min-width: 769px) {
        .sidebar-collapsed + main,
        .sidebar-collapsed ~ main {
            margin-left: 70px !important;
        }
        
        .sidebar-expanded + main,
        .sidebar-expanded ~ main {
            margin-left: 280px !important;
        }
    }
    
    /* Mobile responsive - reset margin */
    @media (max-width: 768px) {
        main {
            margin-left: 0 !important;
        }
    }
    
    /* Alpine.js cloak */
    [x-cloak] {
        display: none !important;
    }
</style>

<script>
    // Sinkronisasi class sidebar dengan main content
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebarContainer');
        const mainContent = document.querySelector('main');
        
        if (sidebar && mainContent) {
            // Observer untuk memantau perubahan class pada sidebar
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        // Update class main berdasarkan class sidebar
                        if (sidebar.classList.contains('sidebar-collapsed')) {
                            mainContent.classList.add('sidebar-collapsed');
                            mainContent.classList.remove('sidebar-expanded');
                        } else if (sidebar.classList.contains('sidebar-expanded')) {
                            mainContent.classList.add('sidebar-expanded');
                            mainContent.classList.remove('sidebar-collapsed');
                        }
                    }
                });
            });
            
            observer.observe(sidebar, { attributes: true });
            
            // Set initial class
            if (sidebar.classList.contains('sidebar-collapsed')) {
                mainContent.classList.add('sidebar-collapsed');
            } else if (sidebar.classList.contains('sidebar-expanded')) {
                mainContent.classList.add('sidebar-expanded');
            }
        }
    });
</script>
@endsection