@extends('layouts.app')

@section('title', 'Catégories')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    <i class="fas fa-folder mr-2"></i>Catégories
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Parcourez les images par catégories
                </p>
            </div>
            @if(Auth::id() == 1)
            <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                <a href="{{ route('admin.categories.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                    <i class="fas fa-plus mr-2"></i> Nouvelle catégorie
                </a>
                <a href="{{ route('admin.subcategories.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i> Nouvelle sous-catégorie
                </a>
            </div>
            @endif
        </div>

        <!-- Liste des catégories -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
            <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition duration-300">
                <div class="p-6">
                    <!-- En-tête de la catégorie -->
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                <a href="{{ route('categories.show', $category) }}" 
                                   class="hover:text-blue-600">
                                    {{ $category->name }}
                                </a>
                            </h3>
                            @if($category->description)
                            <p class="mt-1 text-sm text-gray-500">
                                {{ Str::limit($category->description, 100) }}
                            </p>
                            @endif
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                            {{ $category->images_count }} images
                        </span>
                    </div>

                    <!-- Sous-catégories -->
                    @if($category->subcategories->count() > 0)
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Sous-catégories</h4>
                        <div class="space-y-2">
                            @foreach($category->subcategories as $subcategory)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">{{ $subcategory->name }}</span>
                                <span class="text-gray-400 text-xs">
                                    {{ $subcategory->images_count }} images
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-6 flex justify-between items-center">
                        <a href="{{ route('categories.show', $category) }}" 
                           class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                            <i class="fas fa-eye mr-1"></i> Voir les images
                        </a>
                        
                        @if(Auth::id() == 1)
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="text-gray-400 hover:text-blue-600">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Supprimer cette catégorie et toutes ses sous-catégories ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Message si aucune catégorie -->
        @if($categories->count() == 0)
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <i class="fas fa-folder-open text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900">Aucune catégorie</h3>
            <p class="mt-1 text-sm text-gray-500">Aucune catégorie n'a été créée pour le moment.</p>
            @if(Auth::id() == 1)
            <a href="{{ route('admin.categories.create') }}" 
               class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                <i class="fas fa-plus mr-2"></i> Créer la première catégorie
            </a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection