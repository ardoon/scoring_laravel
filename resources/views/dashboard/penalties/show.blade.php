@extends('dashboard.layouts.main')

@section('content-dashboard')

    <div class="row d-print-none">
        <div class="col">
            <h2 class="h3">لیست جریمه های <a href="{{ route('members.show', ['member' => $member->id]) }}">{{ $member->firstName . ' ' . $member->lastName }}</a></h2>
        </div>
    </div>

    <h2 class="h3 d-none mt-5 mb-5 d-print-block">لیست جریمه های <a href="{{ route('members.show', ['member' => $member->id]) }}">{{ $member->firstName . ' ' . $member->lastName }}</a></h2>

    <div class="container">

        <div class="row mt-2">
            <div class="col">
                <table class="table public-scores-table mt-4">
                    <thead class="thead-dark">
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
                    <tfoot>
                    <tr class="bg-light">
                        <td colspan="2">کسری فعلی: {{ number_format($current_debt) }} تومان</td>
                        <td colspan="5">مجموع بدهی ها: {{ number_format($penalties_sum) }} تومان</td>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>


    @if(session('message'))
        <alert-message message="{{ session('message') }}"></alert-message>
    @endif

@endsection
