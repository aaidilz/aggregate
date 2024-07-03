<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'customer_id';
    protected $incrementing = false;
    protected $table = 'customer';

    protected $fillable = [
        'customer_id',
        'username',
        'password',
        'nama_customer',
        'email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
