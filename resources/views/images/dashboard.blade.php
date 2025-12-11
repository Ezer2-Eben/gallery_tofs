@extends('layouts.app')

@section('title', 'Galerie d\'Images')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('images.index') }}" class="flex items-center space-x-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-xl font-bold text-gray-800">GalleryPro</span>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-2xl mx-8">
                    <form action="{{ route('images.index') }}" method="GET" class="relative">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Rechercher des images..." 
                                   class="w-full pl-12 pr-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent focus:outline-none transition">
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            @if(request('search'))
                            <a href="{{ route('images.index') }}" 
                               class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    @auth
                    <!-- Upload Button -->
                    <a href="{{ route('images.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Upload
                    </a>
                    
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr(auth()->user()->username, 0, 1) }}
                            </div>
                            <span class="text-gray-700 font-medium hidden md:inline">
                                {{ auth()->user()->username }}
                            </span>
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50">
                            <a href="{{ route('profile.edit') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profil</a>
                            <a href="{{ route('images.my-images') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Mes images</a>
                            <div class="border-t border-gray-200"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" 
                           class="text-gray-700 hover:text-purple-600 transition">Connexion</a>
                        <a href="{{ route('register') }}" 
                           class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            S'inscrire
                        </a>
                    </div>
                    @endauth
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="flex items-center justify-between py-3 border-t">
                <div class="flex items-center space-x-4 overflow-x-auto">
                    <span class="text-gray-600 font-medium">Filtrer par :</span>
                    <a href="{{ route('images.index') }}" 
                       class="px-3 py-1 rounded-full {{ !request('category') ? 'bg-purple-100 text-purple-600' : 'text-gray-600 hover:text-purple-600' }}">
                        Toutes
                    </a>
                    @foreach($categories ?? [] as $category)
                    <a href="{{ route('images.index', ['category' => $category->id]) }}" 
                       class="px-3 py-1 rounded-full {{ request('category') == $category->id ? 'bg-purple-100 text-purple-600' : 'text-gray-600 hover:text-purple-600' }}">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
                
                <!-- Sort Options -->
                <div class="flex items-center space-x-2">
                    <span class="text-gray-600">Trier par :</span>
                    <select class="border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500" 
                            onchange="window.location.href = '{{ route('images.index') }}?sort=' + this.value">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récent</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus ancien</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Plus populaire</option>
                    </select>
                </div>
            </div>
        </div>
    </nav>

    <!-- Gallery Masonry -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(isset($images) && $images->count() > 0)
        <div class="masonry-grid" id="gallery">
            @foreach($images as $image)
            <div class="masonry-item group relative overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-2xl">
                <!-- Image -->
                <a href="{{ route('images.show', $image) }}" class="block">
                    <img src="{{ asset('storage/' . $image->file_path) }}" 
                         alt="{{ $image->title }}" 
                         class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-110">
                </a>
                
                <!-- Overlay Info -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-4">
                    <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                        <!-- Title and Description -->
                        <h3 class="text-white font-bold text-lg truncate mb-1">
                            {{ $image->title }}
                        </h3>
                        <p class="text-gray-200 text-sm mb-3 line-clamp-2">
                            {{ $image->description }}
                        </p>
                        
                        <!-- Metadata -->
                        <div class="flex items-center justify-between text-sm text-gray-300 mb-4">
                            <div class="flex items-center space-x-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $image->user->username }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $image->created_at->diffForHumans() }}
                                </span>
                            </div>
                            
                            <!-- Visibility Badge -->
                            @if($image->visibility == 'private')
                            <span class="bg-red-500/80 text-white px-2 py-1 rounded-full text-xs">
                                <i class="fas fa-lock mr-1"></i> Privé
                            </span>
                            @else
                            <span class="bg-green-500/80 text-white px-2 py-1 rounded-full text-xs">
                                <i class="fas fa-globe mr-1"></i> Public
                            </span>
                            @endif
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex space-x-2">
                            <a href="{{ route('images.show', $image) }}" 
                               class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-white/20 backdrop-blur-sm text-white rounded-lg hover:bg-white/30 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Voir
                            </a>
                            <a href="{{ asset('storage/' . $image->file_path) }}" 
                               download
                               class="inline-flex items-center px-3 py-2 bg-purple-600/80 backdrop-blur-sm text-white rounded-lg hover:bg-purple-700/80 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($images->hasPages())
        <div class="mt-8">
            {{ $images->links() }}
        </div>
        @endif
        @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Aucune image trouvée</h3>
            <p class="mt-2 text-gray-500">
                @if(request('search'))
                Aucun résultat pour "{{ request('search') }}". Essayez d'autres termes.
                @else
                Commencez par uploader votre première image !
                @endif
            </p>
            @auth
            <div class="mt-6">
                <a href="{{ route('images.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Uploader une image
                </a>
            </div>
            @endauth
        </div>
        @endif
    </main>
</div>

<!-- Masonry Grid Styles -->
<style>
    .masonry-grid {
        column-count: 1;
        column-gap: 1rem;
    }
    
    .masonry-item {
        break-inside: avoid;
        margin-bottom: 1rem;
    }
    
    @media (min-width: 640px) {
        .masonry-grid {
            column-count: 2;
        }
    }
    
    @media (min-width: 768px) {
        .masonry-grid {
            column-count: 3;
        }
    }
    
    @media (min-width: 1024px) {
        .masonry-grid {
            column-count: 4;
        }
    }
    
    @media (min-width: 1280px) {
        .masonry-grid {
            column-count: 5;
        }
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<!-- Alpine.js for Dropdown -->
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>

<!-- Masonry Initialization -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize masonry layout
        function initMasonry() {
            const grid = document.getElementById('gallery');
            if (!grid) return;
            
            // Simple masonry effect
            const items = grid.querySelectorAll('.masonry-item');
            const columns = getComputedStyle(grid).columnCount;
            
            // Add staggered animation
            items.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.05}s`;
                item.classList.add('animate-fadeInUp');
            });
        }
        
        // Hover effects for gallery items
        const galleryItems = document.querySelectorAll('.masonry-item');
        galleryItems.forEach(item => {
            const img = item.querySelector('img');
            const overlay = item.querySelector('.absolute');
            
            item.addEventListener('mouseenter', () => {
                if (img) {
                    img.style.transform = 'scale(1.05)';
                }
                if (overlay) {
                    overlay.style.opacity = '1';
                }
            });
            
            item.addEventListener('mouseleave', () => {
                if (img) {
                    img.style.transform = 'scale(1)';
                }
                if (overlay) {
                    overlay.style.opacity = '0';
                }
            });
        });
        
        // Initialize
        initMasonry();
        
        // Re-initialize on window resize
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                initMasonry();
            }, 250);
        });
    });
    
    // Animation styles
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }
        
        .masonry-item {
            position: relative;
        }
        
        .masonry-item .absolute {
            transition: opacity 0.3s ease;
        }
        
        .masonry-item img {
            transition: transform 0.5s ease;
        }
    `;
    document.head.appendChild(style);
</script>
@endsection