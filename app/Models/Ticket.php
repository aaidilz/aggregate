<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'ticket_id';
    public $incrementing = false;
    protected $table = 'tickets';

    protected $fillable = [
        'ticket_id',
        'customer_id',
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

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function approval()
    {
        return $this->hasMany(Approval::class, 'ticket_id', 'ticket_id');
    }
}
