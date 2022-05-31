<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nome',
        'titulo',
        'descricao',
        'status',
    ];

    protected $casts = [
        'user_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }
}
