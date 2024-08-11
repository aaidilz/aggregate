<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model implements AuthenticatableContract
{
    use HasFactory, HasUuids, Authenticatable;

    protected $primaryKey = 'admin_id';
    public $incrementing = false;
    protected $table = 'admins';

    protected $fillable = [
        'admin_id',
        'username',
        'password',
        'nama_admin',
        'email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
