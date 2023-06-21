<?php

namespace App\Calculator;

use App\Option;
use App\User;
use App\Penalty as PenaltyModel;
use Carbon\Carbon;

class Penalty
{

    private $member;
    private $payments;
    private $penalties;
    private $member_penalties;
    private $penalties_sum;
    private $isPenaltiesStrict;

    public function __construct(User $member)
    {
        $this->member = $member;
        $this->payments = $member->payments()->orderBy('paymentDate', 'asc')->get();
        $this->penalties = PenaltyModel::orderBy('date', 'asc')->get();
        $option = Option::first();
        $this->isPenaltiesStrict = $option->options['isPenaltiesStrict'];
    }

    public function get($summery = false): array
    {

        if ($this->isPenaltiesStrict) {

            if ($this->memberFirstPayIsAfterFirstPenalty()) {

                $pre_penalties = $this->getPrePenalties();

                $new = $this->calculatePrePenalties($pre_penalties);

            }

        }


        foreach ($this->penalties as $penalty) {

            // Here we get the amount of penalty that admin created it.
            $penalty_amount = $this->getPenaltyAmount($penalty); // 50,000,000

            // Here we get the date of penalty that admin created it
            $penalty_date = new Carbon($penalty->date); // 1397/01/01

            // If member's payments sum amounts till penalty's date are equal or greater than penalty amount, penalty will be escaped
            if ($this->isPenaltyPassed($penalty_date, $penalty_amount)) {
                continue;
            }

            // **** If penalty not passed below codes will be run to calculate penalties ****

            // Define Penalty's general end date
            $penalty_end_date = $this->getPenaltyEndDate($penalty);

            // Add penalty to member's Penalties per each payment till penalty is passed
            $start_date = new carbon($penalty->date);

            foreach ($this->payments as $payment) {

                $payment_date = new Carbon($payment->paymentDate);

                // check if payment wouldn't be out of penalty's date range
                if ($payment_date->gt($penalty_end_date)) {

                    break;

                }

                if ($this->isPenaltyPassed($payment_date, $penalty_amount)) {

                    break;

                } else {

                    $payment_index = $this->getPaymentIndex($payment);

                    $end_date = $this->getEndDate($payment_index);

                    if ($end_date->lt($start_date)) {

                        continue;

                    }

                    if ($end_date->gt($penalty_end_date)) {

                        $end_date = $penalty_end_date;

                    }

                    $count_delay_days = $start_date->diff($end_date)->days;

                    $debt_amount = $this->getDebtAmount($end_date, $penalty_amount);

                    // This will add to penalties summery for show to member
                    $this->penalties_sum += $debt_amount;

                    $current_amount = $this->getCurrentAmount($end_date);

                    $period_penalty_amount = ($count_delay_days * $debt_amount) / 1000;

                    // Add New Penalty to member Penalties
                    $this->addNewPenalty($start_date, $end_date, $count_delay_days, $debt_amount, $period_penalty_amount, $current_amount, $penalty_amount);

                    $start_date = $end_date;

                }

            }

        }

        $current_debt = $this->getCurrentDebt();

        $proportion = $this->getProportion();

        if ($summery)
            return [$this->penalties_sum, $current_debt, $proportion];

        return [$this->member_penalties, $this->penalties_sum, $current_debt, $proportion];

    }

