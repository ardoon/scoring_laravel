@extends('dashboard.layouts.main')

@section('content-dasboard')
    {{ auth()->user()->firstName . ' ' . auth()->user()->lastName }}
@endsection