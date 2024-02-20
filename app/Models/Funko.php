<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Funko
 */
class Funko extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'description', 'price', 'stock', 'category', 'active'];

    /**
     * Oculta los campos
     * @var string[] $hidden
     */
    protected $hidden = [
        'active',
    ];

    /**
     * Convierte en tipos nativos
     * @var string[] $casts
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Relación con la tabla categorías
     * @return mixed mixed
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
