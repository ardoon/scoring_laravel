<?php

use App\Payment;
use App\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return redirect('/login');

});

Route::get('/vip', function () {

    $users = User::where('extraScore', '>', 0)->get();

    $members = User::all();

    return view('dashboard.members.vip', compact('users', 'members'));

});

Route::post('/vip/', function (\Illuminate\Http\Request $request) {

    $user = User::where('id', $request->userID)->first();
    $user->extraScore = $request->value;
    $user->save();


    return back();

})->name('vip.update');

Route::get('/login-admin', function () {

    return view('auth.login-admin');

})->name('login.admin');

Auth::routes();

Route::get('/home', 'DashboardController@index')->name('home');

Route::get('/option/is-penalties-strict', 'OptionController@isPenaltiesStrict');
Route::post('/option/set-penalties-strict-mode', 'OptionController@setPenaltiesStrictMode');

Route::get('/members/all', 'MemberController@all');
Route::get('/members/select-options', 'MemberController@selectOptions')->name('members.selectOption');
Route::put('/members/{member}/update/password', 'MemberController@changePassword')->name('members.update.password');
Route::resource('members', MemberController::class);

Route::get('/payments/all', 'PaymentController@all');
Route::resource('payments', PaymentController::class);

Route::resource('penalties', PenaltyController::class);

Route::get('/reports/all', 'ReportController@all')->name('reports.all');

Route::resource('reports', ReportController::class);

Route::get('/clients/{client}/score', 'ClientController@score')->name('clients.score');
Route::resource('clients', ClientController::class);



Route::get('transport', function () {

    $con = mysqli_connect("localhost", "root", "", "maskan");
    $result = mysqli_query($con, "SELECT * FROM members");

    $black_list_ID = [
        "3730649965",
        "3732009742",
        "5589832608",
        "5589840724",
        "3732000435",
        "3801215598",
        "3731312557",
        "3732029174",
        "3751170601",
        "3820760611",
        "3730445960",
        "3800159880",
        "3732342867",
        "3732483592",
        "3732348822",
        "3780324873",
        "3731130599",
        "5589430127",
        "55894301277",
        "4959767200",
        "4959892439"
    ];

    while ($member = mysqli_fetch_object($result)) {

        if (in_array($member->ID, $black_list_ID)){
            continue;
        }

        $regDate = explode('/', $member->regDate);

        $properties = [
            'maritalStatus' => $member->marid,
            'countDependants' => $member->takafol,
            'countDependentChildren' => $member->child,
            'sacrifice' => $member->isar,
            'educationDegree' => $member->madrak,
            'frontServicePeriod' => $member->jebheh,
            'cooperativeFounder' => $member->avlyeh,
            'creditLoanPoints' => $member->wam,
            'registeryDay' => $regDate[2],
            'registeryMonth' => $regDate[1],
            'registeryYear' => $regDate[0],
            'employmentYear' => $member->estdmDate,
            'countMeetings' => $member->jalasat,
            'holdingResponsibility' => $member->masol,
            'universityOfficialMembers' => $member->rasmi,
            'teachersScore' => $member->tadris,
            'areaMeters' => $member->metraj,
            'extraScore' => $member->VIP
        ];

        try {

            $mobiles = explode('/', $member->tell);

            $user = User::create([
                'username' => $mobiles[0],
                'password' => $member->ID,
                'firstName' => $member->fName,
                'lastName' => $member->lName,
                'nationalId' => $member->ID,
                'fatherName' => $member->faName,
                'wifeName' => $member->wName,
                'mobile' => $member->tell,
                'address' => $member->adrress,
                'properties' => $properties
            ]);
        } catch (Exception $error) {
            dd($error);
        }

    }

    return true;

});

Route::get('transport/payments', function () {

    $con = mysqli_connect("localhost", "root", "", "maskan");
    $result = mysqli_query($con, "SELECT * FROM fish");

    $black_list_ID = [
        "3730649965",
        "3732009742",
        "5589832608",
        "5589840724",
        "3732000435",
        "3801215598",
        "3731312557",
        "3732029174",
        "3751170601",
        "3820760611",
        "3730445960",
        "3800159880",
        "3732342867",
        "3732483592",
        "3732348822",
        "3780324873",
        "3731130599",
        "5589430127",
        "55894301277",
        "4959767200",
        "4959892439",
        "55895",
        "3801511081",
        "5589979056",
        "3720369749",
        "373234",
        "222222222",
        "3333333",
        "3731996049042"
    ];

    while ($payment = mysqli_fetch_object($result)) {


        if (in_array($payment->ID, $black_list_ID)){
            continue;
        }

        $date = new Verta($payment->date);
        $date = $date->datetime();

        $user = User::where('nationalId', $payment->ID)->first();
        if (!$user)
            dd($payment->ID);

        try {

            $payment = Payment::create([
                'paymentNo' => $payment->fishNo,
                'paymentDate' => $date,
                'paymentAmount' => $payment->fishCost,
                'paymentPayer' => $user->id
            ]);

        } catch (\Exception $error) {
            dd($error);
        }

    }

    return true;

});
