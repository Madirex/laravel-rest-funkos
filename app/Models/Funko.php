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

    public static $IMAGE_DEFAULT = 'default.jpg';
    protected $fillable = ['name', 'image', 'description', 'price', 'stock', 'category_name', 'active'];

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

    /**
     * Busca por nombre de Funko
     * @param $query mixed consulta
     * @param $search string búsqueda
     * @return mixed mixed
     */
    public function scopeSearch($query, $search)
    {
        return $query->whereRaw('LOWER(name) LIKE ?', ["%" . strtolower($search) . "%"]);
        // ->orWhereRaw('LOWER(category_name) LIKE ?', ["%" . strtolower($search) . "%"]);
    }
}
