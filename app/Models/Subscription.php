<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id',
        'customer_id',
        'billing_type',
        'value',
        'status',
        'due_date',
        'payment_date',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
