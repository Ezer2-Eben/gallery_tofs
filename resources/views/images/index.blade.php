@extends('layouts.app')

@section('title', 'Galerie d\'images')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Barre de recherche stylée -->
        <div class="mb-8">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       placeholder="Rechercher des images..." 
                       class="block w-full pl-10 pr-3 py-4 border border-gray-300 rounded-full text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-lg hover:shadow-xl transition duration-300 text-lg"
                       id="search-input">
            </div>
        </div>

        <!-- Filtres de catégories -->
        <div class="mb-8">
            <div class="flex flex-wrap gap-2 justify-center">
                <button class="category-filter px-4 py-2 rounded-full bg-gray-800 text-white text-sm font-medium hover:bg-gray-700 transition duration-300 active" data-category="all">
                    <i class="fas fa-th-large mr-1"></i> Toutes
                </button>
                
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories as $category)
                    <button class="category-filter px-4 py-2 rounded-full bg-gray-200 text-gray-800 text-sm font-medium hover:bg-gray-300 transition duration-300" data-category="{{ $category->id }}">
                        @if($category->icon)
                            <i class="{{ $category->icon }} mr-1"></i>
                        @endif
                        {{ $category->name }}
                    </button>
                    @endforeach
                @else
                    <!-- Catégories par défaut -->
                    <button class="category-filter px-4 py-2 rounded-full bg-gray-200 text-gray-800 text-sm font-medium hover:bg-gray-300 transition duration-300" data-category="nature">
                        <i class="fas fa-tree mr-1"></i> Nature
                    </button>
                    <button class="category-filter px-4 py-2 rounded-full bg-gray-200 text-gray-800 text-sm font-medium hover:bg-gray-300 transition duration-300" data-category="architecture">
                        <i class="fas fa-building mr-1"></i> Architecture
                    </button>
                    <button class="category-filter px-4 py-2 rounded-full bg-gray-200 text-gray-800 text-sm font-medium hover:bg-gray-300" data-category="portrait">
                        <i class="fas fa-user mr-1"></i> Portrait
                    </button>
                    <button class="category-filter px-4 py-2 rounded-full bg-gray-200 text-gray-800 text-sm font-medium hover:bg-gray-300 transition duration-300" data-category="art">
                        <i class="fas fa-paint-brush mr-1"></i> Art
                    </button>
                @endif
            </div>
        </div>

        <!-- Message "Aucun résultat" -->
        <div id="no-results-message" class="hidden text-center py-16 bg-white rounded-lg shadow mb-8">
            <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-medium text-gray-900">Aucune image trouvée</h3>
            <p class="mt-2 text-sm text-gray-500">Essayez avec d'autres mots-clés ou catégories</p>
        </div>

        <!-- Galerie d'images style Pinterest/Masonry -->
        @if($images->count() > 0)
        <div id="image-gallery" class="grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-4">
            @foreach($images as $image)
            <div class="relative group image-item break-inside-avoid rounded-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                 data-category="{{ $image->category_id ?? 'uncategorized' }}"
                 data-title="{{ strtolower($image->title ?? '') }}"
                 data-description="{{ strtolower($image->description ?? '') }}"
                 data-tags="{{ strtolower($image->tags ?? '') }}"
                 data-visibility="{{ $image->visibility }}">
                
                <!-- Image -->
                <a href="{{ route('images.show', $image) }}" class="block">
                    <img src="{{ asset('storage/' . $image->file_path) }}" 
                         alt="{{ $image->title }}" 
                         class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105">
                </a>
                
                <!-- Overlay au survol -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    
                    <!-- Contenu de l'overlay -->
                    <div class="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <!-- Titre et description -->
                        <a href="{{ route('images.show', $image) }}" class="block hover:no-underline">
                            <h3 class="font-bold text-lg truncate hover:text-blue-300 transition duration-300 mb-1">
                                {{ $image->title ?? 'Sans titre' }}
                            </h3>
                        </a>
                        <p class="text-sm text-gray-200 truncate mb-3">{{ $image->description ?? '' }}</p>
                        
                        <!-- Auteur et badges -->
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                @if($image->user)
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-user text-xs mr-1"></i>
                                    <span>{{ $image->user->username ?? $image->user->name }}</span>
                                </div>
                                @endif
                            </div>
                            
                            <div class="flex items-center space-x-1">
                                @if($image->visibility == 'private')
                                <span class="text-xs bg-red-500/90 px-2 py-1 rounded-full">
                                    <i class="fas fa-lock mr-1"></i> Privé
                                </span>
                                @else
                                <span class="text-xs bg-green-500/90 px-2 py-1 rounded-full">
                                    <i class="fas fa-globe mr-1"></i> Public
                                </span>
                                @endif
                                @if($image->category)
                                <span class="text-xs bg-gray-800/90 px-2 py-1 rounded-full">
                                    {{ $image->category->name ?? 'Non catégorisé' }}
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex space-x-2">
                            @auth
                            <button class="like-btn flex-1 bg-white/20 hover:bg-white/30 text-white text-xs py-2 rounded-lg transition duration-300 flex items-center justify-center"
                                    data-image-id="{{ $image->id }}">
                                <i class="fas fa-heart mr-1"></i> 
                                <span class="like-count">{{ $image->likes_count ?? 0 }}</span>
                            </button>
                            @else
                            <a href="{{ route('login') }}" class="flex-1 bg-white/20 hover:bg-white/30 text-white text-xs py-2 rounded-lg transition duration-300 flex items-center justify-center">
                                <i class="fas fa-heart mr-1"></i> 
                                <span>{{ $image->likes_count ?? 0 }}</span>
                            </a>
                            @endauth
                            
                            <a href="{{ asset('storage/' . $image->file_path) }}" 
                               download
                               class="flex-1 bg-white/20 hover:bg-white/30 text-white text-xs py-2 rounded-lg transition duration-300 flex items-center justify-center">
                                <i class="fas fa-download mr-1"></i>
                            </a>
                            
                            <button class="share-btn flex-1 bg-white/20 hover:bg-white/30 text-white text-xs py-2 rounded-lg transition duration-300 flex items-center justify-center"
                                    data-url="{{ route('images.show', $image) }}">
                                <i class="fas fa-share-alt mr-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Badge propriétaire (en haut à gauche) -->
                @if(Auth::check() && $image->user_id == Auth::id())
                <div class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-crown mr-1"></i> Votre image
                </div>
                @endif
                
                <!-- Badge privé (en haut à droite) -->
                @if($image->visibility == 'private')
                <div class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                    <i class="fas fa-lock"></i>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($images->hasPages())
        <div class="mt-8 text-center">
            {{ $images->links() }}
        </div>
        @endif

        @else
        <div class="text-center py-16 bg-white rounded-lg shadow">
            <i class="fas fa-images text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-medium text-gray-900">Aucune image disponible</h3>
            <p class="mt-2 text-sm text-gray-500">Soyez le premier à partager une image !</p>
            @guest
            <div class="mt-4">
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-sign-in-alt mr-2"></i> Connectez-vous pour partager
                </a>
            </div>
            @endguest
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
/* Grille responsive avec largeur fixe maximum */
#image-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    max-width: 100%;
}

