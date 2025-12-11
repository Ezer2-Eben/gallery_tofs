<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
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
        'title',
        'description',
        'file_path',
        'file_size',
        'file_type',
        'visibility',
        'category_id',
        'subcategory_id',
        'user_id',
        'created_at',
    ];

    /**
     * Les attributs à caster.
     *
     * @var array
     */
    protected $casts = [
        'file_size' => 'integer',
        'enabled' => 'boolean',
    ];

    /**
     * Relation avec l'utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec la catégorie.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation avec la sous-catégorie.
     */
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    /**
     * Obtenir la taille du fichier formatée.
     */
    public function getFileSizeFormattedAttribute()
    {
        if ($this->file_size) {
            $size = $this->file_size;
            if ($size < 1024) {
                return $size . ' B';
            } elseif ($size < 1048576) {
                return round($size / 1024, 1) . ' KB';
            } else {
                return round($size / 1048576, 1) . ' MB';
            }
        }
        return '0 B';
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
     * Vérifier si l'image est publique.
     */
    public function isPublic()
    {
        return $this->visibility === 'public';
    }

    /**
     * Vérifier si l'image est privée.
     */
    public function isPrivate()
    {
        return $this->visibility === 'private';
    }
}