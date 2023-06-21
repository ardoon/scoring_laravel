@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col col-6">
                <div class="text-center">
                    <a href="{{ route('home') }}" class="mb-3 text-center d-inline-block">بازگشت به پنل</a>
                </div>
                <form action="{{ route('vip.update') }}" method="post">
                    @csrf
                    <input type="text" class="form-control" name="userID" list="members" placeholder="انتخاب عضو"/>
                    <datalist id="members">
                        @foreach($members as $member)
                            <option
                                value="{{ $member->id }}">{{ $member->firstName . ' ' . $member->lastName }}</option>
                        @endforeach
                    </datalist>
                    <input type="text" value="0" name="value" class="form-control mt-2">
                    <input type="submit" value="اعمال" class="btn btn-dark w-100 mt-2 mb-4">
                </form>
                @foreach($users as $user)
                    <p>{{ $user->firstName . ' ' . $user->lastName }} : {{ $user->extraScore }}</p>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>

@endsection
