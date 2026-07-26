<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'estoque_id',
        'user_id',
        'date',
        'quantidade',
        'status',
    ];

    public function estoque()
    {
        return $this->belongsTo('App\Models\Estoque');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
