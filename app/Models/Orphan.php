<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orphan extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function imagesGallery()
    {
        return $this->hasMany(ImageGallery::class);
    }
    public function payments()
    {
        return $this->hasMany(PaymentOrphan::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
