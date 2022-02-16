<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseTransaction extends Model
{
    protected $table = 'purchase_transactions';

    protected $fillable = [
        'customer_id',
        'total_spent',
        'total_saving',
        'transaction_at',
        'created_at',
        'updated_at'
    ];
}
