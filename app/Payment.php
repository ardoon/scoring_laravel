<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'paymentNo',
        'paymentDate',
        'paymentAmount',
        'paymentPayer',
    ];

    public function payer()
    {
        return $this->belongsTo('App\User', 'paymentPayer');
    }
}
