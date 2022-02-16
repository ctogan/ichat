<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $table = 'events';

    protected $fillable = [
        'event_name',
        'start_date',
        'end_date',
        'min_transaction',
        'day_transaction',
        'created_at',
        'updated_at'
    ];



}
