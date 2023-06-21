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
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the specified resource.
     *
     * @param User $client
     * @return Application|Factory|View
     */
    public function show(User $client)
    {

        if (! Gate::allows('access-client', $client)) {
            abort(403);
        }

        $member = $client;

        //  ** Get General Scores   **
        $properties = new General($member);
        [$generalScores, $sumGeneralScores] = $properties->get();

        //  ** Calculate Payments   **
        $payments = new Payment($member);
        [$payments, $sumPaymentsScores, $sumPaymentsAmounts] = $payments->get();

        //  ** Calculate Penalties  **
        $penalties = new Penalty($member);
        [$penalties, $penalties_sum, $current_debt] = $penalties->get();



        return view('dashboard.clients.show', compact('member', 'generalScores', 'sumGeneralScores', 'payments', 'sumPaymentsScores', 'sumPaymentsAmounts', 'penalties', 'penalties_sum', 'current_debt'));
    }

    public function score(User $client)
    {
        return redirect()->route('clients.show', $client->id)->with('message', 'درخواست با موفقیت ثبت شد.');
    }

}
