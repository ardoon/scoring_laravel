<?php

namespace App\Calculator;

use App\User;
use Hekmatinasser\Verta\Verta;

class General
{

    private $member;

    public function __construct(User $member)
    {
        $this->member = $member;
    }

    public function get($summery = false)
    {
        $general_scores = [
            'maritalStatus' =>
                $this->getProperty('maritalStatus', $this->member->properties['maritalStatus']),
            'countDependentChildren' =>
                $this->getProperty('countDependentChildren', $this->member->properties['countDependentChildren']),
            'educationDegree' =>
                $this->getProperty('educationDegree', $this->member->properties['educationDegree']),
            'cooperativeFounder' =>
                $this->getProperty('cooperativeFounder', $this->member->properties['cooperativeFounder']),
            'employmentYear' =>
                $this->getProperty('employmentYear', $this->member->properties['employmentYear']),
            'holdingResponsibility' =>
                $this->getProperty('holdingResponsibility', $this->member->properties['holdingResponsibility']),
            'teachersScore' =>
                $this->getProperty('teachersScore', $this->member->properties['teachersScore']),
            'countDependants' =>
                $this->getProperty('countDependants', $this->member->properties['countDependants']),
            'sacrifice' =>
                $this->getProperty('sacrifice', $this->member->properties['sacrifice']),
            'frontServicePeriod' =>
                $this->getProperty('frontServicePeriod', $this->member->properties['frontServicePeriod']),
            'registryDate' =>
                $this->getProperty('registryDate', [$this->member->properties['registeryDay'], $this->member->properties['registeryMonth'], $this->member->properties['registeryYear']]),
            'countMeetings' => $this->member->properties['countMeetings'],
            'universityOfficialMembers' =>
                $this->getProperty('universityOfficialMembers', $this->member->properties['universityOfficialMembers']),
            'creditLoanPoints' =>
                $this->getProperty('creditLoanPoints', $this->member->properties['creditLoanPoints']),
        ];

        $general_scores_sum = $this->getGeneralScoresSum($general_scores);

        if ($summery)
            return $general_scores_sum;

        return [$general_scores, $general_scores_sum];

    }

    public function getProperty($key, $value)
    {

        switch ($key) {

            case 'maritalStatus' :
                $maritalStatus = config('selects.marital-status');
                return ['title' => $maritalStatus[$value], 'score' => $value];
                break;

            case 'countDependentChildren' :
                $countDependentChildren = config('selects.dependent-children');
                return ['title' => $countDependentChildren[$value], 'score' => $value];
                break;

            case 'educationDegree' :
                $educationDegree = config('selects.education-degree');
                return ['title' => $educationDegree[$value], 'score' => $value];
                break;

            case 'cooperativeFounder' :
                $cooperativeFounder = config('selects.cooperative-founder');
                return ['title' => $cooperativeFounder[$value], 'score' => $value];
                break;

            case 'employmentYear' :
                $score = verta()->year - $value;
                if ($score > 30)
                    $score = 30;

                return ['title' => $value, 'score' => $score];
                break;

            case 'holdingResponsibility' :
                $holdingResponsibility = $value === "0" ? 'خیر' : 'بلی';
                return ['title' => $holdingResponsibility, 'score' => $value];
                break;

            case 'teachersScore' :
                $teachersScore = $value === "0" ? 'خیر' : 'بلی';
                return ['title' => $teachersScore, 'score' => $value];
                break;

            case 'countDependants' :
                $countDependants = config('selects.count-dependants');
                return ['title' => $countDependants[$value], 'score' => $value];
                break;

            case 'sacrifice' :
                $sacrifice = config('selects.sacrifice');
                return ['title' => $sacrifice[$value], 'score' => $value];
                break;

            case 'frontServicePeriod' :
                $frontServicePeriod = config('selects.front-service-period');
                return ['title' => $frontServicePeriod[$value], 'score' => $value];
                break;

            case 'registryDate' :
                $registryDate = Verta::createJalaliDate($value[2], $value[1], $value[0]);
                $registryDateScore = round($registryDate->diffMonths() / 3) * 0.5;
                return ['title' => $registryDate->format('Y/n/d'), 'score' => $registryDateScore];
                break;

            case 'universityOfficialMembers' :
                $universityOfficialMembers = ($value === "0") ? 'خیر' : 'بلی';
                return ['title' => $universityOfficialMembers, 'score' => $value];
                break;

            case 'creditLoanPoints' :
                $creditLoanPoints = config('selects.credit-loan-points');
                return ['title' => $creditLoanPoints[$value], 'score' => $value];
                break;

        }

        return false;
    }

    private function getGeneralScoresSum($general_scores): float
    {

        $general_scores_sum = 0;

        foreach ($general_scores as $single) {

            if (gettype($single) == 'string'){

                $general_scores_sum += $single;

            } else {

                $general_scores_sum += $single['score'];

            }

        }

        return $general_scores_sum;

    }

}