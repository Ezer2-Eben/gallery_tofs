@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    <i class="fas fa-tachometer-alt mr-2"></i>Tableau de Bord
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Bienvenue, {{ auth()->user()->username }} ! Gérez vos images et votre profil.
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('images.create') }}" 
                   class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i> Ajouter une image
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-blue-500 rounded-md">
                                <i class="fas fa-images text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Images totales
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $totalImages ?? 0 }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-green-500 rounded-md">
                                <i class="fas fa-eye text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Images publiques
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $publicImages ?? 0 }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-purple-500 rounded-md">
                                <i class="fas fa-folder text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Catégories disponibles
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $totalCategories ?? 0 }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dernières images -->
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Vos dernières images</h3>
            @if(isset($recentImages) && $recentImages->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($recentImages as $image)
                <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="relative h-48">
                        <img src="{{ asset('storage/' . $image->file_path) }}" 
                             alt="{{ $image->title }}" 
                             class="w-full h-full object-cover">
                        @if($image->visibility == 'private')
                        <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs">
                            <i class="fas fa-lock"></i> Privé
                        </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-900 truncate">{{ $image->title ?? 'Sans titre' }}</h4>
                        <p class="text-sm text-gray-500 truncate">{{ $image->description ?? 'Pas de description' }}</p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-xs text-gray-500">
                                @if($image->created_at)
                                    {{ \Carbon\Carbon::parse($image->created_at)->format('d/m/Y') }}
                                @endif
                            </span>
                            <a href="{{ route('images.show', $image) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">
                                <i class="fas fa-eye"></i> Voir
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <i class="fas fa-images text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">Aucune image téléchargée</h3>
                <p class="mt-1 text-sm text-gray-500">Commencez par ajouter votre première image !</p>
                <a href="{{ route('images.create') }}" 
                   class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i> Ajouter une image
                </a>
            </div>
            @endif
        </div>

        <!-- Actions rapides -->
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('images.index') }}" 
               class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition duration-300">
                <div class="p-5 flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-blue-100 rounded-md">
                            <i class="fas fa-images text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5">
                        <h3 class="text-lg font-medium text-gray-900">Mes images</h3>
                        <p class="mt-1 text-sm text-gray-500">Voir toutes mes images</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('categories.index') }}" 
               class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition duration-300">
                <div class="p-5 flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-green-100 rounded-md">
                            <i class="fas fa-folder text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5">
                        <h3 class="text-lg font-medium text-gray-900">Catégories</h3>
                        <p class="mt-1 text-sm text-gray-500">Parcourir par catégorie</p>
                    </div>
                </div>
            </a>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Statut du compte</h3>
                    <div class="flex items-center">
                        @if(auth()->user()->enabled)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i> Actif
                        </span>
                        @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i> Désactivé
                        </span>
                        @endif
                        <span class="ml-4 text-sm text-gray-500">
                            @if(auth()->user()->created_at)
                                Créé le {{ \Carbon\Carbon::parse(auth()->user()->created_at)->format('d/m/Y') }}
                            @else
                                Date inconnue
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection