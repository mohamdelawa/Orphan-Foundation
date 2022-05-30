<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentOrphan extends Model
{
    use HasFactory;
    public function payment()
    {
        return $this->belongsTo(Payment::class,'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
