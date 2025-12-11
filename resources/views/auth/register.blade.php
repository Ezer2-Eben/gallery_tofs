@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Créez votre compte
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Ou
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    connectez-vous à votre compte existant
                </a>
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Nom d'utilisateur *</label>
                    <input id="username" name="username" type="text" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="Votre pseudo"
                           value="{{ old('username') }}">
                    @error('username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input id="first_name" name="first_name" type="text" 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               placeholder="Jean"
                               value="{{ old('first_name') }}">
                    </div>
                    
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                        <input id="last_name" name="last_name" type="text" 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               placeholder="Dupont"
                               value="{{ old('last_name') }}">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input id="email" name="email" type="email" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="votre@email.com"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700">Âge</label>
                        <input id="age" name="age" type="number" min="1" max="120" 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               placeholder="25"
                               value="{{ old('age') }}">
                    </div>
                    
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Genre</label>
                        <select id="gender" name="gender" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Sélectionnez...</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Homme</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femme</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Autre</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe *</label>
                    <input id="password" name="password" type="password" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="********">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe *</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="********">
                </div>
            </div>

            <div class="flex items-center">
                <input id="terms" name="terms" type="checkbox" required 
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-900">
                    J'accepte les conditions d'utilisation
                </label>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus text-blue-300 group-hover:text-blue-400"></i>
                    </span>
                    Créer mon compte
                </button>
            </div>
        </form>
    </div>
</div>
@endsection