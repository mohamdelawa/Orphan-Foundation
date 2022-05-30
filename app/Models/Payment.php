<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    public function paymentsOrphans()
    {
        return $this->hasMany(PaymentOrphan::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
