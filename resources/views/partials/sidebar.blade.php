<style>
    /* Sidebar Container */
    .sidebar-container {
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        z-index: 40;
        transition: width 0.3s ease-in-out;
    }
    
    /* Sidebar dalam keadaan collapsed (menyempit) */
    .sidebar-collapsed {
        width: 70px;
    }
    
    /* Sidebar saat hover (melebar) */
    .sidebar-expanded {
        width: 280px;
    }
    
    /* Trigger area untuk hover (area sensitif di pinggir kiri) */
    .sidebar-trigger {
        position: fixed;
        left: 0;
        top: 0;
        width: 15px;
        height: 100%;
        z-index: 45;
        cursor: pointer;
    }
    
    /* Konten sidebar */
    .sidebar-content {
        background: white;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
        height: 100%;
        overflow-y: auto;
        width: 100%;
    }
    
    /* Sembunyikan teks saat collapsed */
    .sidebar-collapsed .sidebar-text {
        display: none;
    }
    
    /* Tampilkan teks saat expanded */
    .sidebar-expanded .sidebar-text {
        display: inline;
    }
    
    /* Atur icon dan teks */
    .sidebar-link {
        white-space: nowrap;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
    }
    
    /* Tooltip untuk collapsed mode */
    .sidebar-tooltip {
        position: fixed;
        left: 80px;
        background: #1f2937;
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 50;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
        pointer-events: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .sidebar-link:hover .sidebar-tooltip {
        opacity: 1;
        visibility: visible;
    }
    
    /* Custom scrollbar */
    .sidebar-content::-webkit-scrollbar {
        width: 4px;
    }
    
    .sidebar-content::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .sidebar-content::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    
    .sidebar-content::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Logo styling */
    .sidebar-collapsed .logo-text {
        display: none;
    }
    
    .sidebar-expanded .logo-text {
        display: block;
    }
    
    /* Tombol pin */
    .pin-btn {
        position: absolute;
        right: -12px;
        top: 20px;
        width: 24px;
        height: 24px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 46;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .sidebar-expanded .pin-btn {
        opacity: 1;
    }
    
    .pin-btn:hover {
        background: #f1f5f9;
        transform: scale(1.1);
    }
    
    /* Responsive untuk mobile */
    @media (max-width: 768px) {
        .sidebar-container {
            transform: translateX(-100%);
            z-index: 50;
        }
        
        .sidebar-container.mobile-open {
            transform: translateX(0);
        }
        
        .sidebar-trigger {
            display: none;
        }
        
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 45;
            display: none;
        }
        
        .sidebar-overlay.active {
            display: block;
        }
    }
</style>

<div class="sidebar-container" id="sidebarContainer"
     x-data="{ isPinned: false, isHovering: false }"
     :class="{ 
         'sidebar-collapsed': (!isPinned && !$el.classList.contains('mobile-open')) || (window.innerWidth <= 768 && !$el.classList.contains('mobile-open')), 
         'sidebar-expanded': (isPinned || $el.classList.contains('mobile-open')) && window.innerWidth > 768 
     }"
     @mouseenter="if (!isPinned && window.innerWidth > 768) { $el.classList.remove('sidebar-collapsed'); $el.classList.add('sidebar-expanded'); isHovering = true; }"
     @mouseleave="if (!isPinned && window.innerWidth > 768) { setTimeout(() => { if (!isHovering) { $el.classList.remove('sidebar-expanded'); $el.classList.add('sidebar-collapsed'); } }, 100); isHovering = false; }"
     @sidebar-open.window="$el.classList.add('mobile-open')"
     @sidebar-close.window="$el.classList.remove('mobile-open')">
    
    <!-- Trigger area (area sensitif di pinggir kiri) - hanya untuk desktop -->
    <div class="sidebar-trigger" @mouseenter="if (!isPinned && window.innerWidth > 768) { $el.parentElement.classList.remove('sidebar-collapsed'); $el.parentElement.classList.add('sidebar-expanded'); isHovering = true; }"></div>
    
    <!-- Sidebar Content -->
    <div class="sidebar-content" id="sidebarContent">
        <div class="p-4">
            <!-- Tombol pin/lock -->
            <div class="pin-btn" @click="isPinned = !isPinned" :style="isPinned ? 'background-color: #3b82f6; border-color: #3b82f6;' : 'background-color: white; border-color: #e2e8f0;'">
                <i class="fas fa-thumbtack" :style="isPinned ? 'color: white;' : 'color: #64748b;'" :class="isPinned ? 'fa-rotate-45' : ''"></i>
            </div>
            
            <!-- Logo -->
            <div class="mb-8 text-center">
                <div class="bg-blue-600 w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-2 shadow-lg logo-icon">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-800 logo-text">LaporinAja</h2>
                <p class="text-xs text-gray-500 logo-text">Platform Pengaduan</p>
            </div>
            
            <!-- Close button untuk mobile -->
            <div class="flex justify-end lg:hidden mb-4">
                <button @click="$dispatch('close-sidebar')" class="text-gray-500 hover:text-gray-700 p-2">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Navigation -->
            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="sidebar-link px-3 py-2 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition group relative">
                    <i class="fas fa-tachometer-alt w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400' }}"></i>
                    <span class="sidebar-text">Dashboard</span>
                    <span class="sidebar-tooltip">Dashboard</span>
                </a>
                
                <!-- Laporkan Masalah -->
                <a href="{{ route('laporan.create') }}" 
                   class="sidebar-link px-3 py-2 rounded-xl {{ request()->routeIs('laporan.create') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition group relative">
                    <i class="fas fa-plus-circle w-5 {{ request()->routeIs('laporan.create') ? 'text-white' : 'text-gray-400' }}"></i>
                    <span class="sidebar-text">Laporkan Masalah</span>
                    <span class="sidebar-tooltip">Laporkan Masalah</span>
                </a>
                
                <!-- Pantau Aduan -->
                <a href="{{ route('laporan.index') }}" 
                   class="sidebar-link px-3 py-2 rounded-xl {{ request()->routeIs('laporan.index') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition group relative">
                    <i class="fas fa-eye w-5 {{ request()->routeIs('laporan.index') ? 'text-white' : 'text-gray-400' }}"></i>
                    <span class="sidebar-text">Pantau Aduan</span>
                    <span class="sidebar-tooltip">Pantau Aduan</span>
                </a>
                
                <!-- Gabung Relawan -->
                <a href="{{ route('relawan.create') }}" 
                   class="sidebar-link px-3 py-2 rounded-xl {{ request()->routeIs('relawan.create') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition group relative">
                    <i class="fas fa-hands-helping w-5 {{ request()->routeIs('relawan.create') ? 'text-white' : 'text-gray-400' }}"></i>
                    <span class="sidebar-text">Gabung Relawan</span>
                    <span class="sidebar-tooltip">Gabung Relawan</span>
                </a>
            </nav>
        </div>
    </div>
</div>

<!-- Mobile Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>

<script>
    // Inisialisasi sidebar dalam keadaan collapsed pada desktop
    document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth > 768) {
            document.getElementById('sidebarContainer').classList.add('sidebar-collapsed');
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            // Close mobile sidebar if open
            const sidebar = document.getElementById('sidebarContainer');
            if (sidebar) {
                sidebar.classList.remove('mobile-open');
            }
            const overlay = document.getElementById('sidebarOverlay');
            if (overlay) {
                overlay.classList.remove('active');
            }
            document.body.style.overflow = '';
        }
    });
</script>