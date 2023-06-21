@extends('layouts.app')

@section('content')

    <nav id="dashboard-navbar" class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container pr-0">

        <span class="navbar-brand h1 mr-0 pr-0">پلتفرم امتیازدهی تعاونی مسکن دانشگاه فرهنگیان <sub><small
                    style="font-family: Arial;">V 2.0</small></sub></span>

            @can('access-dashboard')
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item {{ (request()->is('members*')) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('members.index') }}">اعضای تعاونی</a>
                    </li>
                    <li class="nav-item {{ (request()->is('payments*')) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('payments.index') }}">پرداخت ها</a>
                    </li>
                    <li class="nav-item {{ (request()->is('penalties*')) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('penalties.index') }}">جریمه ها</a>
                    </li>
                    <li class="nav-item {{ (request()->is('reports*')) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('reports.index') }}">گزارشگیری</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">خروج</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            @endcan

        </div>

    </nav>

    <div class="container{{ $container ?? '' }} main-content mb-md-5">
        @yield('content-dashboard')
    </div>

@endsection