.image-item {
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
    max-width: 350px; /* Largeur maximale pour éviter l'étirement */
    width: 100%;
}

/* Image cachée avec transition douce */
.image-item.hidden-item {
    display: none !important;
}

#image-gallery img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    display: block;
    border-radius: 0.5rem;
}

/* Animation au survol */
.image-item:hover {
    transform: translateY(-4px);
}

/* Style pour les images privées */
.image-item[data-visibility="private"] {
    position: relative;
}

.image-item[data-visibility="private"]::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.1);
    z-index: 1;
    border-radius: 0.5rem;
}

/* Animation pour le message "aucun résultat" */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#no-results-message:not(.hidden) {
    animation: fadeIn 0.3s ease-out;
}

/* Responsive */
@media (max-width: 640px) {
    #image-gallery {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
    
    #image-gallery img {
        height: 180px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script chargé !'); // Pour déboguer
    
    const imageGallery = document.getElementById('image-gallery');
    const categoryFilters = document.querySelectorAll('.category-filter');
    const searchInput = document.getElementById('search-input');
    const noResultsMessage = document.getElementById('no-results-message');
    
    console.log('Nombre d\'images:', document.querySelectorAll('.image-item').length);
    
    // Fonction pour filtrer les images
    function filterImages() {
        console.log('Filtrage en cours...');
        
        const imageItems = document.querySelectorAll('.image-item');
        const activeCategory = document.querySelector('.category-filter.active')?.dataset.category || 'all';
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        
        console.log('Recherche:', searchTerm);
        console.log('Catégorie:', activeCategory);
        
        let visibleCount = 0;
        
        imageItems.forEach(item => {
            const itemCategory = item.dataset.category || '';
            const title = item.dataset.title || '';
            const description = item.dataset.description || '';
            const tags = item.dataset.tags || '';
            
            // Vérifier la catégorie
            const matchesCategory = activeCategory === 'all' || itemCategory == activeCategory;
            
            // Vérifier la recherche
            const matchesSearch = searchTerm === '' || 
                                  title.includes(searchTerm) || 
                                  description.includes(searchTerm) ||
                                  tags.includes(searchTerm);
            
            console.log(`Image: ${title}, Catégorie OK: ${matchesCategory}, Recherche OK: ${matchesSearch}`);
            
            // Afficher ou cacher l'image avec classe CSS
            if (matchesCategory && matchesSearch) {
                item.classList.remove('hidden-item');
                visibleCount++;
            } else {
                item.classList.add('hidden-item');
            }
        });
        
        console.log('Images visibles:', visibleCount);
        
        // Afficher/cacher le message "aucun résultat"
        if (visibleCount === 0) {
            if (imageGallery) imageGallery.style.display = 'none';
            if (noResultsMessage) noResultsMessage.classList.remove('hidden');
        } else {
            if (imageGallery) imageGallery.style.display = 'block';
            if (noResultsMessage) noResultsMessage.classList.add('hidden');
        }
    }
    
    // Filtrage par catégorie
    categoryFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            console.log('Catégorie cliquée:', this.dataset.category);
            
            // Retirer la classe active de tous les boutons
            categoryFilters.forEach(btn => {
                btn.classList.remove('active', 'bg-gray-800', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-800');
            });
            
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active', 'bg-gray-800', 'text-white');
            this.classList.remove('bg-gray-200', 'text-gray-800');
            
            // Filtrer les images
            filterImages();
        });
    });
    
    // Recherche en temps réel
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            console.log('Saisie:', e.target.value);
            filterImages();
        });
    } else {
        console.error('Barre de recherche non trouvée !');
    }
    
    // Gestion des likes (uniquement pour les utilisateurs connectés)
    const likeButtons = document.querySelectorAll('.like-btn');
    likeButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const imageId = this.dataset.imageId;
            const likeCount = this.querySelector('.like-count');
            
            // Envoyer une requête AJAX au serveur
            fetch(`/images/${imageId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    likeCount.textContent = data.likes;
                    this.classList.toggle('text-red-500');
                    
                    // Animation de like
                    this.classList.add('animate-pulse');
                    setTimeout(() => {
                        this.classList.remove('animate-pulse');
                    }, 300);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
    
    // Gestion du partage (accessible à tous)
    const shareButtons = document.querySelectorAll('.share-btn');
    shareButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const url = this.dataset.url;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Découvrez cette image !',
                    text: 'Regardez cette image sur ImageGallery',
                    url: url
                }).catch(err => console.log('Erreur de partage:', err));
            } else {
                // Fallback pour les navigateurs qui ne supportent pas l'API Share
                navigator.clipboard.writeText(url).then(() => {
                    // Notification temporaire
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-check mr-1"></i>Copié';
                    this.classList.add('bg-green-500/30');
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('bg-green-500/30');
                    }, 2000);
                }).catch(err => {
                    console.error('Erreur de copie:', err);
                    alert('Lien: ' + url);
                });
            }
        });
    });
    
    // Téléchargement avec animation (accessible à tous)
    const downloadLinks = document.querySelectorAll('a[download]');
    downloadLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Animation de téléchargement
            const icon = this.querySelector('i');
            if (icon) {
                icon.classList.add('animate-bounce');
                setTimeout(() => {
                    icon.classList.remove('animate-bounce');
                }, 600);
            }
        });
    });
});
</script>
@endpush

@endsection