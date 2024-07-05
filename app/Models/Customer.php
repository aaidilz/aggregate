<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model implements AuthenticatableContract
{
    use HasFactory, HasUuids, Authenticatable;

    protected $primaryKey = 'customer_id';
    public $incrementing = false;
    protected $table = 'customers';

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

    public function approvals()
    {
        return $this->belongsToMany(Approval::class, 'customer_approvals', 'customer_id', 'approval_id');
    }
}
