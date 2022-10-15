<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lote extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'fechaExp',
        'product_id'        
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
