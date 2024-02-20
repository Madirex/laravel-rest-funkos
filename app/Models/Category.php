<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Category
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Relación con la tabla Funkos
     * @return mixed mixed
     */
    public function funkos()
    {
        return $this->hasMany(Funko::class);
    }

}
