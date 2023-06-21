@extends('dashboard.layouts.main')

@section('content-dashboard')

    <dashboard-content-header page-title="لیست پرداخت ها"></dashboard-content-header>

    <payments-table
        create-page-url="{{ route('payments.create') }}">
    </payments-table>

    @if(session('message'))
        <alert-message message="{{ session('message') }}"></alert-message>
    @endif

@endsection
