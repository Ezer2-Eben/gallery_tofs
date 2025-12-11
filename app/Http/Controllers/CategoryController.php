<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Afficher la liste des catégories
     */
    public function index()
    {
        // Si aucune catégorie n'existe encore
        if (!Category::exists()) {
            $categories = collect();
        } else {
            $categories = Category::withCount('images')
                ->with(['subcategories' => function($query) {
                    $query->withCount('images');
                }])
                ->orderBy('name')
                ->get();
        }
            
        return view('categories.index', compact('categories'));
    }

    /**
     * Afficher les détails d'une catégorie
     */
    public function show($id)
    {
        // Récupérer la catégorie avec ses relations
        $category = Category::with(['subcategories' => function($query) {
            $query->withCount('images');
        }])->findOrFail($id);
        
        // Compter le nombre d'images dans cette catégorie
        $imageQuery = Image::where('category_id', $category->id);
        
        // Si l'utilisateur n'est pas connecté, seulement les images publiques
        if (!Auth::check()) {
            $imageQuery->where('visibility', 'public');
        } else {
            // Si connecté, voir ses images privées + toutes les images publiques
            $imageQuery->where(function($query) {
                $query->where('visibility', 'public')
                      ->orWhere('user_id', Auth::id());
            });
        }
        
        $images = $imageQuery->with(['user', 'subcategory'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('categories.show', compact('category', 'images'));
    }

    /**
     * Afficher le formulaire de création d'une catégorie (admin seulement)
     */
    public function create()
    {
        // Vérifier si l'utilisateur est admin (premier utilisateur)
        if (Auth::id() != 1) {
            abort(403, 'Accès non autorisé');
        }
        
        return view('admin.categories.create');
    }

    /**
     * Stocker une nouvelle catégorie (admin seulement)
     */
    public function store(Request $request)
    {
        // Vérifier si l'utilisateur est admin
        if (Auth::id() != 1) {
            abort(403, 'Accès non autorisé');
        }
        
        $request->validate([
            'name' => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string',
        ]);
        
        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'admin_id' => Auth::id(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        // Log de création
        DB::table('logs')->insert([
            'action' => 'Création catégorie: ' . $category->name,
            'user_id' => Auth::id(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Catégorie créée avec succès');
    }

    /**
     * Afficher le formulaire d'édition d'une catégorie (admin seulement)
     */
    public function edit(Category $category)
    {
        if (Auth::id() != 1) {
            abort(403, 'Accès non autorisé');
        }
        
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Mettre à jour une catégorie (admin seulement)
     */
    public function update(Request $request, Category $category)
    {
        if (Auth::id() != 1) {
            abort(403, 'Accès non autorisé');
        }
        
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);
        
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        
        // Log de modification
        DB::table('logs')->insert([
            'action' => 'Modification catégorie: ' . $category->name,
            'user_id' => Auth::id(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Catégorie modifiée avec succès');
    }

    /**
     * Supprimer une catégorie (admin seulement)
     */
    public function destroy(Category $category)
    {
        if (Auth::id() != 1) {
            abort(403, 'Accès non autorisé');
        }
        
        // Vérifier s'il y a des images dans cette catégorie
        $imageCount = Image::where('category_id', $category->id)->count();
        
        if ($imageCount > 0) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer cette catégorie car elle contient ' . $imageCount . ' image(s)');
        }
        
        // Supprimer les sous-catégories associées
        Subcategory::where('category_id', $category->id)->delete();
        
        // Log avant suppression
        DB::table('logs')->insert([
            'action' => 'Suppression catégorie: ' . $category->name,
            'user_id' => Auth::id(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        $category->delete();
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Catégorie supprimée avec succès');
    }

    /**
     * API: Récupérer les sous-catégories d'une catégorie (pour AJAX)
     */
    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)
            ->orderBy('name')
            ->get();
            
        return response()->json($subcategories);
    }
}