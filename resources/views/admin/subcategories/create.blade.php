@extends('layouts.app')

@section('title', 'Nouvelle Sous-catégorie')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    <i class="fas fa-plus mr-2"></i>Nouvelle Sous-catégorie
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Créer une sous-catégorie pour affiner l'organisation
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('categories.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.subcategories.store') }}" method="POST" class="p-6">
                @csrf
                
                <div class="space-y-6">
                    <!-- Catégorie parente -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">
                            Catégorie parente *
                        </label>
                        <select id="category_id" name="category_id" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nom -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nom de la sous-catégorie *
                        </label>
                        <input type="text" name="name" id="name" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               placeholder="Animaux, Paysages, Portraits..."
                               value="{{ old('name') }}">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="4"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                  placeholder="Décrivez le thème de cette sous-catégorie...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-3 pt-6 border-t">
                        <a href="{{ route('categories.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Annuler
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-check mr-2"></i>
                            Créer la sous-catégorie
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection