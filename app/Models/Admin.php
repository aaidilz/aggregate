<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'admin_id';
    protected $incrementing = false;
    protected $table = 'admin';

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
