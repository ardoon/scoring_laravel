<?php

namespace App\Calculator;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Hekmatinasser\Verta\Verta;

class Payment
{

    private $member;

    private $payments;

    private $sum_payments_scores;

    private $sum_payments_amounts;

    public function __construct(User $member)
    {

        $this->member = $member;

        $this->payments = $this->member->payments()->orderBy('paymentDate', 'asc')->get();

    }

    public function get($summery = false): array
    {

        foreach ($this->payments as $payment){
            $date = new verta($payment->paymentDate);
            $payment->paymentDateOriginal = $payment->paymentDate;
            $payment->paymentDate = $date->format('Y/n/d');
            $payment->countDays = $date->diffDays();
            $payment->score = ( $date->diffDays() * $payment->paymentAmount) / 100000000;
            $this->sum_payments_scores += $payment->score;
            $this->sum_payments_amounts += $payment->paymentAmount;
        }
        
        if(array_key_exists('negativeScore', $this->member->properties)) {
            $this->sum_payments_scores -= $this->member->properties['negativeScore'];
        }

        if ($summery)
            return [(int)$this->sum_payments_scores, (int)$this->sum_payments_amounts];

        return [$this->payments, $this->sum_payments_scores, $this->sum_payments_amounts];
    }

}
