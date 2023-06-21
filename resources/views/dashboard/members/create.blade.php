@extends('dashboard.layouts.main')

@section('content-dashboard')

    <dashboard-content-header
        page-title="ثبت عضو جدید"
        btn-backward="{{ route('members.index') }}">
    </dashboard-content-header>

    <dashboard-form
        class="mt-5"
        form-action="{{ route('members.store') }}"
        form-title="ثبت عضو جدید"
        btn-title="ثبت">

        @csrf


        <p class="h6 mt-5 mb-4"><i class="fa fa-id-card"></i> اطلاعات عمومی</p>


        {{--    First Name //// Last Name    --}}
        <div class="form-row">

            <dashboard-form-field
                class="col-md-6"
                field-label="نام"
                field-type="text"
                field-name="firstName"
                field-value="{{ old('firstName') ?? '' }}"
                @error('firstName') error="{{ $message }}" @enderror>
            </dashboard-form-field>

            <dashboard-form-field
                class="col-md-6"
                field-label="نام خانوادگی"
                field-type="text"
                field-name="lastName"
                field-value="{{ old('lastName') ?? '' }}"
                @error('lastName') error="{{ $message }}" @enderror>
            </dashboard-form-field>

        </div>


        {{--    National Id //// Father Name    --}}
        <div class="form-row">

            <dashboard-form-field
                class="col-md-6"
                field-label="کدملی"
                field-type="text"
                field-name="nationalId"
                field-value="{{ old('nationalId') ?? '' }}"
                @error('nationalId') error="{{ $message }}" @enderror>
            </dashboard-form-field>

            <dashboard-form-field
                class="col-md-6"
                field-label="نام پدر"
                field-type="text"
                field-name="fatherName"
                field-value="{{ old('fatherName') ?? '' }}"
                @error('fatherName') error="{{ $message }}" @enderror>
            </dashboard-form-field>

        </div>


        {{--    Wife Name //// Mobile    --}}
        <div class="form-row">

            <dashboard-form-field
                class="col-md-6"
                field-label="نام همسر"
                field-type="text"
                field-name="wifeName"
                field-value="{{ old('wifeName') ?? '' }}"
                @error('wifeName') error="{{ $message }}" @enderror>
            </dashboard-form-field>

            <dashboard-form-field
                class="col-md-6"
                field-label="شماره همراه"
                hint="مثال: 0918xxxxx18/0933xxxxx56 با / شماره ها را جدا کنید"
                field-type="text"
                field-name="mobile"
                field-value="{{ old('mobile') ?? '' }}"
                @error('mobile') error="{{ $message }}" @enderror>
            </dashboard-form-field>

        </div>


        {{--    Address //// Area Meters    --}}
        <div class="form-row">

            <dashboard-form-field
                class="col-md-6"
                field-label="آدرس"
                field-type="text"
                field-name="address"
                field-value="{{ old('address') ?? '' }}"
                @error('address') error="{{ $message }}" @enderror>
            </dashboard-form-field>

            <dashboard-form-select
                class="col-md-6"
                field-label="متراژ"
                field-name="areaMeters"
                :field-items="{{ $selects['Areas'] }}"
                @if(old('areaMeters')) field-value="old('areaMeters')" @endif
                @error('areaMeters') error="{{ $message }}" @enderror>
            </dashboard-form-select>

        </div>


        <p class="h6 mt-5 mb-4"><i class="fa fa-newspaper-o"></i> فاکتورهای امتیازدهی</p>


        {{--    Marital Status //// Count Dependants     --}}
        <div class="form-row">

            <dashboard-form-select
                class="col-md-6"
                field-label="وضعیت تاهل"
                field-name="maritalStatus"
                :field-items="{{ $selects['MaritalStatus'] }}"
                @if(old('maritalStatus')) field-value="old('maritalStatus')" @endif
                @error('maritalStatus') error="{{ $message }}" @enderror>
            </dashboard-form-select>

            <dashboard-form-select
                class="col-md-6"
                field-label="تعداد افراد تحت تکفل"
                field-name="countDependants"
                :field-items="{{ $selects['CountDependants'] }}"
                @if(old('countDependants')) field-value="old('countDependants')" @endif
                @error('countDependants') error="{{ $message }}" @enderror>
            </dashboard-form-select>

        </div>


        {{--    Count Children //// Sacrifice Point    --}}
        <div class="form-row">

            <dashboard-form-select
                class="col-md-6"
                field-label="تعداد اولاد تحت تکفل"
                field-name="countDependentChildren"
                :field-items="{{ $selects['DependentChildren'] }}"
                @if(old('countDependentChildren')) field-value="old('countDependentChildren')" @endif
                @error('countDependentChildren') error="{{ $message }}" @enderror>
            </dashboard-form-select>

            <dashboard-form-select
                class="col-md-6"
                field-label="امتیاز ایثارگری"
                hint="جانباز یا خانواده شهدا"
                field-name="sacrifice"
                :field-items="{{ $selects['Sacrifice'] }}"
                @if(old('sacrifice')) field-value="old('sacrifice')" @endif
                @error('sacrifice') error="{{ $message }}" @enderror>
            </dashboard-form-select>

        </div>


        {{--    Education Degree //// Front Service Period    --}}
        <div class="form-row">

            <dashboard-form-select
                class="col-md-6"
                field-label="مدرک"
                field-name="educationDegree"
                :field-items="{{ $selects['EducationDegree'] }}"
                @if(old('educationDegree')) field-value="old('educationDegree')" @endif
                @error('educationDegree') error="{{ $message }}" @enderror>
            </dashboard-form-select>

            <dashboard-form-select
                class="col-md-6"
                field-label="مدت خدمت جبه"
                field-name="frontServicePeriod"
                :field-items="{{ $selects['FrontServicePeriod'] }}"
                @if(old('frontServicePeriod')) field-value="old('frontServicePeriod')" @endif
                @error('frontServicePeriod') error="{{ $message }}" @enderror>
            </dashboard-form-select>

        </div>


        {{--    Cooperative Founder //// Credit Loan Points    --}}
        <div class="form-row">

            <dashboard-form-select
                class="col-md-6"
                field-label="اعضای اولیه تشکیل دهنده تعاونی مسکن"
                field-name="cooperativeFounder"
                :field-items="{{ $selects['CooperativeFounder'] }}"
                @if(old('cooperativeFounder')) field-value="old('cooperativeFounder')" @endif
                @error('cooperativeFounder') error="{{ $message }}" @enderror>
            </dashboard-form-select>

            <dashboard-form-select
                class="col-md-6"
                field-label="امتیاز وام اعتباری"
                field-name="creditLoanPoints"
                :field-items="{{ $selects['CreditLoanPoints'] }}"
                @if(old('creditLoanPoints')) field-value="old('creditLoanPoints')" @endif
                @error('creditLoanPoints') error="{{ $message }}" @enderror>
            </dashboard-form-select>

        </div>


        {{--    Registery Date //// Employment Year    --}}
        <div class="form-row">

            <dashboard-form-date
                class="col-md-6"
                field-label="تاریخ عضویت"
                field-name="registery"
                @if(old('registeryDay')) value-day="{{ old('registeryDay') }}" @endif
                @if(old('registeryMonth')) value-month="{{ old('registeryMonth') }}" @endif
                @if(old('registeryYear')) value-year="{{ old('registeryYear') }}" @endif
                @error('registeryDay') error="{{ $message }}" @enderror
                @error('registeryMonth') error="{{ $message }}" @enderror
                @error('registeryYear') error="{{ $message }}" @enderror>
            </dashboard-form-date>

            <dashboard-form-field
                class="col-md-6"
                field-label="سال استخدام"
                field-type="number"
                field-name="employmentYear"
                field-value="{{ old('employmentYear') ?? '1372' }}"
                @error('employmentYear') error="{{ $message }}" @enderror>
            </dashboard-form-field>

        </div>


        {{--    Count Meetings //// Holding Responsibility    --}}
        <div class="form-row">

            <dashboard-form-field
                class="col-md-6"
                field-label="تعداد جلسات شرکت کرده"
                field-type="text"
                field-name="countMeetings"
                field-value="{{ old('countMeetings') ?? '' }}"
                @error('countMeetings') error="{{ $message }}" @enderror>
            </dashboard-form-field>

            <dashboard-form-field
                class="col-md-6"
                field-label="امتیاز تصدی مسئولیت"
                field-type="text"
                field-name="holdingResponsibility"
                field-value="{{ old('holdingResponsibility') ?? '' }}"
                @error('holdingResponsibility') error="{{ $message }}" @enderror>
            </dashboard-form-field>

        </div>


        {{--    University Official Members //// Teachers Score    --}}
        <div class="form-row">

            <dashboard-form-field
                class="col-md-6"
                field-label="امتیاز اعضای رسمی دانشگاه"
                field-type="text"
                field-name="universityOfficialMembers"
                field-value="{{ old('universityOfficialMembers') ?? '' }}"
                @error('universityOfficialMembers') error="{{ $message }}" @enderror>
            </dashboard-form-field>

            <dashboard-form-field
                class="col-md-6"
                field-label="امتیاز تدریس"
                field-type="text"
                field-name="teachersScore"
                field-value="{{ old('teachersScore') ?? '' }}"
                @error('teachersScore') error="{{ $message }}" @enderror>
            </dashboard-form-field>

            <dashboard-form-field
                        class="col-md-6"
                        field-label="امتیاز منفی"
                        field-type="text"
                        field-name="negativeScore"
                        field-value="{{ old('negativeScore') ?? '' }}"
                        @error('negativeScore') error="{{ $message }}" @enderror>
                    </dashboard-form-field>

        </div>

    </dashboard-form>

@endsection
