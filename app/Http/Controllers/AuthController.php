<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Page d'accueil
    public function welcome()
    {
        return view('welcome');
    }

    // Afficher le formulaire de connexion
    public function showLogin()
    {
        return view('auth.login');
    }

    // Traiter la connexion
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Récupérer l'utilisateur manuellement pour vérifier le statut enabled
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Identifiants incorrects.',
            ]);
        }

        // Vérifier si le compte est activé
        if (!$user->enabled) {
            return back()->withErrors([
                'email' => 'Votre compte est désactivé. Contactez l\'administrateur.',
            ]);
        }

        // Tenter la connexion
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            
            // Log de connexion
            DB::table('logs')->insert([
                'action' => 'Connexion',
                'user_id' => Auth::id(),
                'created_at' => now(),
            ]);

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ]);
    }

    // Afficher le formulaire d'inscription
    public function showRegister()
    {
        return view('auth.register');
    }

    // Traiter l'inscription
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:100|unique:users',
            'email' => 'required|string|email|max:150|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'first_name' => 'nullable|string|max:191',
            'last_name' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|string|in:male,female,other',
        ]);

        // Créer l'utilisateur avec created_at manuel
        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'first_name' => $validated['first_name'] ?? null,
            'last_name' => $validated['last_name'] ?? null,
            'age' => $validated['age'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'enabled' => true,
            'created_at' => now(), // Ajouter created_at manuellement
        ]);

        // Connecter l'utilisateur
        Auth::login($user);

        // Log d'inscription
        DB::table('logs')->insert([
            'action' => 'Inscription',
            'user_id' => $user->id,
            'created_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Compte créé avec succès !');
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}