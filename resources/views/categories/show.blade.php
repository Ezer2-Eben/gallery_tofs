@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    <i class="fas fa-folder mr-2"></i>{{ $category->name }}
                </h2>
                @if($category->description)
                <p class="mt-1 text-sm text-gray-500">{{ $category->description }}</p>
                @endif
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('categories.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
                @if(Auth::id() == 1)
                <div class="ml-3 flex space-x-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i> Modifier
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Sous-catégories -->
        @if($subcategories->count() > 0)
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Sous-catégories</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($subcategories as $subcategory)
                <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $subcategory->name }}</h4>
                            @if($subcategory->description)
                            <p class="text-sm text-gray-500 mt-1">{{ $subcategory->description }}</p>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500">
                            {{ $subcategories->images_count ?? 0 }} images
                        </span>
                    </div>
                    @if(Auth::id() == 1)
                    <div class="mt-3 flex justify-end space-x-2">
                        <a href="{{ route('admin.subcategories.edit', $subcategory) }}" 
                           class="text-sm text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" 
                              method="POST" 
                              onsubmit="return confirm('Supprimer cette sous-catégorie ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Images de la catégorie -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    Images ({{ $images->total() }})
                </h3>
                @if($images->count() > 0)
                <div class="text-sm text-gray-500">
                    Affichage {{ $images->firstItem() }}-{{ $images->lastItem() }} sur {{ $images->total() }}
                </div>
                @endif
            </div>

            @if($images->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($images as $image)
                <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="relative h-48">
                        <img src="{{ asset('storage/' . $image->file_path) }}" 
                             alt="{{ $image->title }}" 
                             class="w-full h-full object-cover">
                        
                        <!-- Badge de visibilité -->
                        @if($image->visibility == 'private')
                        <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs">
                            <i class="fas fa-lock"></i>
                        </div>
                        @endif
                        
                        <!-- Sous-catégorie -->
                        @if($image->subcategory)
                        <div class="absolute bottom-2 left-2 bg-black/50 text-white px-2 py-1 rounded text-xs">
                            {{ $image->subcategory->name }}
                        </div>
                        @endif
                    </div>
                    
                    <div class="p-3">
                        <h4 class="font-semibold text-gray-900 truncate">{{ $image->title ?? 'Sans titre' }}</h4>
                        <div class="mt-2 flex items-center justify-between text-sm">
                            <span class="text-gray-500 truncate">
                                <i class="fas fa-user mr-1"></i>{{ $image->user->username }}
                            </span>
                            <span class="text-gray-500">
                                @if($image->created_at)
                                    {{ \Carbon\Carbon::parse($image->created_at)->format('d/m/Y') }}
                                @endif
                            </span>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('images.show', $image) }}" 
                               class="block text-center py-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100">
                                <i class="fas fa-eye mr-1"></i> Voir
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($images->hasPages())
            <div class="mt-6">
                {{ $images->links() }}
            </div>
            @endif

            @else
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <i class="fas fa-images text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">Aucune image dans cette catégorie</h3>
                <p class="mt-1 text-sm text-gray-500">Soyez le premier à ajouter une image dans cette catégorie !</p>
                @auth
                <a href="{{ route('images.create') }}" 
                   class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i> Ajouter une image
                </a>
                @endauth
            </div>
            @endif
        </div>
    </div>
</div>
@endsection