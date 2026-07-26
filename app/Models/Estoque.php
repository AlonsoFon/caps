<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Estoque extends Model
{
    use HasFactory, SoftDeletes;
    public $slug = 'estoques';
    protected $fillable = [
        'produto_id',
        'lote',
        'validade',
        'quantidade',    
    ];

    public function produto()
    {
        return $this->belongsTo('App\Models\Produto');
    }
}
