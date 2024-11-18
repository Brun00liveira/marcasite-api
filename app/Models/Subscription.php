<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'asaas_id',
        'customer_id',
        'billing_type',
        'value',
        'cycle',
        'status'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
