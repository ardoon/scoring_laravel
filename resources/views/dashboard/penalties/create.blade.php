@extends('dashboard.layouts.main')

@section('content-dashboard')

    <dashboard-content-header
        page-title="ثبت جریمه جدید"
        btn-backward="{{ route('penalties.index') }}">
    </dashboard-content-header>

    <dashboard-form
        class="mt-5"
        form-action="{{ route('penalties.store') }}"
        btn-title="ثبت">

        @csrf

        <div class="form-row">

            <dashboard-form-date
                class="col-lg-4"
                field-label="تاریخ"
                field-name="penalty"
                @if(old('penaltyDay')) value-day="{{ old('penaltyDay') }}" @endif
                @if(old('penaltyMonth')) value-month="{{ old('penaltyMonth') }}" @endif
                @if(old('penaltyYear')) value-year="{{ old('penaltyYear') }}" @endif
                @error('penaltyDay') error="{{ $message }}" @enderror
                @error('penaltyMonth') error="{{ $message }}" @enderror
                @error('penaltyYear') error="{{ $message }}" @enderror>
            </dashboard-form-date>

            <dashboard-form-field
                class="col-lg-4"
                field-label="مبلغ"
                field-type="number"
                field-name="amount"
                field-value="{{ old('amount') ?? 0 }}"
                @error('amount') error="{{ $message }}" @enderror>
            </dashboard-form-field>

            <dashboard-form-select
                class="col-lg-4"
                field-label="نوع"
                field-name="type"
                :field-items="{{ $selects['type'] }}"
                @if(old('type')) field-value="{{ old('type') }}" @endif
                @error('type') error="{{ $message }}" @enderror>
            </dashboard-form-select>

        </div>

    </dashboard-form>

@endsection
