<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewPurchase extends Model
{
    protected $table = 'view_purchase';

    protected $fillable = [
        'customer_id',
        'total',
        'total_saving',
        'transaction_at',
        'created_at',
        'updated_at'
    ];
}
