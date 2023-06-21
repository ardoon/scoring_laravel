<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'nationalId' => 'required|max:255',
            'fatherName' => 'required|max:255',
            'wifeName' => 'max:255',
            'mobile' => 'required|max:255',
            'address' => 'required|max:255',
            'maritalStatus' => 'required',
            'countDependants' => 'required',
            'countDependentChildren' => 'required',
            'sacrifice' => 'required',
            'educationDegree' => 'required',
            'frontServicePeriod' => 'required',
            'cooperativeFounder' => 'required',
            'creditLoanPoints' => 'required',
            'registeryDay' => 'required',
            'registeryMonth' => 'required',
            'registeryYear' => 'required',
            'employmentYear' => 'required',
            'countMeetings' => 'required',
            'holdingResponsibility' => 'required',
            'universityOfficialMembers' => 'required',
            'teachersScore' => 'required',
            'areaMeters' => 'required',
            'negativeScore' => 'required'
        ];
    }
}
