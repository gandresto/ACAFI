<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class NoEsPresidenteRule implements Rule
{
    private $presidente;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(User $presidente)
    {
        $this->presidente = $presidente;
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
        return $value != $this->presidente->id;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El usuario ya es presidente de la academia.';
    }
}
