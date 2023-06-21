@extends('dashboard.layouts.main')

@section('content-dashboard')

    <dashboard-content-header page-title="لیست جریمه ها"></dashboard-content-header>

    <div class="row mt-5">
        <div class="col">
            <a href="{{ route('penalties.create') }}" class="btn btn-dark float-left mr-2">افزودن جریمه جدید</a>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col">
            <table class="table custom-row-color">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">تاریخ اعمال</th>
                    <th scope="col">مبلغ تعیین شده</th>
                    <th scope="col">نوع جریمه</th>
                    <th scope="col" class="icon-column">حذف</th>
                    <th scope="col" class="icon-column">ویرایش</th>
                </tr>
                </thead>
                @if(count($penalties) > 0)

                <tbody>

                    @foreach($penalties as $index=>$penalty)
                    <tr>
                        <th scope="row">{{ ++$index }}</th>
                        <td>{{ $penalty->date }}</td>
                        <td>{{ number_format($penalty->amount) }}</td>
                        <td>{{ $penalty->type }}</td>

                        <td class="icon-column">
                            <form action="{{ route('penalties.destroy', ['penalty' => $penalty->id]) }}" method="post">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn p-0 m-0">
                                    <span class="fa fa-trash icon-table"></span>
                                </button>

                            </form>
                        </td>

                        <td class="icon-column">
                            <a class="nav-link p-0 m-0" href="{{ route('penalties.edit', [ 'penalty' => $penalty->id ]) }}">
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
        </div>
    </div>

        @if(session('message'))
            <alert-message message="{{ session('message') }}"></alert-message>
    @endif

@endsection