    private function calculatePrePenalties($pre_penalties)
    {
        foreach ($pre_penalties as $penalty) {

        $penalty_amount = $this->getPenaltyAmount($penalty);

            $penalty_date = new Carbon($penalty->date);

            // Start date is for penalty start and End date is for penalty End
            $penalty_start_date = new carbon($penalty->date);

            $penalty_end_date = $this->getPenaltyEndDate($penalty);

            if (count($this->PaymentBetweenPenaltyPeriod($penalty_start_date, $penalty_end_date)) === 0) {

                $count_delay_days = $penalty_start_date->diff($penalty_end_date)->days;

                $debt_amount = $penalty->amount;

                // This will add to penalties summery for show to member
                $this->penalties_sum += $debt_amount;

                $current_amount = 0;

                $period_penalty_amount = ($count_delay_days * $debt_amount) / 1000;

                // Add New Penalty to member Penalties
                $this->addNewPenalty($penalty_start_date, $penalty_end_date, $count_delay_days, $debt_amount, $period_penalty_amount, $current_amount, $penalty_amount);

            } else {

                $paymentBetweenPenaltyPeriod = $this->PaymentBetweenPenaltyPeriod($penalty_start_date, $penalty_end_date);

                foreach ($paymentBetweenPenaltyPeriod as $payment) {

                    $payment_date = new Carbon($payment->paymentDate);

                    // check if payment wouldn't be out of penalty's date range

                    if ($payment_date->gt($penalty_end_date)) {

                        break;

                    }

                    if ($this->isPenaltyPassed($payment_date, $penalty_amount) && $this->getPaymentIndex($payment) !== 0) {

                        break;

                    } else {

                        $payment_index = $this->getPaymentIndex($payment);

                        if ($this->isPenaltyPassed($payment_date, $penalty_amount) && $this->getPaymentIndex($payment) == 0) {

                            $end_date = $payment_date;

                        } else {

                            $end_date = $this->getEndDate($payment_index);

                        }

                        if ($end_date->lt($penalty_start_date)) {

                            continue;

                        }

                        if ($end_date->gt($penalty_end_date)) {

                            $end_date = $penalty_end_date;

                        }

                        $count_delay_days = $penalty_start_date->diff($end_date)->days;

                        $debt_amount = $this->getDebtAmount($end_date, $penalty_amount);

                        // This will add to penalties summery for show to member
                        $this->penalties_sum += $debt_amount;

                        $current_amount = $this->getCurrentAmount($end_date);

                        $period_penalty_amount = ($count_delay_days * $debt_amount) / 1000;

                        // Add New Penalty to member Penalties
                        $this->addNewPenalty($penalty_start_date, $end_date, $count_delay_days, $debt_amount, $period_penalty_amount, $current_amount, $penalty_amount);

                        $penalty_start_date = $end_date;

                    }

                }

            }


        }
    }

    private function getPenaltyAmount($penalty)
    {

        if ($penalty->type === 'meter')
            return $penalty->amount * $this->member->properties['areaMeters'];

        return $penalty->amount;

    }

    private function isPenaltyPassed(Carbon $date, $penalty_amount): bool
    {

        $payments_sum = 0;

        foreach ($this->payments as $payment) {

            $payment_date = new Carbon($payment->paymentDate);

            if ($payment_date->lte($date)) {

                $payments_sum += $payment->paymentAmount;

            } else {

                break;

            }

        }

        if ($payments_sum >= $penalty_amount)
            return true;

        return false;

    }

    private function getPenaltyEndDate($penalty): Carbon
    {
        // check if penalty is last or not

        $current_penalty_index = $this->getPenaltyIndex($penalty);

        if ($this->isPenaltyLastItem($current_penalty_index)) {

            // return now date, penalty is last
            return now();

        } else {

            // return next penalty's date
            return $this->getNextPenaltyDate($current_penalty_index);

        }
    }

    private function getPenaltyIndex($penalty)
    {

        foreach ($this->penalties as $index => $item) {

            if ($item->id === $penalty->id) {

                return $index;

            }

        }

    }

    private function getPaymentIndex($payment)
    {

        foreach ($this->payments as $index => $item) {

            if ($item->id === $payment->id) {

                return $index;

            }

        }

    }

    private function isPenaltyLastItem($current_penalty_index): bool
    {

        if (count($this->penalties) === $current_penalty_index + 1)
            return true;

        return false;
    }

    private function getNextPenaltyDate($current_penalty_index)
    {

        foreach ($this->penalties as $index => $item) {

            if ($index === $current_penalty_index + 1) {

                return new Carbon($item->date);

            }

        }

    }

