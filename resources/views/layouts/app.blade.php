<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Galerie d'Images</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .form-input:focus, .form-select:focus {
            outline: none;
            ring: 2px;
            ring-blue-500;
            border-color: #3b82f6;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="text-2xl font-bold text-blue-600">
                        <i class="fas fa-camera-retro mr-2"></i>Galerie
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Vérifier si c'est le premier utilisateur (admin) -->
                        @if(Auth::id() == 1)
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                                <i class="fas fa-shield-alt mr-1"></i>Admin
                            </a>
                        @endif
                        
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">
                            <i class="fas fa-user mr-1"></i>{{ Auth::user()->username }}
                        </a>
                        <a href="{{ route('images.index') }}" class="text-gray-700 hover:text-blue-600">
                            <i class="fas fa-images mr-1"></i>Images
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-red-600">
                                <i class="fas fa-sign-out-alt mr-1"></i>Déconnexion
                            </button>
                        </form>
                    @else
                        <a href="{{ route('images.index') }}" class="text-gray-700 hover:text-blue-600">
                            <i class="fas fa-images mr-1"></i>Explorer
                        </a>
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">
                            <i class="fas fa-sign-in-alt mr-1"></i>Connexion
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-user-plus mr-1"></i>Inscription
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu Principal -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Messages flash -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-8">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Galerie d'Images. Tous droits réservés.
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>