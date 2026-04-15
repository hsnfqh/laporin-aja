<nav class="fixed top-0 left-0 w-full bg-white/95 backdrop-blur-md shadow-lg z-50 transition-all duration-300">
    <div class="container mx-auto px-6 md:px-24">
        <div class="flex justify-between items-center py-4">
            <a href="{{ url('/') }}" class="inline-flex items-center" aria-label="LaporinAja">
                <img src="{{ asset('images/logo.png') }}" alt="Logo LaporinAja" class="h-10 w-auto md:h-12 object-contain">
            </a>

            <!-- Menu Desktop -->
            <ul class="hidden md:flex space-x-8 font-medium items-center">
                <li><a href="{{ url('/') }}" class="relative text-gray-700 hover:text-blue-600 transition duration-300 group font-medium">
                    Beranda
                    <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
                </a></li>
                <li><a href="#tentang" class="relative text-gray-700 hover:text-blue-600 transition duration-300 group font-medium">
                    Tentang Kami
                    <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
                </a></li>
                <li><a href="#layanan" class="relative text-gray-700 hover:text-blue-600 transition duration-300 group font-medium">
                    Layanan
                    <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
                </a></li>
                <li><a href="#informasi" class="relative text-gray-700 hover:text-blue-600 transition duration-300 group font-medium">
                    Informasi
                    <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
                </a></li>
            </ul>
                
            <!-- TOMBOL PORTAL ADMIN - Hanya untuk user yang belum login (Desktop) -->
            @guest
                <div class="hidden md:block">
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-full hover:from-blue-700 hover:to-blue-800 transition duration-300 shadow-md hover:shadow-lg flex items-center gap-2">
                        <i class="fas fa-user-shield text-sm"></i>
                        Portal Admin
                    </a>
                </div>
            @endguest

            <!-- USER MENU FOR AUTHENTICATED USERS (Desktop) -->
            @auth
                <div class="hidden md:block">
                    @include('partials.auth-dropdown', [
                        'dashboardRoute' => route('dashboard'),
                        'dashboardLabel' => 'Dashboard',
                        'profileRoute' => route('profile.edit'),
                        'profileLabel' => 'Profile',
                        'metaText' => Auth::user()->role === 'admin' ? 'Administrator' : 'Pengguna'
                    ])
                </div>
            @endauth

            <!-- Hamburger Button -->
            <button id="menu-btn" class="md:hidden flex flex-col space-y-1.5 p-2 rounded-lg hover:bg-gray-100 transition duration-300">
                <span class="w-6 h-0.5 bg-gray-700 transition-all duration-300"></span>
                <span class="w-6 h-0.5 bg-gray-700 transition-all duration-300"></span>
                <span class="w-6 h-0.5 bg-gray-700 transition-all duration-300"></span>
            </button>
        </div>
    </div>

    <!-- Menu Mobile - Improved Responsive Design -->
    <div id="mobile-menu" class="hidden md:hidden bg-white shadow-xl border-t border-gray-100">
        <div class="container mx-auto px-6 py-6">
            <!-- Navigation Links -->
            <div class="flex flex-col space-y-3 mb-6">
                <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-xl transition duration-300">
                    <i class="fas fa-home w-5 text-gray-400"></i>
                    <span>Beranda</span>
                </a>
                <a href="#tentang" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-xl transition duration-300">
                    <i class="fas fa-info-circle w-5 text-gray-400"></i>
                    <span>Tentang Kami</span>
                </a>
                <a href="#layanan" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-xl transition duration-300">
                    <i class="fas fa-concierge-bell w-5 text-gray-400"></i>
                    <span>Layanan</span>
                </a>
                <a href="#informasi" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-xl transition duration-300">
                    <i class="fas fa-bell w-5 text-gray-400"></i>
                    <span>Informasi</span>
                </a>
            </div>
            
            <!-- Divider -->
            <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent my-4"></div>
            
            <!-- Action Buttons for Mobile -->
            <div class="space-y-3">
                <!-- Portal Warga di Mobile - OUTLINE -->
                @if(Route::has('warga.portal'))
                    <a href="{{ route('warga.portal') }}" class="flex items-center justify-center gap-2 px-6 py-3 bg-transparent border-2 border-blue-600 text-blue-600 font-medium rounded-xl w-full text-center hover:bg-blue-600 hover:text-white transition duration-300">
                        <i class="fas fa-users"></i>
                        Portal Warga
                    </a>
                @endif
                
                <!-- Portal Admin di Mobile - Hanya untuk user yang belum login -->
                @guest
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-xl w-full text-center hover:from-blue-700 hover:to-blue-800 transition duration-300 shadow-md">
                        <i class="fas fa-user-shield"></i>
                        Portal Admin
                    </a>
                @endguest

                <!-- USER MENU FOR AUTHENTICATED USERS - MOBILE -->
                @auth
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4">
                        <div class="flex items-center gap-3 mb-4 pb-3 border-b border-blue-100">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                <span class="inline-block mt-1 text-xs px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full">
                                    {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Pengguna' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-600 hover:text-white transition duration-300 shadow-sm">
                                <i class="fas fa-tachometer-alt w-5"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 bg-white text-gray-700 font-medium rounded-lg hover:bg-blue-600 hover:text-white transition duration-300 shadow-sm">
                                <i class="fas fa-user-edit w-5"></i>
                                <span>Edit Profile</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline w-full">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 px-4 py-2.5 bg-white text-red-600 font-medium rounded-lg hover:bg-red-600 hover:text-white transition duration-300 shadow-sm w-full">
                                    <i class="fas fa-sign-out-alt w-5"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            
            // Add animation for hamburger icon (optional)
            const spans = menuBtn.querySelectorAll('span');
            if (!mobileMenu.classList.contains('hidden')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });
    }
    
    // Close mobile menu when clicking on a link
    const mobileLinks = document.querySelectorAll('#mobile-menu a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                // Reset hamburger icon
                const spans = menuBtn.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });
    });
    
    // Close mobile menu when clicking outside (optional)
    document.addEventListener('click', (event) => {
        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
            const isClickInside = mobileMenu.contains(event.target) || menuBtn.contains(event.target);
            if (!isClickInside) {
                mobileMenu.classList.add('hidden');
                const spans = menuBtn.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        }
    });
</script>