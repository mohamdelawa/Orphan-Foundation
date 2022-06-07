<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function imagesGallery()
    {
        return $this->hasMany(ImageGallery::class);
    }
    public function orphans()
    {
        return $this->hasMany(Orphan::class);
    }
    public function typesImage()
    {
        return $this->hasMany(TypeImage::class);
    }
    public function paymentsOrphans()
    {
        return $this->hasMany(PaymentOrphan::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function permissionsUsers()
    {
        return $this->hasMany(PermissionUser::class,'user_id');
    }
    public function permissionsUsersAdd()
    {
        return $this->hasMany(PermissionUser::class,'add_user_id');
    }
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
