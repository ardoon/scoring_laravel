<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenaltyRequest;
use App\Penalty;
use App\User;
use Exception;
use Hekmatinasser\Verta\Verta;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PenaltyController extends Controller
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
        $penalties = Penalty::orderBy('date', 'asc')->get();

        foreach ($penalties as $penalty) {
            $penalty->date = $jalali_date = Verta($penalty->date)->format('Y/n/d');
            $penalty->type = ($penalty->type === 'meter') ? $penalty->type = 'برحسب متراژ' : $penalty->type = 'برحسب موجودی';
        }

        return view('dashboard.penalties.index', compact('penalties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $selects = [
            'type' => json_encode(config('selects.penalties-types'))
        ];

        return view('dashboard.penalties.create', compact('selects'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $penalty
     * @return Application|Factory|View
     */
    public function show(User $penalty)
    {

        $member = $penalty;

        //  ** Get penalty's Debts  **
        $penalties = new \App\Calculator\Penalty($member);
        [$penalties, $penalties_sum, $current_debt, $proportion] = $penalties->get();

        return view('dashboard.penalties.show', compact('member', 'penalties', 'penalties_sum', 'current_debt', 'proportion'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePenaltyRequest $request
     * @return RedirectResponse
     */
    public function store(StorePenaltyRequest $request): RedirectResponse
    {
        $penaltyDate = $this->makeDate($request);

        try {

            $penalty = Penalty::create([
                'date' => $penaltyDate,
                'amount' => $request->amount,
                'type' => $request->type,
            ]);

        } catch (Exception $error) {
            dd($error);
        }

        return redirect()->route('penalties.index')->with('message', 'جریمه با موفقیت ثبت شد');
    }

    public function makeDate($request): \DateTime
    {
        $year = $request->penaltyYear;
        $month = $request->penaltyMonth;
        $day = $request->penaltyDay;

        return Verta::createJalaliDate($year, $month, $day)->datetime();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Penalty $penalty
     * @return Application|Factory|View
     */
    public function edit(Penalty $penalty)
    {
        $selects = [
            'type' => json_encode(config('selects.penalties-types'))
        ];

        $jalali_date = Verta($penalty->date);

        $penalty['penaltyDay'] = $jalali_date->day;
        $penalty['penaltyMonth'] = $jalali_date->month;
        $penalty['penaltyYear'] = $jalali_date->year;

        return view('dashboard.penalties.edit', compact('penalty', 'selects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorePenaltyRequest $request
     * @param Penalty $penalty
     * @return RedirectResponse
     */
    public function update(StorePenaltyRequest $request, Penalty $penalty): RedirectResponse
    {
        $penaltyDate = $this->makeDate($request);

        try {

            $penalty->update([
                'date' => $penaltyDate,
                'amount' => $request->amount,
                'type' => $request->type,
            ]);

        } catch (Exception $error) {
            dd($error);
        }

        return redirect()->route('penalties.index')->with('message', 'جریمه با موفقیت بروزرسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Penalty $penalty
     * @return RedirectResponse
     */
    public function destroy(Penalty $penalty): RedirectResponse
    {
        try {
            $penalty->delete();
        } catch (Exception $error) {
            dd($error);
        }

        return redirect()->route('penalties.index')->with('message', 'جریمه با موفقیت حذف شد');
    }
}
