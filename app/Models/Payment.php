<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Payment extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'payments';
    // protected $primaryKey = 'id';
    protected $fillable = [
        'card_number','expiry', 'cvc','card_holder','user_id','amount'
    ];
}
