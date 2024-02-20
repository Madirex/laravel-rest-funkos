<?php

namespace App\Rules;

use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class CategoryNameNotExists
 */
class CategoryNameExists implements Rule
{
    /**
     * Determine if the validation rule passes.
     * @param $attribute atributo
     * @param $value valor
     * @return mixed mixed
     */
    public function passes($attribute, $value)
    {
        return !Category::where('name', 'ILIKE', $value)->exists();
    }

    /**
     * Get the validation error message.
     * @return string string
     */
    public function message()
    {
        return 'La categoría ya existe.';
    }
}
