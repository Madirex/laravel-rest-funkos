<?php

namespace App\Rules;

use App\Models\Category;
use App\Models\Funko;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class CategoryNameNotExists
 */
class FunkoNameExists implements Rule
{
    /**
     * Determine if the validation rule passes.
     * @param $attribute atributo
     * @param $value valor
     * @return mixed mixed
     */
    public function passes($attribute, $value)
    {
        return !Funko::where('name', 'ILIKE', $value)->exists();
    }

    /**
     * Get the validation error message.
     * @return string string
     */
    public function message()
    {
        return 'El Funko ya existe.';
    }
}
