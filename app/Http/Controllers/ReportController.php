<?php

namespace App\Http\Controllers;

use App\Calculator\General;
use App\Calculator\Payment;
use App\Calculator\Penalty;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class ReportController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');

        $this->middleware('can:access-dashboard');

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('dashboard.reports.index');
    }

    public function all() {

        $members = User::orderBy('id', 'desc')->get();

        foreach ($members as $member) {

            //  ** Get General Scores Sum **
            $properties = new General($member);
            $member->general_scores_sum = $properties->get(true);

            //  ** Get Payment's Amounts & Scores Sum **
            $payments = new Payment($member);
            [$member->sumPaymentsScores, $member->sumPaymentsAmounts] = $payments->get(true);

            //  ** Get penalty's Debts  **
            $penalties = new Penalty($member);
            [$member->penalties_sum, $member->current_debt, $member->proportion] = $penalties->get(true);

            $member->areaMeters = (int)$member->properties['areaMeters'];

            $member->totalScores = $member->general_scores_sum + $member->sumPaymentsScores + $member->extraScore;

        }

        return $members;

    }
}
