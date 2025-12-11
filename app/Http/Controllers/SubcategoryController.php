<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubcategoryController extends Controller
{
    /**
     * Afficher le formulaire de création d'une sous-catégorie
     */
    public function create()
    {
        if (Auth::id() != 1) {
            abort(403, 'Accès non autorisé');
        }
        
        $categories = Category::orderBy('name')->get();
        return view('admin.subcategories.create', compact('categories'));
    }

    /**
     * Stocker une nouvelle sous-catégorie
     */
    public function store(Request $request)
    {
        if (Auth::id() != 1) {
            abort(403, 'Accès non autorisé');
        }
        
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);
        
        // Vérifier si la sous-catégorie existe déjà dans cette catégorie
        $exists = Subcategory::where('category_id', $request->category_id)
            ->where('name', $request->name)
            ->exists();
            
        if ($exists) {
            return redirect()->back()
                ->with('error', 'Cette sous-catégorie existe déjà dans cette catégorie')
                ->withInput();
        }
        
        $subcategory = Subcategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'admin_id' => Auth::id(),
            'created_at' => now(),
        ]);
        
        // Log
        DB::table('logs')->insert([
            'action' => 'Création sous-catégorie: ' . $subcategory->name,
            'user_id' => Auth::id(),
            'created_at' => now(),
        ]);
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Sous-catégorie créée avec succès');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Subcategory $subcategory)
    {
        if (Auth::id() != 1) {
            abort(403, 'Accès non autorisé');
        }
        
        $categories = Category::orderBy('name')->get();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Mettre à jour une sous-catégorie
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        if (Auth::id() != 1) {
            abort(403, 'Accès non autorisé');
        }
        
        $request->validate([
            'name' => 'required|string|max:100|unique:subcategories,name,' . $subcategory->id . ',id,category_id,' . $request->category_id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);
        
        $subcategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);
        
        // Log
        DB::table('logs')->insert([
            'action' => 'Modification sous-catégorie: ' . $subcategory->name,
            'user_id' => Auth::id(),
            'created_at' => now(),
        ]);
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Sous-catégorie modifiée avec succès');
    }

    /**
     * Supprimer une sous-catégorie
     */
    public function destroy(Subcategory $subcategory)
    {
        if (Auth::id() != 1) {
            abort(403, 'Accès non autorisé');
        }
        
        // Vérifier s'il y a des images dans cette sous-catégorie
        $imageCount = $subcategory->images()->count();
        
        if ($imageCount > 0) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer cette sous-catégorie car elle contient ' . $imageCount . ' image(s)');
        }
        
        // Log avant suppression
        DB::table('logs')->insert([
            'action' => 'Suppression sous-catégorie: ' . $subcategory->name,
            'user_id' => Auth::id(),
            'created_at' => now(),
        ]);
        
        $subcategory->delete();
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Sous-catégorie supprimée avec succès');
    }
}