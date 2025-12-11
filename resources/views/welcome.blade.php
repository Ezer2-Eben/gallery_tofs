<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Pro - Votre Galerie d'Images</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(124, 58, 237, 0.5);
            }
            50% {
                box-shadow: 0 0 40px rgba(124, 58, 237, 0.8);
            }
        }

        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 1s ease-out forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .animate-gradient {
            animation: gradient-shift 3s ease infinite;
            background-size: 200% 200%;
        }

        .delay-200 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .delay-400 {
            animation-delay: 0.4s;
            opacity: 0;
        }

        .delay-600 {
            animation-delay: 0.6s;
            opacity: 0;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        body {
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-black min-h-screen overflow-hidden">
    <!-- Hero Section -->
    <div class="relative min-h-screen overflow-hidden">
        <!-- Arrière-plan animé -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900 via-black to-gray-900 animate-gradient"></div>
        
        <!-- Cercles animés en arrière-plan -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-600 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-pink-600 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-indigo-600 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 2s;"></div>

        <!-- Contenu principal -->
        <div class="relative z-10 container mx-auto px-6 h-screen flex flex-col justify-center items-center">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Logo et Titre -->
                <div class="flex flex-col items-center mb-8 animate-fadeInUp">
                    <div class="w-20 h-20 mb-6 bg-gradient-to-br from-purple-600 to-pink-600 rounded-2xl flex items-center justify-center animate-pulse-glow">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-4">
                        Gallery <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">Pro</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-gray-300 mb-12 animate-fadeInUp delay-200">
                        Découvrez et partagez les plus belles images du monde
                    </p>
                </div>

                <!-- Boutons CTA -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center animate-fadeInUp delay-400">
                    <!-- Bouton Créer un compte -->
                    <a href="/register" 
                       class="group relative px-10 py-5 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-2xl font-bold text-lg hover-scale shadow-2xl transition-all duration-300 hover:shadow-purple-500/50">
                        <span class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Créer un compte
                        </span>
                        <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition-opacity animate-pulse-glow"></div>
                    </a>

                    <!-- Bouton Explorer -->
                    <a href="/images" 
                       class="group relative px-10 py-5 glass-effect text-white rounded-2xl font-bold text-lg hover-scale shadow-2xl transition-all duration-300 hover:bg-white/20">
                        <span class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Explorer
                        </span>
                        <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-0 group-hover:opacity-20 transition-opacity"></div>
                    </a>
                </div>

                <!-- Statistiques animées -->
                <div class="grid grid-cols-3 gap-8 mt-16 animate-fadeInUp delay-600">
                    <div class="glass-effect rounded-2xl p-6 hover-scale transition-all duration-300 hover:bg-white/5">
                        <div class="text-4xl font-bold text-white mb-2 animate-count" data-target="10000">0</div>
                        <div class="text-purple-300">Images</div>
                    </div>
                    <div class="glass-effect rounded-2xl p-6 hover-scale transition-all duration-300 hover:bg-white/5">
                        <div class="text-4xl font-bold text-white mb-2 animate-count" data-target="5000">0</div>
                        <div class="text-purple-300">Utilisateurs</div>
                    </div>
                    <div class="glass-effect rounded-2xl p-6 hover-scale transition-all duration-300 hover:bg-white/5">
                        <div class="text-4xl font-bold text-white mb-2 animate-count" data-target="50">0</div>
                        <div class="text-purple-300">Catégories</div>
                    </div>
                </div>

                <!-- Message d'accroche -->
                <div class="mt-12 animate-fadeInUp delay-600">
                    <p class="text-gray-400 text-lg">
                        Commencez votre voyage visuel dès maintenant
                    </p>
                    <div class="flex justify-center mt-4">
                        <div class="w-12 h-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Effet de particules -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="particle" style="top: 20%; left: 15%;"></div>
            <div class="particle" style="top: 60%; left: 80%;"></div>
            <div class="particle" style="top: 40%; left: 40%;"></div>
            <div class="particle" style="top: 80%; left: 20%;"></div>
            <div class="particle" style="top: 30%; left: 70%;"></div>
        </div>
    </div>

    <!-- Styles pour les particules -->
    <style>
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: float 4s ease-in-out infinite;
        }

        .particle:nth-child(2) {
            animation-delay: 0.5s;
            width: 6px;
            height: 6px;
        }

        .particle:nth-child(3) {
            animation-delay: 1s;
            background: rgba(192, 132, 252, 0.4);
        }

        .particle:nth-child(4) {
            animation-delay: 1.5s;
            width: 8px;
            height: 8px;
        }

        .particle:nth-child(5) {
            animation-delay: 2s;
            background: rgba(236, 72, 153, 0.4);
        }

        /* Animation pour le compteur */
        .animate-count {
            transition: all 1s ease-out;
        }

        /* Animation d'entrée pour les boutons */
        @keyframes buttonEntrance {
            0% {
                opacity: 0;
                transform: scale(0.8) translateY(20px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        a[href="/register"], a[href="/images"] {
            animation: buttonEntrance 0.8s ease-out forwards;
        }

        a[href="/register"] {
            animation-delay: 0.8s;
            opacity: 0;
        }

        a[href="/images"] {
            animation-delay: 1s;
            opacity: 0;
        }
    </style>

    <script>
        // Animation du compteur
        document.addEventListener('DOMContentLoaded', function() {
            const counters = document.querySelectorAll('.animate-count');
            
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000; // 2 secondes
                const step = target / (duration / 16); // 60 fps
                let current = 0;
                
                const updateCounter = () => {
                    current += step;
                    if (current < target) {
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target.toLocaleString();
                    }
                };
                
                // Démarrer l'animation après un délai
                setTimeout(updateCounter, 1000);
            });

            // Effet de survol amélioré pour les boutons
            const buttons = document.querySelectorAll('a[href="/register"], a[href="/images"]');
            
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05) translateY(-5px)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1) translateY(0)';
                });
            });
        });
    </script>
</body>
</html>