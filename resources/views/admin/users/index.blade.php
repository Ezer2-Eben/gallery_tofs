@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    <i class="fas fa-user-cog mr-2"></i>Gestion des Utilisateurs
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Gérer les comptes utilisateurs de la plateforme
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
            </div>
        </div>

        <!-- Table des utilisateurs -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Filtres -->
            <div class="p-4 border-b">
                <div class="flex flex-wrap gap-4">
                    <input type="text" placeholder="Rechercher par nom ou email..." 
                           class="rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 flex-1 min-w-[200px]">
                    <select class="rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tous les statuts</option>
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Utilisateur
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Inscription
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Images
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
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
                                        <div class="text-sm text-gray-500">
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                @if($user->id == 1)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Admin
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($user->created_at)
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->enabled)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Actif
                                </span>
                                @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i> Inactif
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->images_count ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($user->id != 1) <!-- Ne pas pouvoir modifier l'admin -->
                                <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="text-sm {{ $user->enabled ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}">
                                        {{ $user->enabled ? 'Désactiver' : 'Activer' }}
                                    </button>
                                </form>
                                @else
                                <span class="text-gray-400 text-sm">Administrateur</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $users->links() }}
            </div>
            @endif
        </div>

        <!-- Stats -->
        <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="text-sm font-medium text-blue-900">Total utilisateurs</div>
                <div class="text-2xl font-bold text-blue-600">{{ $users->total() }}</div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="text-sm font-medium text-green-900">Utilisateurs actifs</div>
                <div class="text-2xl font-bold text-green-600">
                    {{ $users->where('enabled', true)->count() }}
                </div>
            </div>
            <div class="bg-red-50 p-4 rounded-lg">
                <div class="text-sm font-medium text-red-900">Utilisateurs inactifs</div>
                <div class="text-2xl font-bold text-red-600">
                    {{ $users->where('enabled', false)->count() }}
                </div>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
                <div class="text-sm font-medium text-purple-900">Nouveaux (7j)</div>
                <div class="text-2xl font-bold text-purple-600">
                    {{ $newUsersCount ?? 0 }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection