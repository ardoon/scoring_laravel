@extends('dashboard.layouts.main')

@section('content-dashboard')

    <dashboard-content-header
        class="d-print-none"
        page-title="{{ $member->firstName . ' ' . $member->lastName }}"
        btn-backward=""
        btn-print-page="true">

        <template>

            <a class="float-left nav-print mr-4"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="fa fa-sign-out"></span> خروج
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </a>

            <a class="float-left nav-print mr-4" href="{{ route('clients.score', auth()->user()) }}">
               دریافت امتیاز
            </a>


        </template>


    </dashboard-content-header>

    <div class="mt-5"></div>

    <div class="row mb-2">

        <div class="col col-12 mb-4"><p class="h5"><i class="fa fa-id-card"></i> اطلاعات عمومی</p></div>

        <div class="col col-12 col-md-6 col-lg-4 mb-3">نام و نام
            خانوادگی: {{ $member->firstName . ' ' . $member->lastName }}</div>
        <div class="col col-12 col-md-6 col-lg-4 mb-3">کدملی: {{ $member->nationalId }}</div>
        <div class="col col-12 col-md-6 col-lg-4 mb-3">نام پدر: {{ $member->fatherName }}</div>
        <div class="col col-12 col-md-6 col-lg-4 mb-3">نام همسر: {{ $member->wifeName }}</div>
        <div class="col col-12 col-md-6 col-lg-4 mb-3">شماره تماس: {{ $member->mobile }}</div>
        <div class="col col-12 col-md-6 col-lg-4 mb-3">متراژ: {{ $member->properties['areaMeters'] }} متری</div>
        <div class="col col-12 mb-3">آدرس: {{ $member->address }}</div>

    </div>

    <div class="row mb-2 mt-5">

        <div class="col col-12 mb-4"><p class="h5"><i class="fa fa-star"></i> مشخصات عمومی</p></div>

        <div class="col-12 col-lg-6">
            <table class="table">
                <tbody>
                <tr>
                    <td>وضعیت تاهل</td>
                    <td>{{ $generalScores['maritalStatus']['title'] }}</td>
                </tr>
                <tr>
                    <td>تعداد اولاد تحت تکفل</td>
                    <td>{{ $generalScores['countDependentChildren']['title'] }}</td>
                </tr>
                <tr>
                    <td>مدرک تحصیلی</td>
                    <td>{{ $generalScores['educationDegree']['title'] }}</td>
                </tr>
                <tr>
                    <td>عضو اولیه تشکیل دهنده تعاونی</td>
                    <td>{{ $generalScores['cooperativeFounder']['title'] }}</td>
                </tr>
                <tr>
                    <td>سال استخدام</td>
                    <td>{{ $generalScores['employmentYear']['title'] }}</td>
                </tr>
                <tr>
                    <td>تصدی مسئولیت</td>
                    <td>{{ $generalScores['holdingResponsibility']['title'] }}</td>
                </tr>
                <tr>
                    <td>تدریس در دانشگاه</td>
                    <td>{{ $generalScores['teachersScore']['title'] }}</td>
                </tr>
                {{--        Duplicated becuase of respondiv        --}}
                <tr class="d-lg-none">
                    <td>تعداد افراد تحت تکفل</td>
                    <td>{{ $generalScores['countDependants']['title'] }}</td>
                </tr>
                <tr class="d-lg-none">
                    <td>ایثارگری، جانبازی ویا عضو خانواده شهدا</td>
                    <td>{{ $generalScores['sacrifice']['title'] }}</td>
                </tr>
                <tr class="d-lg-none">
                    <td>سابقه جبهه</td>
                    <td>{{ $generalScores['frontServicePeriod']['title'] }} ماه</td>
                </tr>
                <tr class="d-lg-none">
                    <td>تاریخ عضویت</td>
                    <td>{{ $generalScores['registryDate']['title'] }}</td>
                </tr>
                <tr class="d-lg-none">
                    <td>تعداد جلسات شرکت کرده</td>
                    <td>{{ $generalScores['countMeetings'] }} جلسه</td>
                </tr>
                <tr class="d-lg-none">
                    <td>امتیاز وام اعتباری</td>
                    <td>{{ $generalScores['creditLoanPoints']['title'] }}</td>
                </tr>
                <tr class="d-lg-none">
                    <td>عضو رسمی دانشگاه</td>
                    <td>{{ $generalScores['universityOfficialMembers']['title'] }}</td>
                </tr>

                </tbody>
            </table>
        </div>

        <div class="col-12 col-lg-6 d-none d-lg-block">
            <table class="table">
                <tbody>
                {{--        Duplicated becuase of respondiv        --}}
                <tr>
                    <td>تعداد افراد تحت تکفل</td>
                    <td>{{ $generalScores['countDependants']['title'] }}</td>
                </tr>
                <tr>
                    <td>ایثارگری، جانبازی ویا عضو خانواده شهدا</td>
                    <td>{{ $generalScores['sacrifice']['title'] }}</td>
                </tr>
                <tr>
                    <td>سابقه جبهه</td>
                    <td>{{ $generalScores['frontServicePeriod']['title'] }} ماه</td>
                </tr>
                <tr>
                    <td>تاریخ عضویت</td>
                    <td>{{ $generalScores['registryDate']['title'] }}</td>
                </tr>
                <tr>
                    <td>تعداد جلسات شرکت کرده</td>
                    <td>{{ $generalScores['countMeetings'] }} جلسه</td>
                </tr>
                <tr>
                    <td>امتیاز وام اعتباری</td>
                    <td>{{ $generalScores['creditLoanPoints']['title']}}</td>
                </tr>
                <tr>
                    <td>عضو رسمی دانشگاه</td>
                    <td>{{ $generalScores['universityOfficialMembers']['title'] }}</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="row mb-2 mt-5">

        <div class="col col-12 mb-4"><p class="h5"><i class="fa fa-money"></i> پرداخت ها</p></div>

        <table class="table public-scores-table">
            <thead>
            <tr>
                <th scope="col" style="width: 5%;">#</th>
                <th scope="col">شماره رسید پرداخت</th>
                <th scope="col">تاریخ پرداخت</th>
                <th scope="col">مبلغ واریزی <small>(تومان)</small></th>
            </tr>
            </thead>
            <tbody>
            @foreach($payments as $index=>$payment)
                <tr>
                    <th scope="row">{{ ++$index }}</th>
                    <td>{{ $payment->paymentNo }}</td>
                    <td>{{ $payment->paymentDate }}</td>
                    <td>{{  number_format($payment->paymentAmount) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    <div class="row mb-2 mt-5">

        <div class="col col-12 mb-4"><p class="h5"><i class="fa fa-remove"></i> جریمه ها</p></div>

        <table class="table public-scores-table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">بازه زمانی</th>
                <th scope="col">موجودی</th>
                <th scope="col">تکلیف</th>
                <th scope="col">کسری</th>
                <th scope="col">تعداد روز ها</th>
                <th scope="col">بدهی <small>(تومان)</small></th>
            </tr>
            </thead>
            <tbody>
            @if($penalties && count($penalties) > 0)
                @foreach($penalties as $index=>$penalty)
                    <tr>
                        <th scope="row">{{ ++$index }}</th>
                        <td>{{ $penalty['start'] }} الی {{ $penalty['end'] }}</td>
                        <td>{{ number_format($penalty['current']) }}</td>
                        <td>{{ number_format($penalty['penalty']) }}</td>
                        <td>{{ number_format($penalty['debt']) }}</td>
                        <td>{{ $penalty['delay'] }} روز</td>
                        <td style="width: 30%;">{{ number_format($penalty['amount']) }}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>

    </div>

    @if(session('message'))
        <alert-message message="{{ session('message') }}"></alert-message>
    @endif

@endsection
