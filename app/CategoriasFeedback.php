<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriasFeedback extends Model
{
    protected $table = 'categoriasfeedback';
    
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
