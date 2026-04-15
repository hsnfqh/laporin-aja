<!-- User Dropdown Component -->
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" 
            @click.away="open = false"
            class="flex items-center gap-3 focus:outline-none group px-2 py-1 rounded-lg hover:bg-gray-50 transition-colors duration-200">
        
        <!-- User Info Text -->
        <div class="text-right hidden sm:block">
            <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-500">
                @if(Auth::user()->role == 'admin')
                    <i class="fas fa-shield-alt text-blue-500 text-xs"></i> Administrator
                @elseif(Auth::user()->role == 'operator')
                    <i class="fas fa-hard-hat text-amber-500 text-xs"></i> {{ $metaText ?? 'Operator Lapangan' }}
                @else
                    <i class="fas fa-user text-green-500 text-xs"></i> {{ $metaText ?? 'Pengguna' }}
                @endif
            </p>
        </div>

        <!-- Avatar - Positioned Right -->
        <div class="relative flex-shrink-0">
            @if(Auth::user()->avatar ?? false)
                <!-- Avatar Image -->
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                     alt="{{ Auth::user()->name }}" 
                     class="w-10 h-10 rounded-full object-cover border-2 border-blue-200 shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
            @else
                <!-- Avatar Initials -->
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center text-white font-bold shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105 group-hover:rotate-3">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            
            <!-- Status Online Indicator -->
            <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-emerald-400 rounded-full border-2 border-white shadow-sm animate-pulse"></div>
            
            <!-- Hover Effect Ring -->
            <div class="absolute inset-0 rounded-full border-2 border-blue-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 scale-110"></div>
        </div>

        <!-- Chevron Icon -->
        <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-300 group-hover:text-gray-600" 
           :class="{'rotate-180': open}"></i>
    </button>
    
    <!-- Dropdown Menu -->
    <div x-show="open" 
         x-cloak 
         class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg py-2 z-50 border border-gray-100"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95">
        
        <!-- User Info Header -->
        <div class="px-4 py-3 border-b bg-gradient-to-r from-gray-50 to-white rounded-t-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full">
                        <i class="fas fa-circle text-green-500 text-[6px]"></i>
                        Active
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Menu Items -->
        <div class="px-4 py-2">
            
            <!-- Back to Dashboard -->
            <a href="@if(Auth::user()->role == 'admin'){{ route('admin.dashboard') }}@elseif(Auth::user()->role == 'operator'){{ route('operator.dashboard') }}@else{{ route('dashboard') }}@endif" 
               class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition rounded-lg">
                <i class="fas fa-home w-4 text-blue-500"></i>
                <span>Kembali ke Dashboard</span>
            </a>

            <!-- Divider -->
            <div class="my-2 border-t border-gray-100"></div>

            @if(isset($profileRoute))
                <a href="{{ $profileRoute }}" 
                   class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition rounded-lg">
                    <i class="fas fa-user-circle w-4 text-gray-400"></i>
                    {{ $profileLabel ?? 'Profile' }}
                </a>
            @endif
            
            @if(isset($settingsRoute))
                <a href="{{ $settingsRoute }}" 
                   class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition rounded-lg">
                    <i class="fas fa-cog w-4 text-gray-400"></i>
                    {{ $settingsLabel ?? 'Pengaturan' }}
                </a>
            @endif

            <!-- Divider -->
            <div class="my-2 border-t border-gray-100"></div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition rounded-lg">
                    <i class="fas fa-sign-out-alt w-4"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