    private function getDebtAmount(Carbon $date, $penalty_amount): int
    {

        $payments_sum = 0;

        foreach ($this->payments as $payment) {

            $payment_date = new Carbon($payment->paymentDate);

            if ($payment_date->lt($date)) {

                $payments_sum += $payment->paymentAmount;

            } else {

                break;

            }

        }

        return $penalty_amount - $payments_sum;

    }

    private function getCurrentAmount(Carbon $date): int
    {

        $payments_sum = 0;

        foreach ($this->payments as $payment) {

            $payment_date = new Carbon($payment->paymentDate);

            if ($payment_date->lt($date)) {

                $payments_sum += $payment->paymentAmount;

            } else {

                break;

            }

        }

        return $payments_sum;

    }

    private function addNewPenalty(Carbon $start_date, Carbon $end_date, int $count_delay_days, int $debt_amount, float $period_penalty_amount, int $current_amount, int $penalty)
    {

        $this->member_penalties[] = [
            'start' => verta($start_date)->format('Y/n/d'),
            'end' => verta($end_date)->format('Y/n/d'),
            'delay' => $count_delay_days,
            'debt' => $debt_amount,
            'current' => $current_amount,
            'penalty' => $penalty,
            'amount' => $period_penalty_amount
        ];

    }

    private function getEndDate(int $payment_index): Carbon
    {

        if ($this->isPaymentLastItem($payment_index)) {

            return now();

        }

        return $this->getNextPaymentDate($payment_index);

    }

    private function isPaymentLastItem(int $payment_index): bool
    {

        if (count($this->payments) === $payment_index + 1)
            return true;

        return false;

    }

    private function getNextPaymentDate(int $payment_index)
    {
        foreach ($this->payments as $index => $item) {

            if ($index === $payment_index + 1) {

                return new Carbon($item->paymentDate);

            }

        }
    }

    private function getCurrentDebt(): int
    {

//
        $last_penalty = $this->penalties->last();

        $last_penalty_amount = $last_penalty->amount;

        if ($last_penalty->type === 'meter')
            $last_penalty_amount *= $this->member->properties['areaMeters'];


        $payments_amount_sum = 0;

        foreach ($this->payments as $payment) {

            $payments_amount_sum += $payment->paymentAmount;

        }

        $current_debt = $last_penalty_amount - $payments_amount_sum;

        if ($current_debt < 0)
            $current_debt = 0;

        return $current_debt;

    }

    private function memberFirstPayIsAfterFirstPenalty(): bool
    {
        if ($this->getFirstPaymentDate()->gt($this->getFirstPenaltyDate()))
            return true;

        return false;

    }

    public function getFirstPenaltyDate(): Carbon
    {
        return new Carbon(reset($this->penalties)[0]->date);
    }

    public function getFirstPaymentDate(): Carbon
    {
        return new Carbon(reset($this->payments)[0]->paymentDate);
    }

    private function getPrePenalties(): array
    {

        $pre_penalties = [];

        foreach ($this->penalties as $penalty)
        {

            $penalty_date = new Carbon($penalty->date);

            if ($penalty_date->lt($this->getFirstPaymentDate()))
                $pre_penalties[] = $penalty;

        }

        return $pre_penalties;

    }

    public function PaymentBetweenPenaltyPeriod(Carbon $startDate, Carbon $endDate)
    {

        $payments_between_penalty_period = [];

        foreach ($this->payments as $payment) {

            $payment_date = new Carbon($payment->paymentDate);

            if ($payment_date->between($startDate,$endDate)) {

                $payments_between_penalty_period[] = $payment;

            }

        }

        return $payments_between_penalty_period;

    }

    public function getPaymentsSum()
    {
        $paymentsSum = 0;

        foreach ($this->payments as $payment) {

            $paymentsSum += $payment->paymentAmount;

        }

        return $paymentsSum;
    }

    private function getProportion()
    {
        $lastPenalty = $this->penalties[count($this->penalties) - 1];

        $lastPenaltyAmount = $this->getPenaltyAmount($lastPenalty);

        $currentPaymentsSum = $this->getPaymentsSum();

        return round($currentPaymentsSum * 100  / $lastPenaltyAmount, 2);

    }

}
