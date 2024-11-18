<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'asaas_id',
        'customer_id',
        'billing_type',
        'due_date',
        'value',
        'status',
        'description'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
