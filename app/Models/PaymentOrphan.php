<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentOrphan extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function payment()
    {
        return $this->belongsTo(Payment::class,'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
