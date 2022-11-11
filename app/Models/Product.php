<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cantidad',
        'pventa',
        'pcompra',  
        'description',
        'marca',
        
    ];

    public function lotes()
    {
        return $this->hasMany(lote::class);
    }

    public function details()
    {
        return $this->hasMany(detail::class);
    }

    

    
}
