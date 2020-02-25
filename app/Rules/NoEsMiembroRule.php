<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Collection;

class NoEsMiembroRule implements Rule
{
    private $miembros;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Collection $miembros)
    {
        $this->miembros = $miembros;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !$this->miembros->contains('id', '=', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El usuario ya es miembro de la academia.';
    }
}
