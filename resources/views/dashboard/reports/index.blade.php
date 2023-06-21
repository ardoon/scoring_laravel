@extends('dashboard.layouts.main', ['container' => '-fluied mx-3 p-1'])

@section('content-dashboard')

    <dashboard-content-header page-title="گزارش" class="p-3"></dashboard-content-header>

    <reports-table
        create-page-url="{{ route('reports.all') }}">
    </reports-table>

    @if(session('message'))
        <alert-message message="{{ session('message') }}"></alert-message>
    @endif

@endsection
