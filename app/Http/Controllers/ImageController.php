<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    // Liste des images (publiques pour tout le monde)
    public function index()
    {
        // Récupérer TOUTES les images (publiques et privées) pour l'admin
        // OU seulement les publiques pour les non-connectés
        
        if (Auth::check() && Auth::user()->is_admin) {
            // Si admin, voir toutes les images
            $images = Image::with(['category', 'subcategory', 'user'])
                ->latest()
                ->paginate(12);
        } elseif (Auth::check()) {
            // Si utilisateur connecté, voir ses images + images publiques
            $images = Image::with(['category', 'subcategory', 'user'])
                ->where(function($query) {
                    $query->where('visibility', 'public')
                          ->orWhere('user_id', Auth::id());
                })
                ->latest()
                ->paginate(12);
        } else {
            // Si non connecté, voir seulement les images publiques
            $images = Image::with(['category', 'subcategory', 'user'])
                ->where('visibility', 'public')
                ->latest()
                ->paginate(12);
        }
    
        // Récupérer toutes les catégories
        $categories = Category::all();
        
        return view('images.index', compact('images', 'categories'));
    }

    // Formulaire d'ajout
    public function create()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour ajouter une image');
        }
        
        $categories = Category::all();
        return view('images.create', compact('categories'));
    }

    // Stocker une image
    public function store(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour ajouter une image');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:10240', // 10MB max
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'visibility' => 'required|in:public,private',
        ]);

        // Upload de l'image
        $path = $request->file('image')->store('images', 'public');

        // Créer l'image
        $image = Image::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'file_size' => $request->file('image')->getSize(),
            'file_type' => $request->file('image')->getMimeType(),
            'visibility' => $request->visibility,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'user_id' => Auth::id(),
        ]);

        // Log
        DB::table('logs')->insert([
            'action' => 'Upload image: ' . $image->title,
            'user_id' => Auth::id(),
            'created_at' => now(),
        ]);

        return redirect()->route('images.index')
            ->with('success', 'Image téléchargée avec succès');
    }

    // Afficher une image
    public function show(Image $image)
    {
        // Vérifier l'accès : si image privée, seul le propriétaire peut la voir
        if ($image->visibility == 'private' && (!Auth::check() || $image->user_id != Auth::id())) {
            abort(403, 'Cette image est privée');
        }

        return view('images.show', compact('image'));
    }

    // Supprimer une image
    public function destroy(Image $image)
    {
        // Vérifier si l'utilisateur est connecté et est le propriétaire ou admin
        if (!Auth::check()) {
            abort(403, 'Vous devez être connecté');
        }

        if ($image->user_id != Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer cette image');
        }

        // Supprimer le fichier
        Storage::disk('public')->delete($image->file_path);

        // Supprimer de la base
        $image->delete();

        // Log
        DB::table('logs')->insert([
            'action' => 'Suppression image: ' . $image->title,
            'user_id' => Auth::id(),
            'created_at' => now(),
        ]);

        return redirect()->route('images.index')
            ->with('success', 'Image supprimée avec succès');
    }

    // Like une image
    public function like(Image $image)
    {
        $image->increment('likes_count');
        
        return response()->json([
            'success' => true,
            'likes' => $image->likes_count
        ]);
    }
}