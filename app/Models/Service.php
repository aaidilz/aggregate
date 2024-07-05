<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'service_id';
    public $incrementing = false;
    protected $table = 'services';

    protected $fillable = [
        'service_id',
        'bank_name',
        'serial_number',
        'machine_id',
        'machine_type',
        'service_center',
        'location_name',
        'partner_code',
        'spv_name',
        'fse_name',
        'fsl_name',
    ];

    public function approvals()
    {
        return $this->hasMany(Approval::class, 'service_id', 'service_id');
    }
}
