<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'asaas_id',
        'name',
        'email',
        'phone',
        'cpfCnpj',
        'postal_code',
        'address',
        'address_number',
        'complement',
        'province'
    ];

    protected $keyType = 'string';
    public $incrementing = false;
}
