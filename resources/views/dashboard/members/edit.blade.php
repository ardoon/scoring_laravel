@extends('dashboard.layouts.main')

@section('content-dashboard')

    <dashboard-content-header
        page-title="ویرایش {{ $member->firstName . ' ' . $member->lastName }}"
        btn-backward="{{ route('members.index') }}">
    </dashboard-content-header>

    <tabs-member-edit @if( session('activeTab') ) old-active-tab="{{ session('activeTab') }}" @endif>

        <template v-slot:update-info>

            <dashboard-form
                class="mt-5"
                form-action="{{ route('members.update', ['member' => $member->id]) }}"
                btn-title="بروزرسانی">

                @csrf
                @method('PUT')

                <p class="h6 mt-5 mb-4"><i class="fa fa-id-card"></i> اطلاعات عمومی</p>


                {{--    First Name //// Last Name    --}}
                <div class="form-row">

                    <dashboard-form-field
                        class="col-md-6"
                        field-label="نام"
                        field-type="text"
                        field-name="firstName"
                        field-value="{{ old('firstName') ?? $member->firstName }}"
                        @error('firstName') error="{{ $message }}" @enderror>
                    </dashboard-form-field>

                    <dashboard-form-field
                        class="col-md-6"
                        field-label="نام خانوادگی"
                        field-type="text"
                        field-name="lastName"
                        field-value="{{ old('lastName') ?? $member->lastName }}"
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
                        field-value="{{ old('nationalId') ?? $member->nationalId }}"
                        @error('nationalId') error="{{ $message }}" @enderror>
                    </dashboard-form-field>

                    <dashboard-form-field
                        class="col-md-6"
                        field-label="نام پدر"
                        field-type="text"
                        field-name="fatherName"
                        field-value="{{ old('fatherName') ?? $member->fatherName }}"
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
                        field-value="{{ old('wifeName') ?? $member->wifeName }}"
                        @error('wifeName') error="{{ $message }}" @enderror>
                    </dashboard-form-field>

                    <dashboard-form-field
                        class="col-md-6"
                        field-label="شماره همراه"
                        hint="مثال: 0918xxxxx18/0933xxxxx56 با / شماره ها را جدا کنید"
                        field-type="text"
                        field-name="mobile"
                        field-value="{{ old('mobile') ?? $member->mobile }}"
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
                        field-value="{{ old('address') ?? $member->address }}"
                        @error('address') error="{{ $message }}" @enderror>
                    </dashboard-form-field>

                    <dashboard-form-select
                        class="col-md-6"
                        field-label="متراژ"
                        field-name="areaMeters"
                        :field-items="{{ $selects['Areas'] }}"
                        field-value="{{ old('areaMeters') ?? $member->areaMeters }}"
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
                        field-value="{{ old('maritalStatus') ?? $member->maritalStatus }}"
                        @error('maritalStatus') error="{{ $message }}" @enderror>
                    </dashboard-form-select>

                    <dashboard-form-select
                        class="col-md-6"
                        field-label="تعداد افراد تحت تکفل"
                        field-name="countDependants"
                        :field-items="{{ $selects['CountDependants'] }}"
                        field-value="{{ old('countDependants') ?? $member->countDependants }}"
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
                        field-value="{{ old('countDependentChildren') ?? $member->countDependentChildren }}"
                        @error('countDependentChildren') error="{{ $message }}" @enderror>
                    </dashboard-form-select>

                    <dashboard-form-select
                        class="col-md-6"
                        field-label="امتیاز ایثارگری"
                        hint="جانباز یا خانواده شهدا"
                        field-name="sacrifice"
                        :field-items="{{ $selects['Sacrifice'] }}"
                        field-value="{{ old('sacrifice') ?? $member->sacrifice }}"
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
                        field-value="{{ old('educationDegree') ?? $member->educationDegree }}"
                        @error('educationDegree') error="{{ $message }}" @enderror>
                    </dashboard-form-select>

                    <dashboard-form-select
                        class="col-md-6"
                        field-label="مدت خدمت جبه"
                        field-name="frontServicePeriod"
                        :field-items="{{ $selects['FrontServicePeriod'] }}"
                        field-value="{{ old('frontServicePeriod') ?? $member->frontServicePeriod }}"
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
                        field-value="{{ old('cooperativeFounder') ?? $member->cooperativeFounder }}"
                        @error('cooperativeFounder') error="{{ $message }}" @enderror>
                    </dashboard-form-select>

                    <dashboard-form-select
                        class="col-md-6"
                        field-label="امتیاز وام اعتباری"
                        field-name="creditLoanPoints"
                        :field-items="{{ $selects['CreditLoanPoints'] }}"
                        field-value="{{ old('creditLoanPoints') ?? $member->creditLoanPoints }}"
                        @error('creditLoanPoints') error="{{ $message }}" @enderror>
                    </dashboard-form-select>

                </div>


                {{--    Registery Date //// Employment Year    --}}
                <div class="form-row">

                    <dashboard-form-date
                        class="col-md-6"
                        field-label="تاریخ عضویت"
                        field-name="registery"
                        value-day="{{ old('registeryDay') ?? $member->registeryDay }}"
                        value-month="{{ old('registeryMonth') ?? $member->registeryMonth }}"
                        value-year="{{ old('registeryYear') ?? $member->registeryYear  }}"
                        @error('registeryDay') error="{{ $message }}" @enderror
                        @error('registeryMonth') error="{{ $message }}" @enderror
                        @error('registeryYear') error="{{ $message }}" @enderror>
                    </dashboard-form-date>

                    <dashboard-form-field
                        class="col-md-6"
                        field-label="سال استخدام"
                        field-type="number"
                        field-name="employmentYear"
                        field-value="{{ old('employmentYear') ?? $member->employmentYear  }}"
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
                        field-value="{{ old('countMeetings') ?? $member->countMeetings  }}"
                        @error('countMeetings') error="{{ $message }}" @enderror>
                    </dashboard-form-field>

                    <dashboard-form-field
                        class="col-md-6"
                        field-label="امتیاز تصدی مسئولیت"
                        field-type="text"
                        field-name="holdingResponsibility"
                        field-value="{{ old('holdingResponsibility') ?? $member->holdingResponsibility }}"
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
                        field-value="{{ old('universityOfficialMembers') ?? $member->universityOfficialMembers }}"
                        @error('universityOfficialMembers') error="{{ $message }}" @enderror>
                    </dashboard-form-field>

                    <dashboard-form-field
                        class="col-md-6"
                        field-label="امتیاز تدریس"
                        field-type="text"
                        field-name="teachersScore"
                        field-value="{{ old('teachersScore') ?? $member->teachersScore }}"
                        @error('teachersScore') error="{{ $message }}" @enderror>
                    </dashboard-form-field>

                    <dashboard-form-field
                        class="col-md-6"
                        field-label="امتیاز منفی"
                        field-type="text"
                        field-name="negativeScore"
                        field-value="{{ old('negativeScore') ?? $member->negativeScore ?? 0 }}"
                        @error('negativeScore') error="{{ $message }}" @enderror>
                    </dashboard-form-field>

                </div>

                <template v-slot:extra-buttons>

                    <form action="{{ route('members.destroy', ['member' => $member->id]) }}" method="post">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-outline-danger px-5 float-left ml-2">حذف</button>

                    </form>

                </template>

            </dashboard-form>

        </template>

        <template v-slot:change-password>

            <dashboard-form
                class="mt-5"
                form-action="{{ route('members.update.password', ['member' => $member->id]) }}"
                btn-title="ذخیره گذرواژه">

                @csrf
                @method('PUT')

                <p class="h6 mt-5 mb-4"><i class="fa fa-lock"></i> تغییر گذرواژه</p>

                <div class="form-row">

                    <dashboard-form-field
                        class="col-md-6"
                        field-label="گذرواژه جدید"
                        field-type="password"
                        field-name="password"
                        field-value="{{ old('password') ?? '' }}"
                        @error('password') error="{{ $message }}" @enderror>
                    </dashboard-form-field>

                    <dashboard-form-field
                        class="col-md-6"
                        field-label="تکرار گذرواژه"
                        field-type="password"
                        field-name="password-confirm"
                        field-value="{{ old('password-confirm') ?? '' }}"
                        @error('password-confirm') error="{{ $message }}" @enderror>
                    </dashboard-form-field>

                </div>

                </dashboard-form>

        </template>

    </tabs-member-edit>

    @if(session('message'))
        <alert-message message="{{ session('message') }}"></alert-message>
    @endif

@endsection
