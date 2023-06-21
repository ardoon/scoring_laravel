@extends('dashboard.layouts.main')

@section('content-dashboard')

    <dashboard-content-header
        page-title="ویرایش پرداخت"
        btn-backward="{{ route('payments.index') }}">
    </dashboard-content-header>

    <dashboard-form
        class="mt-5"
        form-action="{{ route('payments.update', ['payment' => $payment->id]) }}"
        btn-title="ثبت">

        @csrf
        @method('PUT')

        <div class="form-row">

            <dashboard-form-field
                class="col-md-6"
                field-label="شماره رسید پرداخت"
                field-type="number"
                field-name="paymentNo"
                field-value="{{ old('firstName') ?? $payment->paymentNo }}"
                @error('paymentNo') error="{{ $message }}" @enderror>
            </dashboard-form-field>

            <dashboard-form-date
                class="col-md-6"
                field-label="تاریخ پرداخت"
                field-name="payment"
                value-day="{{ old('paymentDay') ?? $payment->paymentDay }}"
                value-month="{{ old('paymentMonth') ?? $payment->paymentMonth }}"
                value-year="{{ old('paymentYear') ?? $payment->paymentYear }}"
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
                field-value="{{ old('paymentAmount') ?? $payment->paymentAmount }}"
                @error('paymentAmount') error="{{ $message }}" @enderror>
            </dashboard-form-field>

            <dashboard-form-select
                class="col-md-6"
                field-label="پرداخت کننده"
                field-name="paymentPayer"
                field-options="members"
                field-value="{{ old('paymentPayer') ?? $payment->paymentPayer }}"
                api="{{ route('members.selectOption') }}"
                @error('paymentPayer') error="{{ $message }}" @enderror>
            </dashboard-form-select>

        </div>

            <template v-slot:extra-buttons>

                <form action="{{ route('payments.destroy', ['payment' => $payment->id]) }}" method="post">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-outline-danger px-5 float-left ml-2">حذف</button>

                </form>

            </template>

    </dashboard-form>

@endsection
