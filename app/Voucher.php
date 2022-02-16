<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';
    protected $fillable = [
        'id',
        'event_id',
        'voucher_code',
        'image',
        'created_at',
        'updated_at'
    ];
}
