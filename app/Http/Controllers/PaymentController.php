<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Payment;
use App\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Hekmatinasser\Verta\Verta;

class PaymentController extends Controller
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
        return view('dashboard.payments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('dashboard.payments.create');
    }

    public function all()
    {

        $payments = Payment::with('payer')->orderBy('id', 'desc')->paginate(20);

        foreach($payments as $payment) {
            $payment['payerFullName'] = $payment->payer['firstName'] . ' ' . $payment->payer['lastName'];
            $payment['payerId'] = $payment->payer['id'];
            $payment['paymentDate'] = Verta::instance($payment->paymentDate)->format('Y/n/j');
        }

        return response()->json($payments);

    }

    public function makeDate($request): \DateTime
    {
        $year = $request->paymentYear;
        $month = $request->paymentMonth;
        $day = $request->paymentDay;

        return Verta::createJalaliDate($year, $month, $day)->datetime();
    }

    /**
     * Display the specified resource.
     *
     * @param User $payment
     * @return Application|Factory|View
     */
    public function show(User $payment)
    {

        $member = $payment;

        $payments = $member->payments()->orderBy('paymentDate', 'desc')->get();

        $payments_sum = 0;

        foreach($payments as $payment) {
            $payment['paymentDate'] = Verta::instance($payment->paymentDate)->format('Y/n/j');
            $payments_sum += $payment->paymentAmount;
        }

        return view('dashboard.payments.show', compact('member', 'payments', 'payments_sum'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePaymentRequest $request
     * @return RedirectResponse
     */
    public function store(StorePaymentRequest $request): RedirectResponse
    {

        $paymentDate = $this->makeDate($request);

        try {

            $payment = Payment::create([
                'paymentNo' => $request->paymentNo,
                'paymentDate' => $paymentDate,
                'paymentAmount' => $request->paymentAmount,
                'paymentPayer' => $request->paymentPayer
            ]);

        } catch (\Exception $error) {
            return back()->with('message', $error);
        }

        return redirect()->route('payments.index')->with('message', 'رسید پرداخت با موفقیت ثبت شد');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Payment $payment
     * @return Application|Factory|View
     */
    public function edit(Payment $payment)
    {

        $jalali_date = Verta($payment->paymentDate);

        $payment['paymentDay'] = $jalali_date->day;
        $payment['paymentMonth'] = $jalali_date->month;
        $payment['paymentYear'] = $jalali_date->year;

        return view('dashboard.payments.edit', compact('payment'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorePaymentRequest $request
     * @param Payment $payment
     * @return RedirectResponse
     */
    public function update(StorePaymentRequest $request, Payment $payment): RedirectResponse
    {

        $paymentDate = $this->makeDate($request);

        try {

                $payment = $payment->update([
                    'paymentNo' => $request->paymentNo,
                    'paymentDate' => $paymentDate,
                    'paymentAmount' => $request->paymentAmount,
                    'paymentPayer' => $request->paymentPayer
                ]);

        } catch (\Exception $error) {
            return back()->with('message', $error);
        }

        return redirect()->route('payments.index')->with('message', 'رسید پرداخت با موفقیت بروزرسانی شد');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Payment $payment
     * @return RedirectResponse
     */
    public function destroy(Payment $payment): RedirectResponse
    {

        try {
            $payment->delete();
        } catch (Exception $error) {
            return back()->with('message', $error);
        }

        return redirect()->route('payments.index')->with('message', 'رسید پرداخت با موفقیت حذف شد');

    }
}
