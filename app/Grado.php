<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grado extends Model
{
    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
