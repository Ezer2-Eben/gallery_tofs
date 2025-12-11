@extends('layouts.app')

@section('title', 'Administration')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    <i class="fas fa-shield-alt mr-2"></i>Tableau de Bord Administrateur
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Gestion complète de la plateforme Galerie d'Images
                </p>
            </div>
        </div>

        <!-- Stats Admin -->
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-blue-500 rounded-md">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Utilisateurs total
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $totalUsers ?? 0 }}
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
                            <div class="p-3 bg-purple-500 rounded-md">
                                <i class="fas fa-folder text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Catégories
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $totalCategories ?? 0 }}
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
                            <div class="p-3 bg-red-500 rounded-md">
                                <i class="fas fa-history text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Logs aujourd'hui
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $todayLogs ?? 0 }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Admin -->
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Gestion utilisateurs -->
            <a href="{{ route('admin.users.index') }}" 
               class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-blue-100 rounded-md">
                                <i class="fas fa-user-cog text-blue-600 text-2xl"></i>
                            </div>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-medium text-gray-900">Gestion Utilisateurs</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Activer/Désactiver les comptes utilisateurs
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Gestion catégories -->
            <a href="{{ route('admin.categories.index') }}" 
               class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-green-100 rounded-md">
                                <i class="fas fa-sitemap text-green-600 text-2xl"></i>
                            </div>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-medium text-gray-900">Gestion Catégories</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Créer et gérer les catégories
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Gestion images -->
            <a href="{{ route('admin.images.index') }}" 
               class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-purple-100 rounded-md">
                                <i class="fas fa-image text-purple-600 text-2xl"></i>
                            </div>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-medium text-gray-900">Gestion Images</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Voir et supprimer toutes les images
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Logs système -->
            <a href="{{ route('admin.logs.index') }}" 
               class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-red-100 rounded-md">
                                <i class="fas fa-clipboard-list text-red-600 text-2xl"></i>
                            </div>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-medium text-gray-900">Logs Système</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Historique des actions sur la plateforme
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Nouveaux utilisateurs -->
            <div class="bg-white overflow-hidden shadow rounded-lg sm:col-span-2">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Nouveaux utilisateurs (7 derniers jours)</h3>
                    @if(isset($newUsers) && $newUsers->count() > 0)
                    <div class="space-y-4">
                        @foreach($newUsers as $user)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-600 font-semibold">
                                            {{ substr($user->username, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->username }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                                @if($user->created_at)
                                    {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-4">Aucun nouvel utilisateur</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Activité récente -->
        <div class="mt-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Activité récente</h3>
                <div class="h-64 flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg">
                    <div class="text-center">
                        <i class="fas fa-chart-line text-4xl text-gray-300 mb-2"></i>
                        <p class="text-gray-500">Graphique d'activité</p>
                        <p class="text-sm text-gray-400 mt-1">
                            @if(isset($weeklyStats))
                            Inscriptions: {{ $weeklyStats['users'] ?? 0 }} | Images: {{ $weeklyStats['images'] ?? 0 }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection