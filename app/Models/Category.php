<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Indique si le modèle doit avoir des timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'admin_id',
        'created_at',
    ];

    /**
     * Relation avec les sous-catégories.
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    /**
     * Relation avec les images.
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Relation avec l'administrateur qui a créé la catégorie.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Obtenir la date de création formatée.
     */
    public function getCreatedAtFormattedAttribute()
    {
        if ($this->created_at) {
            try {
                return \Carbon\Carbon::parse($this->created_at)->format('d/m/Y H:i');
            } catch (\Exception $e) {
                return 'Date inconnue';
            }
        }
        return 'Date inconnue';
    }

    /**
     * Obtenir le nombre total d'images dans la catégorie (y compris les sous-catégories).
     */
    public function getTotalImagesAttribute()
    {
        $categoryImages = $this->images()->count();
        $subcategoryImages = 0;
        
        foreach ($this->subcategories as $subcategory) {
            $subcategoryImages += $subcategory->images()->count();
        }
        
        return $categoryImages + $subcategoryImages;
    }
}