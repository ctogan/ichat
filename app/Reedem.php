<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reedem extends Model
{
    protected $table = 'reedems';
    protected $fillable = [
        'id',
        'customer_id',
        'voucher_id',
        'image',
        'status',
        'created_at',
        'updated_at'
    ];
}
