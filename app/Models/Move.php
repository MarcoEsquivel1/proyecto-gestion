<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    use HasFactory;

    protected $fillable = [
       'date',
       'monto',
       'tipo'
    ];

    public function details()
    {
        return $this->hasMany(detail::class);
    }
}
