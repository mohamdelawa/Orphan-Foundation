<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageGallery extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
    public function orphan()
    {
        return $this->belongsTo(Orphan::class, 'id');
    }
    public function typeImage()
    {
        return $this->belongsTo(TypeImage::class, 'id');
    }
}
