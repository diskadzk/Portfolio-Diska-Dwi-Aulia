<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Tambahkan field yang ada di migration kamu biar bisa diisi
    protected $fillable = [
        'user_id', 
        'name', 
        'category', 
        'price', 
        'stock', 
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}