<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail extends Model
{
    use HasFactory;

    protected $fillable = [
       'move_id',
       'unidades',
       'precio',
       'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function move()
    {
        return $this->belongsTo(Move::class);
    }

}
