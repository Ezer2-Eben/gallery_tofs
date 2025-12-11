<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
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
        'category_id',
        'admin_id',
        'created_at',
    ];

    /**
     * Relation avec la catégorie parente.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation avec les images.
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Relation avec l'administrateur qui a créé la sous-catégorie.
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
     * Obtenir le nom complet (catégorie > sous-catégorie).
     */
    public function getFullNameAttribute()
    {
        return $this->category->name . ' > ' . $this->name;
    }
}