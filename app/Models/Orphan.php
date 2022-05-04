<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orphan extends Model
{
    use HasFactory;
    public function imagesGallery()
    {
        return $this->hasMany(ImageGallery::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
