@extends('dashboard.layouts.main')

@section('content-dashboard')

    <div class="row d-print-none">
        <div class="col">
            <h2 class="h3">لیست پرداخت های <a href="{{ route('members.show', ['member' => $member->id]) }}">{{ $member->firstName . ' ' . $member->lastName }}</a></h2>
        </div>
    </div>

    <h2 class="h3 d-none mt-5 mb-5 d-print-block">لیست پرداخت های <a href="{{ route('members.show', ['member' => $member->id]) }}">{{ $member->firstName . ' ' . $member->lastName }}</a></h2>

    <div class="container">

        <div class="row mt-5 d-print-none">
            <div class="col">
                <span class="page-info" style="vertical-align: -10px;padding-right: 15px;">مجموع پرداخت ها: {{ number_format($payments_sum) }}</span>
                <a href="{{ route('payments.create', ['payer' => $member->id]) }}" class="btn btn-dark float-left mr-2">افزودن پرداخت جدید</a>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
                <table class="table custom-row-color">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">شماره رسید پرداخت</th>
                        <th scope="col">تاریخ پرداخت</th>
                        <th scope="col">مبلغ پرداخت</th>
                        <th scope="col" class="icon-column d-print-none">ویرایش</th>
                    </tr>
                    </thead>
                    @if(count($payments) > 0)
                        <tbody>
                        @foreach($payments as $index=>$payment)
                        <tr>
                            <th scope="row">{{ ++$index }}</th>
                            <td>{{ $payment->paymentNo }}</td>
                            <td>{{ $payment->paymentDate }}</td>
                            <td>{{ number_format($payment->paymentAmount) }}</td>
                            <td class="icon-column d-print-none">
                                <a class="nav-link p-0 m-0" href="{{ route('payments.edit', ['payment' => $payment->id]) }}">
                                    <span class="fa fa-edit icon-table"></span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    @else
                        <tbody>
                        <tr>
                            <td colspan="6" class="text-center">هیچ رسید پرداختی تا به اکنون ذخیره نشده است</td>
                        </tr>
                        </tbody>
                    @endif
                </table>
                <span class="page-info d-none d-print-block" style="vertical-align: -10px;padding-right: 15px;">مجموع پرداخت ها: {{ number_format($payments_sum) }}</span>
            </div>
        </div>

    </div>


    @if(session('message'))
        <alert-message message="{{ session('message') }}"></alert-message>
    @endif

@endsection
