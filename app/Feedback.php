<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['mensaje', 'categoria_id', 'user_id'];

    public function categoria()
    {
        return $this->belongsTo(CategoriasFeedback::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
