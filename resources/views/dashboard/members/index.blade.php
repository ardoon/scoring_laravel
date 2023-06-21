@extends('dashboard.layouts.main')

@section('content-dashboard')

    <dashboard-content-header page-title="مدیریت اعضای تعاونی"></dashboard-content-header>

    <members-table></members-table>

@if(session('message'))
    <alert-message message="{{ session('message') }}"></alert-message>
@endif

@endsection
