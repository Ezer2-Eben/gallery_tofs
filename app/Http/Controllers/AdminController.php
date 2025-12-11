<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Image;
use App\Models\Category;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // SUPPRIMEZ CE CONSTRUCTEUR :
    // public function __construct()
    // {
    //     $this->middleware('admin');
    // }

    // Dashboard admin
    public function dashboard()
    {
        // Vérification manuelle si l'utilisateur est admin
        if (auth()->id() != 1) {
            return redirect()->route('dashboard')->with('error', 'Accès administrateur requis');
        }
        
        $stats = [
            'totalUsers' => User::count(),
            'totalImages' => Image::count(),
            'totalCategories' => Category::count(),
            'todayLogs' => Log::whereDate('created_at', today())->count(),
            'newUsers' => User::where('created_at', '>=', now()->subDays(7))
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
            'weeklyStats' => [
                'users' => User::where('created_at', '>=', now()->subDays(7))->count(),
                'images' => Image::where('created_at', '>=', now()->subDays(7))->count(),
            ],
        ];

        return view('admin.dashboard', $stats);
    }

    // Liste des utilisateurs
    public function users()
    {
        // Vérification manuelle
        if (auth()->id() != 1) {
            return redirect()->route('dashboard')->with('error', 'Accès administrateur requis');
        }
        
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    // Activer/désactiver un utilisateur
    public function toggleUser(Request $request, User $user)
    {
        if (auth()->id() != 1) {
            return redirect()->route('dashboard')->with('error', 'Accès administrateur requis');
        }
        
        // Ne pas pouvoir désactiver l'admin (premier utilisateur)
        if ($user->id == 1) {
            return back()->with('error', 'Impossible de désactiver l\'administrateur principal');
        }

        $user->enabled = !$user->enabled;
        $user->save();

        // Log
        DB::table('logs')->insert([
            'action' => ($user->enabled ? 'Activation' : 'Désactivation') . ' utilisateur: ' . $user->username,
            'user_id' => Auth::id(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return back()->with('success', 
            'Utilisateur ' . ($user->enabled ? 'activé' : 'désactivé') . ' avec succès'
        );
    }

    // Liste de toutes les images
    public function images()
    {
        if (auth()->id() != 1) {
            return redirect()->route('dashboard')->with('error', 'Accès administrateur requis');
        }
        
        $images = Image::with(['user', 'category', 'subcategory'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.images.index', compact('images'));
    }

    // Supprimer une image (admin)
    public function destroyImage(Image $image)
    {
        if (auth()->id() != 1) {
            return redirect()->route('dashboard')->with('error', 'Accès administrateur requis');
        }
        
        // Supprimer le fichier physique
        if (file_exists(storage_path('app/public/' . $image->file_path))) {
            unlink(storage_path('app/public/' . $image->file_path));
        }

        // Log avant suppression
        DB::table('logs')->insert([
            'action' => 'Suppression admin image: ' . $image->title . ' (user: ' . $image->user->username . ')',
            'user_id' => Auth::id(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $image->delete();

        return back()->with('success', 'Image supprimée avec succès');
    }

    // Logs
    public function logs()
    {
        if (auth()->id() != 1) {
            return redirect()->route('dashboard')->with('error', 'Accès administrateur requis');
        }
        
        $logs = Log::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
            
        return view('admin.logs.index', compact('logs'));
    }
}