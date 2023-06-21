@extends('dashboard.layouts.main')

@section('content-dashboard')

    <dashboard-content-header
        page-title="ثبت پرداخت جدید"
        btn-backward="{{ route('payments.index') }}">
    </dashboard-content-header>

    <dashboard-form
        class="mt-5"
        form-action="{{ route('payments.store') }}"
        form-title="ثبت پرداخت جدید"
        btn-title="ثبت">

        @csrf

        <div class="form-row">

            <dashboard-form-field
                class="col-md-6"
                field-label="شماره رسید پرداخت"
                field-type="number"
                field-name="paymentNo"
                field-value="{{ old('paymentNo') ?? '' }}"
                @error('paymentNo') error="{{ $message }}" @enderror>
            </dashboard-form-field>

            <dashboard-form-date
                class="col-md-6"
                field-label="تاریخ پرداخت"
                field-name="payment"
                @if(old('paymentDay')) value-day="{{ old('paymentDay') }}" @endif
                @if(old('paymentDay')) value-month="{{ old('paymentMonth') }}" @endif
                @if(old('paymentDay')) value-year="{{ old('paymentYear') }}" @endif
                @error('paymentDay') error="{{ $message }}" @enderror
                @error('paymentMonth') error="{{ $message }}" @enderror
                @error('paymentYear') error="{{ $message }}" @enderror>
            </dashboard-form-date>

        </div>

        <div class="form-row">

            <dashboard-form-field
                class="col-md-6"
                field-label="مبلغ پرداخت"
                field-type="number"
                field-name="paymentAmount"
                field-value="{{ old('paymentAmount') ?? 0 }}"
                @error('paymentAmount') error="{{ $message }}" @enderror>
            </dashboard-form-field>

            <dashboard-form-select
                class="col-md-6"
                field-label="پرداخت کننده"
                field-name="paymentPayer"
                field-options="members"
                @if(old('paymentPayer')) field-value="{{ old('paymentPayer') }}" @endif
                @if(app('request')->input('payer')) field-value="{{ app('request')->input('payer') }}" @endif
                api="{{ route('members.selectOption') }}"
                @error('paymentPayer') error="{{ $message }}" @enderror>
            </dashboard-form-select>

        </div>

    </dashboard-form>

@endsection
