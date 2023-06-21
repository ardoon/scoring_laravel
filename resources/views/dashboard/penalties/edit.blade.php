@extends('dashboard.layouts.main')

@section('content-dashboard')

    <dashboard-content-header
        page-title="ویرایش جریمه"
        btn-backward="{{ route('penalties.index') }}">
    </dashboard-content-header>

    <dashboard-form
        class="mt-5"
        form-action="{{ route('penalties.update', ['penalty' => $penalty->id]) }}"
        btn-title="ثبت">

        @csrf
        @method('PUT')

        <div class="form-row">

            <dashboard-form-date
                class="col-lg-4"
                field-label="تاریخ"
                field-name="penalty"
                value-day="{{ old('penaltyDay') ?? $penalty->penaltyDay }}"
                value-month="{{ old('penaltyMonth') ?? $penalty->penaltyMonth }}"
                value-year="{{ old('penaltyYear') ?? $penalty->penaltyYear }}"
                @error('penaltyDay') error="{{ $message }}" @enderror
                @error('penaltyMonth') error="{{ $message }}" @enderror
                @error('penaltyYear') error="{{ $message }}" @enderror>
            </dashboard-form-date>

            <dashboard-form-field
                class="col-lg-4"
                field-label="مبلغ"
                field-type="number"
                field-name="amount"
                field-value="{{ old('amount') ?? $penalty->amount }}"
                @error('amount') error="{{ $message }}" @enderror>
            </dashboard-form-field>

            <dashboard-form-select
                class="col-lg-4"
                field-label="نوع"
                field-name="type"
                :field-items="{{ $selects['type'] }}"
                field-value="{{ old('penalty') ?? $penalty->type }}"
                @error('type') error="{{ $message }}" @enderror>
            </dashboard-form-select>

        </div>

    </dashboard-form>

@endsection
