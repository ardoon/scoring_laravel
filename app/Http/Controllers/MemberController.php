<?php

namespace App\Http\Controllers;

use App\Calculator\General;
use App\Calculator\Payment;
use App\Penalty as PenaltyModel;
use \App\User;
use \App\Calculator\Penalty;
use Carbon\Carbon;
use Exception;
use Hekmatinasser\Verta\Verta;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \App\Http\Requests\StoreMemberRequest;
use Illuminate\View\View;

class MemberController extends Controller
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
        return view('dashboard.members.index');
    }

    public function selectOptions()
    {

        $users = User::get(['id', 'firstName', 'lastName']);

        $userArray = [];

        foreach ($users as $user) {
            $userArray[$user->id] = $user->firstName . ' ' . $user->lastName;
        }

        return response($userArray);

    }

    public function all()
    {
        return User::orderBy('id', 'desc')->get(['id', 'firstName', 'lastName', 'nationalId']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {

        $selects = $this->getSelectOptionsFromConfigFile([
            'areas',
            'marital-status',
            'count-dependants',
            'dependent-children',
            'sacrifice',
            'education-degree',
            'front-service-period',
            'cooperative-founder',
            'credit-loan-points'
        ], 'selects');

        return view('dashboard.members.create', compact('selects'));

    }

    public function getSelectOptionsFromConfigFile($slugs, $prefix): array
    {
        $selects = [];

        foreach ($slugs as $slug) {
            $key = str_replace('-', '', ucwords($slug, '-'));
            $config_key = $prefix . '.' . $slug;
            $selects[$key] = json_encode(config($config_key));
        }

        return $selects;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMemberRequest $request
     * @return RedirectResponse
     */
    public function store(StoreMemberRequest $request): RedirectResponse
    {
        $properties = $this->getProperties($request);

        try {

            $mobiles = explode('/', $request->mobile);

            $user = User::create([
                'username' => $mobiles[0],
                'password' => $request->nationalId,
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'nationalId' => $request->nationalId,
                'fatherName' => $request->fatherName,
                'wifeName' => $request->wifeName,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'properties' => $properties
            ]);
        } catch (Exception $error) {
            return back()->with('message', $error);
        }

        return redirect()->route('members.index')->with('message', 'عضو جدید با موفقیت ثبت شد');

    }

    /**
     * Display the specified resource.
     *
     * @param User $member
     * @return Application|Factory|View
     */
    public function show(User $member)
    {
        //  ** Get General Scores   **
        $properties = new General($member);
        [$generalScores, $sumGeneralScores] = $properties->get();

        //  ** Calculate Payments   **
        $payments = new Payment($member);
        [$payments, $sumPaymentsScores, $sumPaymentsAmounts] = $payments->get();

        //  ** Calculate Penalties  **
        $penalties = new Penalty($member);
        [$penalties, $penalties_sum, $current_debt, $proportion] = $penalties->get();

        return view('dashboard.members.show', compact('member', 'generalScores', 'sumGeneralScores', 'payments', 'sumPaymentsScores', 'sumPaymentsAmounts', 'penalties', 'penalties_sum', 'current_debt', 'proportion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $member
     * @return Application|Factory|View
     */
    public function edit(User $member)
    {
        $selects = $this->getSelectOptionsFromConfigFile([
            'areas',
            'marital-status',
            'count-dependants',
            'dependent-children',
            'sacrifice',
            'education-degree',
            'front-service-period',
            'cooperative-founder',
            'credit-loan-points'
        ], 'selects');

        foreach ($member->properties as $key => $property) {
            $member[$key] = $property;
        }
        return view('dashboard.members.edit', compact('member', 'selects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreMemberRequest $request
     * @param User $member
     * @return RedirectResponse
     */
    public function update(StoreMemberRequest $request, User $member): RedirectResponse
    {
        $properties = $this->getProperties($request);

        try {

            $mobiles = explode('/', $request->mobile);

            $member->update([
                'username' => $mobiles[0],
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'nationalId' => $request->nationalId,
                'fatherName' => $request->fatherName,
                'wifeName' => $request->wifeName,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'properties' => $properties
            ]);

        } catch (Exception $error) {
            return back()->with('message', $error);
        }

        return back()->with('message', $member->firstName . ' ' . $member->lastName . ' با موفقیت بروزرسانی شد');
    }

    public function changePassword(Request $request, User $member): RedirectResponse
    {
        $validated = Validator::make($request->all(), [
            'password' => 'required|min:8|max:25|',
        ]);

        if ($validated->fails()) {
            return back()
                ->withErrors($validated)
                ->withInput()
                ->with('activeTab', 'change-password');
        }

        try {

            $member->update([
                'password' => $request->password,
            ]);

        } catch (Exception $error) {
            return back()->with('message', $error);
        }

        return back()->with('message', 'گذرواژه ' . $member->firstName . ' ' . $member->lastName . ' با موفقیت بروزرسانی شد');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $member
     * @return RedirectResponse
     */
    public function destroy(User $member): RedirectResponse
    {

        try {
            $member->delete();
        } catch (Exception $error) {
            dd($error);
        }

        return redirect()->route('members.index')->with('message', 'کاربر با موفقیت حذف شد');

    }

    /**
     * @param $request
     * @return array
     */
    public function getProperties($request): array
    {
        $properties = [
            'maritalStatus' => $request->maritalStatus,
            'countDependants' => $request->countDependants,
            'countDependentChildren' => $request->countDependentChildren,
            'sacrifice' => $request->sacrifice,
            'educationDegree' => $request->educationDegree,
            'frontServicePeriod' => $request->frontServicePeriod,
            'cooperativeFounder' => $request->cooperativeFounder,
            'creditLoanPoints' => $request->creditLoanPoints,
            'registeryDay' => $request->registeryDay,
            'registeryMonth' => $request->registeryMonth,
            'registeryYear' => $request->registeryYear,
            'employmentYear' => $request->employmentYear,
            'countMeetings' => $request->countMeetings,
            'holdingResponsibility' => $request->holdingResponsibility,
            'universityOfficialMembers' => $request->universityOfficialMembers,
            'teachersScore' => $request->teachersScore,
            'areaMeters' => $request->areaMeters,
            'negativeScore' => $request->negativeScore
        ];
        return $properties;
    }

}
