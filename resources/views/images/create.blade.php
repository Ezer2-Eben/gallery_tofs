@extends('layouts.app')

@section('title', 'Ajouter une image')

@section('styles')
<style>
    #imagePreview img {
        max-height: 300px;
        object-fit: contain;
    }
</style>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    <i class="fas fa-upload mr-2"></i>Ajouter une image
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Téléchargez une nouvelle image dans votre galerie
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('images.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <div class="space-y-6">
                    <!-- Upload d'image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Sélectionnez une image *
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition duration-300">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Télécharger un fichier</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*" required>
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF jusqu'à 10MB
                                </p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <!-- Aperçu de l'image -->
                        <div id="imagePreview" class="mt-4 hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Aperçu</label>
                            <div class="flex justify-center">
                                <img id="preview" class="max-w-full rounded-lg shadow border">
                            </div>
                        </div>
                    </div>

                    <!-- Titre -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">
                            Titre de l'image *
                        </label>
                        <input type="text" name="title" id="title" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               placeholder="Un titre descriptif pour votre image"
                               value="{{ old('title') }}">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="3"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                  placeholder="Décrivez votre image...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">
                            Catégorie *
                        </label>
                        <select id="category_id" name="category_id" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Visibilité -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Visibilité *
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <input id="visibility_public" name="visibility" type="radio" value="public" 
                                       class="hidden peer"
                                       {{ old('visibility', 'public') == 'public' ? 'checked' : '' }}>
                                <label for="visibility_public" 
                                       class="block p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full hidden peer-checked:block"></div>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 flex items-center">
                                                <i class="fas fa-globe mr-2 text-green-500"></i>
                                                Publique
                                            </div>
                                            <p class="text-sm text-gray-500">Visible par tous les utilisateurs</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            
                            <div>
                                <input id="visibility_private" name="visibility" type="radio" value="private"
                                       class="hidden peer"
                                       {{ old('visibility') == 'private' ? 'checked' : '' }}>
                                <label for="visibility_private" 
                                       class="block p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full hidden peer-checked:block"></div>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 flex items-center">
                                                <i class="fas fa-lock mr-2 text-red-500"></i>
                                                Privé
                                            </div>
                                            <p class="text-sm text-gray-500">Visible uniquement par vous</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @error('visibility')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-3 pt-6 border-t">
                        <a href="{{ route('images.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Annuler
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-upload mr-2"></i>
                            Télécharger l'image
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Aperçu de l'image
document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.classList.remove('hidden');
        }
        
        reader.readAsDataURL(this.files[0]);
    } else {
        previewDiv.classList.add('hidden');
    }
});

// Glisser-déposer
const dropZone = document.querySelector('.border-dashed');
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('border-blue-400', 'bg-blue-50');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('border-blue-400', 'bg-blue-50');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-blue-400', 'bg-blue-50');
    
    if (e.dataTransfer.files.length) {
        const fileInput = document.getElementById('image');
        fileInput.files = e.dataTransfer.files;
        
        // Déclencher le changement pour l'aperçu
        const event = new Event('change');
        fileInput.dispatchEvent(event);
    }
});

// Validation de la taille
document.querySelector('form').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('image');
    if (fileInput.files.length > 0) {
        const fileSize = fileInput.files[0].size / 1024 / 1024; // en MB
        if (fileSize > 10) {
            e.preventDefault();
            alert('Le fichier est trop volumineux (max 10MB)');
        }
    }
});
</script>
@endsection