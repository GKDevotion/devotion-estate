
@extends('frontend.layouts.master')

@section('title')
Employee Create - Admin Panel
@endsection

@section('styles')
    <link href="{{ asset('public/backend/assets/css/select2.min.css') }}" rel="stylesheet" />
    <style>
        .page-title-area:before {
            height: 50px;
        }
    </style>
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area p-4">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title text-center">Complete <b>{{$personInfo->first_name}} {{$personInfo->last_name}}</b> Registration Process</h4>
            </div>
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body pb-0">

                <form action="{{ route('complete-register', $personInfo->id) }}" method="POST" autocomplete="off" id="employeeForm" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <span class="get-continent-list-url d-none">{{url('api/get-continent-list')}}</span>
                        <span class="get-country-list-url d-none">{{url('api/get-country-list')}}</span>
                        <span class="get-state-list-url d-none">{{url('api/get-state-list')}}</span>
                        <span class="get-city-list-url d-none">{{url('api/get-city-list')}}</span>
                        <span class="get-company-list-url d-none">{{url('api/get-company-list')}}</span>
                        <span class="get-department-list-url d-none">{{url('api/get-department-list')}}</span>
                        <span class="get-social-media-platform-url d-none">{{url('api/get-social-media-platform')}}</span>
                        <span class="get-position-list-url d-none">{{url('api/get-child-position-list')}}</span>
                        <span class="get-illness-list-url d-none">{{url('api/get-illness-list')}}</span>

                        <div class="accordion" id="accordionEmployeeHistory">
                            <div class="card">
                                <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseBasicInformation" aria-expanded="true">     
                                    <span class="title">1. Basic Information </span>
                                    <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                </div>

                                <div id="collapseBasicInformation" class="collapse show" data-parent="#accordionEmployeeHistory">
                                    <div class="card-body">
                                        
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="first_name">First Name <span class="text-error">*</span></label>
                                                <input type="text" class="form-control mb-2" data-required="yes" id="first_name" name="first_name" placeholder="First Name" value="{{$personInfo->first_name}}" disabled>
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="middle_name">Middle Name <span class="text-error">*</span></label>
                                                <input type="text" class="form-control mb-2" data-required="yes" id="middle_name" name="middle_name" placeholder="Middle Name" value="{{$personInfo->middle_name}}" disabled>
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="last_name">Last Name <span class="text-error">*</span></label>
                                                <input type="text" class="form-control mb-2" data-required="yes" id="last_name" name="last_name" placeholder="Last Name" value="{{$personInfo->last_name}}" disabled>
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="email_id">Email ID <span class="text-error">*</span></label>
                                                <input type="text" class="form-control mb-2" data-required="yes" id="email_id" name="email_id" placeholder="Email ID" value="{{$personInfo->email_id}}" disabled>
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="gender">Gender <span class="text-error">*</span></label>
                                                <select name="gender" id="gender" class="form-control mb-2" data-required="yes" disabled>
                                                    <option value="0" {{$personInfo->gender == 0 ? 'selected' : ''}}>Select Gender</option>
                                                    <option value="1" {{$personInfo->gender == 1 ? 'selected' : ''}}>Male</option>
                                                    <option value="2" {{$personInfo->gender == 2 ? 'selected' : ''}}>Fe Male</option>
                                                    <option value="3" {{$personInfo->gender == 3 ? 'selected' : ''}}>Trans</option>
                                                </select>
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="personal_mobile_number">Mobile Number <span class="text-error">*</span></label>
                                                <input type="text" class="form-control mb-2" data-required="yes" id="personal_mobile_number" name="personal_mobile_number" placeholder="Mobile Number" value="{{$personInfo->personal_mobile_number}}" disabled>
                                                <div class="error text-error"></div>
                                            </div>

                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseJobInformation" aria-expanded="false">
                                    <span class="title">2. Job Information</span>
                                    <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                </div>

                                <div id="collapseJobInformation" class="collapse" data-parent="#accordionEmployeeHistory">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <label class="mb-0" for="industry_id">Industry <span class="text-error">*</span></label>
                                                <select name="industry_id" id="industry_id" class="form-control industry-id get-company-list" data-id="company_id" data-required="yes" disabled>
                                                    <option value="0">Select Industry</option>
                                                    @foreach ($industryArr as $ar)
                                                        <option value="{{ $ar->id }}" {{$personInfo->industry_id ?? 0 == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <label class="mb-0" for="company_id">Company <span class="text-error">*</span></label>
                                                <select name="company_id" id="company_id" class="form-control company-id get-department-list" data-id="department_id" data-required="yes" disabled>
                                                    <option value="0">Select Company</option>
                                                    @foreach ($companyArr as $ar)
                                                        <option value="{{ $ar->id }}" {{$personInfo->company_id == $ar->id ?? 0 ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <label class="mb-0" for="department_id">Department <span class="text-error">*</span></label>
                                                <select name="department_id" id="department_id" class="form-control department-id" data-required="yes" disabled>
                                                    <option value="0">Select Department</option>
                                                    @foreach ($departmentArr as $ar)
                                                        <option value="{{ $ar->id }}" {{$personInfo->department_id ?? 0 == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 mb-2">
                                                <label class="mb-0" for="job_role_id">Job Role <span class="text-error">*</span></label>
                                                <select name="job_role_id" id="job_role_id" class="form-control job_role-id get-position-list" data-id="position_id" data-required="yes" disabled>
                                                    <option value="0">Select Job Role Type</option>
                                                    @foreach ($jobRoleArr as $ar)
                                                        <option value="{{ $ar->id }}" {{$selectParentJob->parent->id ?? 0 == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 mb-2">
                                                <label class="mb-0" for="position_id">Position <span class="text-error">*</span></label>
                                                <select name="position_id" id="position_id" class="form-control" data-required="yes" disabled>
                                                    <option value="0">Select Position</option>
                                                    @foreach ($positionArr as $ar)
                                                        <option value="{{ $ar->id }}" {{$personInfo->position_id ?? 0 == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <label class="mb-0" for="employee_type_id">Employee Type <span class="text-error">*</span></label>
                                                <select name="employee_type_id" id="employee_type_id" class="form-control employee-type-id" data-required="yes" disabled>
                                                    <option value="0">Select Employee Type</option>
                                                    @foreach ($employeeTypeArr as $ar)
                                                        <option value="{{ $ar->id }}" {{$personInfo->personal_information->employee_type_id ?? 0 == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <label class="mb-0" for="contract_start_date">Contract start date <span class="text-error">*</span></label>
                                                <input type="date" class="form-control contractual" disabled data-required="yes" id="contract_start_date" name="contract_start_date" value="{{$personInfo->personal_information->contract_start_date ?? '' }}">
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <label class="mb-0" for="contract_end_date">Contract end date <span class="text-error">*</span></label>
                                                <input type="date" class="form-control contractual" disabled data-required="yes" id="contract_end_date" name="contract_end_date" value="{{$personInfo->personal_information->contract_end_date ?? ''}}">
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <label class="mb-0" for="joining_date">Joining date <span class="text-error">*</span></label>
                                                <input type="date" class="form-control" data-required="yes" id="joining_date" name="joining_date" value="{{$personInfo->personal_information->joining_date ?? ''}}" disabled>
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <label class="mb-0" for="hire_date">Hire date <span class="text-error">*</span></label>
                                                <input type="date" class="form-control" data-required="yes" id="hire_date" name="hire_date" value="{{$personInfo->personal_information->hire_date ?? ''}}" disabled>
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <label class="mb-0" for="terminate_date">Terminate date</label>
                                                <input type="date" class="form-control" id="terminate_date" name="terminate_date" value="{{$personInfo->personal_information->terminate_date ?? ''}}">
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <label class="mb-0" for="payment_frequency_id">Payment Frequency <span class="text-error">*</span></label>
                                                <select name="payment_frequency_id" id="payment_frequency_id" class="form-control payment-frequency-id" data-required="yes" disabled>
                                                    <option value="0">Select Employee Type</option>
                                                    @foreach ($payFrequencyArr as $ar)
                                                        <option value="{{ $ar->id }}" {{$personInfo->personal_information->payment_frequency_id ?? 0 == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="error text-error"></div>
                                            </div>

                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <label class="mb-0" for="shift_id">Shift Type <span class="text-error">*</span></label>
                                                <select name="shift_id" id="shift_id" class="form-control shift-id" data-required="yes" disabled>
                                                    <option value="0">Select Shift Type</option>
                                                    @foreach ($shiftArr as $ar)
                                                        <option value="{{ $ar->id }}" {{$personInfo->shift_id ?? 0 == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="error text-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseBenefitInformation" aria-expanded="false">
                                    <span class="title">3. Benefit Information</span>
                                    <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                </div>
                                <div id="collapseBenefitInformation" class="collapse" data-parent="#accordionEmployeeHistory">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="basic_salary">Basic Salary</label>
                                                <input type="text" class="form-control mb-2" id="basic_salary" name="basic_salary" placeholder="Basic Salary" value="{{$personInfo->personal_information->basic_salary ?? '' }}" disabled>
                                            </div>

                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="gross_salary">Gross Salary</label>
                                                <input type="text" class="form-control mb-2" id="gross_salary" name="gross_salary" placeholder="Gross Salary" value="{{$personInfo->personal_information->gross_salary ?? '' }}" disabled>
                                            </div>
                                            
                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="transport_allowance">Transport Allowance</label>
                                                <input type="text" class="form-control mb-2" id="transport_allowance" name="transport_allowance" placeholder="Transport Allowance" value="{{$personInfo->personal_information->transport_allowance ?? '' }}" disabled>
                                            </div>
                                            
                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="transport_benefit">Transport Benefit</label>
                                                <input type="text" class="form-control mb-2" id="transport_benefit" name="transport_benefit" placeholder="Transport Benefit" value="{{$personInfo->personal_information->transport_benefit ?? '' }}" disabled>
                                            </div>

                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="medical_allowance">Medical Benefit</label>
                                                <input type="text" class="form-control mb-2" id="medical_allowance" name="medical_allowance" placeholder="Medical Benefit" value="{{$personInfo->personal_information->medical_allowance ?? '' }}" disabled>
                                            </div>

                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="family_allowance">Family Benefit</label>
                                                <input type="text" class="form-control mb-2" id="family_allowance" name="family_allowance" placeholder="Family Benefit" value="{{$personInfo->personal_information->family_allowance ?? '' }}" disabled>
                                            </div>

                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="monthly_hour">Monthly Work Hour</label>
                                                <input type="number" class="form-control mb-2" id="monthly_hour" name="monthly_hour" placeholder="Monthly Work Hour" value="{{$personInfo->personal_information->monthly_hour ?? '' }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header collapsed" data-toggle="collapse" data-target="#collapsePersonalInformation" aria-expanded="false">
                                    <span class="title">4. Personal Information</span>
                                    <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                </div>

                                <div id="collapsePersonalInformation" class="collapse" data-parent="#accordionEmployeeHistory">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-xl-4">
                                                <label class="mb-0" for="avtar">Avtar <span class="text-error">*</span></label>
                                                <input type="file" class="avtar" data-default-file="{{url( 'storage/'.$personInfo->avtar )}}" id="avtar" name="avtar" accept="image/jpg, image/jpeg, image/png" data-required="yes" >
                                                @if($errors->has('avtar'))
                                                    <div class="error">{{ $errors->first('avtar') }}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-lg-8 col-xl-8">
                                                <div class="row">

                                                    <div class="col-md-6 col-sm-12 mb-2">
                                                        <label class="mb-0" for="religion_id">Religion <span class="text-error">*</span></label>
                                                        <select name="religion_id" id="religion_id" class="form-control religion-id mb-2" data-required="yes" >
                                                            <option value="0">Select Religion</option>
                                                            @foreach ($religionArr as $ar)
                                                                <option value="{{ $ar->id }}" {{$personInfo->religion_id == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error text-error"></div>
                                                    </div>
                                                    
                                                    <div class="col-md-6 col-sm-12 mb-2">
                                                        <label class="mb-0" for="birth_date">Birth Date <span class="text-error">*</span></label>
                                                        <input type="date" class="form-control mb-2" id="birth_date" name="birth_date" placeholder="Birth Date" value="{{$personInfo->birth_date}}" data-required="yes" >
                                                        <div class="error text-error"></div>
                                                    </div>
                                                    
                                                    <div class="col-md-6 col-sm-12 mb-2">
                                                        <label class="mb-0" for="marital_status">Marital Status</label>
                                                        <select name="marital_status" id="marital_status" class="form-control marital-status" data-required="yes" >
                                                            <option value="0">Select Marital Status</option>
                                                            @foreach ($maritalStatusArr as $ar)
                                                                <option value="{{ $ar->id }}" {{$personInfo->personal_information->marital_status_id ?? 0 == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error text-error"></div>
                                                    </div>

                                                    <div class="col-md-6 col-sm-12 mb-2">
                                                        <label class="mb-0" for="blood_group">Blood Group <span class="text-error">*</span></label>
                                                        <input type="text" class="form-control" id="blood_group" name="blood_group" placeholder="First Name" value="{{$personInfo->personal_information->blood_group ?? ''}}" data-required="yes" >
                                                        <div class="error text-error"></div>
                                                    </div>

                                                    <div class="col-md-6 col-sm-12 mb-2">
                                                        <label class="mb-0" for="parent_illness">Parent Illness</label>
                                                        <select name="parent_illness" id="parent_illness" class="form-control parent-illness-id get-illness-list" data-id="illness_id" data-required="yes" >
                                                            <option value="0">Select Parent Illness</option>
                                                            @foreach ($illnessArr as $ar)
                                                                <option value="{{ $ar->id }}" {{$selectParentIllness->parent_id ?? 0 == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error text-error"></div>
                                                    </div>

                                                    <div class="col-md-6 col-sm-12 mb-2">
                                                        <label class="mb-0" for="illness_id">Illness</label>
                                                        <select name="illness_id" id="illness_id" class="form-control" data-required="yes" >
                                                            <option value="0">Select Illness</option>
                                                            @foreach ($childIllnessArr as $ar)
                                                                <option value="{{ $ar->id }}" {{$personInfo->personal_information->health_condition_id ?? 0 == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error text-error"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <fieldset>
                                            <div id="personal_permanent_address_container">
                                                <div class="row permanent-address">
                                                    <div class="col-md-4 col-sm-12">
                                                        <label class="mb-0" for="address">Address <span class="text-error">*</span></label>
                                                        <textarea name="address" id="address" class="form-control address" rows="9" placeholder="Address" data-required="yes" >{{$personInfo->employee_address->address ?? ''}}</textarea>
                                                        <div class="error text-error"></div>
                                                    </div>

                                                    <div class="col-md-8 col-sm-12">
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-12">
                                                                <label class="mb-0" for="permanent_address_continent_id">Continent <span class="text-error">*</span></label>
                                                                <select name="continent_id" id="permanent_address_continent_id" class="form-control get-country-list continent-id" data-id="permanent_address_country_id" data-required="yes">
                                                                    <option value="0">Select Continent</option>
                                                                    @foreach ($continentArr as $ar)
                                                                        <option value="{{ $ar->id }}" {{$personInfo->continent_id == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error text-error"></div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <label class="mb-0" for="permanent_address_country_id">Country <span class="text-error">*</span></label>
                                                                <select name="country_id" id="permanent_address_country_id" class="form-control get-state-list country-id" data-id="permanent_address_state_id" data-required="yes" >
                                                                    <option value="0">Select Country</option>
                                                                    @foreach ($countryArr as $ar)
                                                                        <option value="{{ $ar->id }}" {{$personInfo->country_id == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error text-error"></div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <label class="mb-0" for="permanent_address_state_id">State <span class="text-error">*</span></label>
                                                                <select name="state_id" id="permanent_address_state_id" class="form-control get-city-list state-id" data-id="permanent_address_city_id" data-required="yes" >
                                                                    <option value="0">Select State</option>
                                                                    @foreach ($stateArr as $ar)
                                                                        <option value="{{ $ar->id }}" {{$personInfo->state_id == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error text-error"></div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <label class="mb-0" for="permanent_address_city_id">City <span class="text-error">*</span></label>
                                                                <select name="city_id" id="permanent_address_city_id" class="form-control city-id" data-required="yes" >
                                                                    <option value="0">Select City</option>
                                                                    @foreach ($cityArr as $ar)
                                                                        <option value="{{ $ar->id }}" {{$personInfo->city_id == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error text-error"></div>
                                                            </div>   
                                                            <div class="col-md-6 col-sm-12">
                                                                <label class="mb-0" for="permanent_address_zipcode">Zipcode <span class="text-error">*</span></label>
                                                                <input type="text" class="form-control mb-2" id="permanent_address_zipcode" name="zipcode" placeholder="Zipcode" value="{{$personInfo->employee_address->zipcode ?? ''}}" data-required="yes" >
                                                                <div class="error text-error"></div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 permanent-address-checkbox-div">
                                                                <input type="checkbox" class="permanent-address-checkbox" id="permanent_address_checkbox" name="checkbox" {{ ($personInfo->employee_address->type ?? 0 ) == 1 ? 'checked' : ''}}>
                                                                <label class="mb-0" for="permanent_address_checkbox">Permanent Address</label>
                                                            </div>                                                 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseBankInformation" aria-expanded="false">
                                    <span class="title">5. Bank Information</span>
                                    <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                </div>
                                <div id="collapseBankInformation" class="collapse" data-parent="#accordionEmployeeHistory">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="bank_name">Bank Name <span class="text-error">*</span></label>
                                                <input type="text" class="form-control mb-2" id="bank_name" name="bank_name" placeholder="Bank Name" value="{{$personInfo->bank_information->bank_name ?? ''}}" data-required="yes" >
                                            </div>

                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="holder_name">Holder Name <span class="text-error">*</span></label>
                                                <input type="text" class="form-control mb-2" id="holder_name" name="holder_name" placeholder="holder Name" value="{{$personInfo->bank_information->holder_name ?? ''}}" data-required="yes" >
                                            </div>
                                            
                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="account_no">Account Number <span class="text-error">*</span></label>
                                                <input type="text" class="form-control mb-2" id="account_no" name="account_no" placeholder="Account Number" value="{{$personInfo->bank_information->account_no ?? ''}}" data-required="yes" >
                                            </div>
                                            
                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="ifsc_code">IFSC Code <span class="text-error">*</span></label>
                                                <input type="text" class="form-control mb-2" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code" value="{{$personInfo->bank_information->ifsc_code ?? ''}}" data-required="yes" >
                                            </div>

                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="micr_code">MICR Code <span class="text-error">*</span></label>
                                                <input type="text" class="form-control mb-2" id="micr_code" name="micr_code" placeholder="MICR Code" value="{{$personInfo->bank_information->micr_code ?? ''}}" data-required="yes" >
                                            </div>

                                            <div class="col-md-4 col-sm-12">
                                                <label class="mb-0" for="branch_code">Branch Code <span class="text-error">*</span></label>
                                                <input type="text" class="form-control mb-2" id="branch_code" name="branch_code" placeholder="Branch Code" value="{{$personInfo->bank_information->branch_code ?? ''}}" data-required="yes" >
                                            </div>
                                            
                                            <div class="col-md-12 col-sm-12">
                                                <label class="mb-0" for="address">Full Address <span class="text-error">*</span></label>
                                                <textarea name="bank_address" id="bank_address" class="form-control bank-address" rows="4" placeholder="Full address" data-required="yes" >{{$personInfo->bank_information->address ?? ''}}</textarea>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseSocialMedia" aria-expanded="false">
                                    <span class="title">6. Social Media</span>
                                    <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                </div>
                                <div id="collapseSocialMedia" class="collapse" data-parent="#accordionEmployeeHistory">
                                    <div class="card-body">
                                        <div class="row" id="addSocialMediaPlatform">
                                            @if( $personInfo->social_medias != "null" )
                                                <?php
                                                $socialMedia = json_decode( $personInfo->social_medias, 1 );
                                                ?>
                                                @foreach( $socialMedia as $sm )
                                                    <div class="col-md-2 col-sm-12 mb-2">
                                                        <select name="social_media[0][platform]" id="social_media" class="form-control">
                                                            <option value="0">Select Platform</option>
                                                            @foreach( $socialMediaArr as $social )
                                                                <option value="{{$social->id}}" {{$sm['platform'] == $social->id ? 'selected' : '' }}>{{$social->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error text-error"></div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12">
                                                        <input name="social_media[0][link]" id="link" class="form-control" value="{{$sm['link'] ?? ''}}" placeholder="Enter Social Media link">
                                                        <div class="error text-error"></div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center col-sm-12">
                                                <button type="button" class="btn btn-outline-success pr-4 pl-4 add-more-social-media">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseKYCInformation" aria-expanded="false">
                                    <span class="title">7. KYC Information</span>
                                    <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                </div>
                                <div id="collapseKYCInformation" class="collapse" data-parent="#accordionEmployeeHistory">
                                    <div class="card-body">
                                        <fieldset class="p-2">
                                            <legend>Proof of Identity (POI):</legend>
                                            <div class="row text-center">
                                                <div class="col-3 col-sm-6 col-lg-3">
                                                    <div class="col-md-12 box-shadow-10 border-radius-15 mb-0">
                                                        <label class="mb-0" for="national_id_card">National Identity Card</label>
                                                        @if( $personInfo->personal_information )
                                                            <input type="file" data-default-file="{{url( 'storage/'.$personInfo->personal_information->national_id_card )}}" class="national_id_card" id="national_id_card" name="national_id_card" accept="image/jpg, image/jpeg, image/png">
                                                        @else
                                                            <input type="file" class="national_id_card" id="national_id_card" name="national_id_card" accept="image/jpg, image/jpeg, image/png">
                                                        @endif
                                                    </div>
                                                </div>
    
                                                <div class="col-3 col-sm-6 col-lg-3">
                                                    <div class="col-md-12 box-shadow-10 border-radius-15 mb-0">
                                                        <label class="mb-0" for="voter_id_card">Voter's Identity Card</label>
                                                        @if( $personInfo->personal_information )
                                                            <input type="file" data-default-file="{{url( 'storage/'.$personInfo->personal_information->voter_id_card ?? '' )}}" class="voter_id_card" id="voter_id_card" name="voter_id_card" accept="image/jpg, image/jpeg, image/png">
                                                        @else
                                                            <input type="file" class="voter_id_card" id="voter_id_card" name="voter_id_card" accept="image/jpg, image/jpeg, image/png">
                                                        @endif
                                                    </div>
                                                </div>
    
                                                <div class="col-3 col-sm-6 col-lg-3">
                                                    <div class="col-md-12 box-shadow-10 border-radius-15 mb-0">
                                                        <label class="mb-0" for="passport">Passport</label>
                                                        @if( $personInfo->personal_information )
                                                            <input type="file" data-default-file="{{url( 'storage/'.$personInfo->personal_information->passport ?? '' )}}" class="passport" id="passport" name="passport" accept="image/jpg, image/jpeg, image/png">
                                                        @else
                                                            <input type="file" class="passport" id="passport" name="passport" accept="image/jpg, image/jpeg, image/png">
                                                        @endif
                                                    </div>
                                                </div>
    
                                                <div class="col-3 col-sm-6 col-lg-3">
                                                    <div class="col-md-12 box-shadow-10 border-radius-15 mb-0">
                                                        <label class="mb-0" for="driving_license">Driving License</label>
                                                        @if( $personInfo->personal_information )
                                                            <input type="file" data-default-file="{{url( 'storage/'.$personInfo->personal_information->driving_license ?? '' )}}" class="driving_license" id="driving_license" name="driving_license" accept="image/jpg, image/jpeg, image/png">
                                                        @else
                                                            <input type="file" class="driving_license" id="driving_license" name="driving_license" accept="image/jpg, image/jpeg, image/png">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset class="p-2 mt-3">
                                            <legend>Proof of Address (POA):</legend>
                                            <div class="row text-center">
                                                <div class="col-3 col-sm-6 col-lg-3">
                                                    <div class="col-md-12 box-shadow-10 border-radius-15 mb-0">
                                                        <label class="mb-0" for="utility_bills">Utility Bills</label>
                                                        @if( $personInfo->personal_information )
                                                            <input type="file" data-default-file="{{url( 'storage/'.$personInfo->personal_information->utility_bills ?? '' )}}" class="utility_bills" id="utility_bills" name="utility_bills" accept="image/jpg, image/jpeg, image/png">
                                                        @else
                                                            <input type="file" class="utility_bills" id="utility_bills" name="utility_bills" accept="image/jpg, image/jpeg, image/png">
                                                        @endif
                                                    </div>
                                                </div>
    
                                                <div class="col-3 col-sm-6 col-lg-3">
                                                    <div class="col-md-12 box-shadow-10 border-radius-15 mb-0">
                                                        <label class="mb-0" for="bank_statement">Bank Statements</label>
                                                        @if( $personInfo->personal_information )
                                                            <input type="file" data-default-file="{{url( 'storage/'.$personInfo->personal_information->bank_statement ?? '' )}}" class="bank_statement" id="bank_statement" name="bank_statement" accept="image/jpg, image/jpeg, image/png">
                                                        @else
                                                            <input type="file" class="bank_statement" id="bank_statement" name="bank_statement" accept="image/jpg, image/jpeg, image/png">
                                                        @endif
                                                    </div>
                                                </div>
    
                                                <div class="col-3 col-sm-6 col-lg-3">
                                                    <div class="col-md-12 box-shadow-10 border-radius-15 mb-0">
                                                        <label class="mb-0" for="agreement">Agreement</label>
                                                        @if( $personInfo->personal_information )
                                                            <input type="file" data-default-file="{{url( 'storage/'.$personInfo->personal_information->agreement ?? '' )}}" class="agreement" id="agreement" name="agreement" accept="image/jpg, image/jpeg, image/png">
                                                        @else
                                                            <input type="file" class="agreement" id="agreement" name="agreement" accept="image/jpg, image/jpeg, image/png">
                                                        @endif
                                                    </div>
                                                </div>
    
                                                <div class="col-3 col-sm-6 col-lg-3">
                                                    <div class="col-md-12 box-shadow-10 border-radius-15 mb-0">
                                                        <label class="mb-0" for="property_receipt">Property Receipts</label>
                                                        @if( $personInfo->personal_information )
                                                            <input type="file" data-default-file="{{url( 'storage/'.$personInfo->personal_information->property_receipt ?? '' )}}" class="property_receipt" id="property_receipt" name="property_receipt" accept="image/jpg, image/jpeg, image/png">
                                                        @else
                                                            <input type="file" class="property_receipt" id="property_receipt" name="property_receipt" accept="image/jpg, image/jpeg, image/png">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset class="p-2 mt-3">
                                            <legend>Additional Documents (if applicable):</legend>
                                            <div class="row text-center">
                                                <div class="col-3 col-sm-6 col-lg-3">
                                                    <div class="col-md-12 box-shadow-10 border-radius-15 mb-0">
                                                        <label class="mb-0" for="aadhar_card">Adhar Card</label>
                                                        @if( $personInfo->personal_information )
                                                            <input type="file" data-default-file="{{url( 'storage/'.$personInfo->personal_information->aadhar_card ?? '' )}}" class="aadhar_card" id="aadhar_card" name="aadhar_card" accept="image/jpg, image/jpeg, image/png">
                                                        @else
                                                            <input type="file" class="aadhar_card" id="aadhar_card" name="aadhar_card" accept="image/jpg, image/jpeg, image/png">
                                                        @endif
                                                    </div>
                                                </div>
    
                                                <div class="col-3 col-sm-6 col-lg-3">
                                                    <div class="col-md-12 box-shadow-10 border-radius-15 mb-0">
                                                        <label class="mb-0" for="pan_card">Pan Card</label>
                                                        @if( $personInfo->personal_information )
                                                            <input type="file" data-default-file="{{url( 'storage/'.$personInfo->personal_information->pan_card ?? '' )}}" class="pan_card" id="pan_card" name="pan_card" accept="image/jpg, image/jpeg, image/png">
                                                        @else
                                                            <input type="file" class="pan_card" id="pan_card" name="pan_card" accept="image/jpg, image/jpeg, image/png">
                                                        @endif
                                                    </div>
                                                </div>
    
                                                <div class="col-3 col-sm-6 col-lg-3">
                                                    <div class="col-md-12 box-shadow-10 border-radius-15 mb-0">
                                                        <label class="mb-0" for="birth_certificate">Birth Certificate</label>
                                                        @if( $personInfo->personal_information )
                                                            <input type="file" data-default-file="{{url( 'storage/'.$personInfo->personal_information->birth_certificate ?? '' )}}" class="birth_certificate" id="birth_certificate" name="birth_certificate" accept="image/jpg, image/jpeg, image/png">
                                                        @else
                                                            <input type="file" class="birth_certificate" id="birth_certificate" name="birth_certificate" accept="image/jpg, image/jpeg, image/png">
                                                        @endif
                                                    </div>
                                                </div>
    
                                                <div class="col-3 col-sm-6 col-lg-3">
                                                    <div class="col-md-12 box-shadow-10 border-radius-15 mb-0">
                                                        <label class="mb-0" for="employee_letter">Employment Letter</label>
                                                        @if( $personInfo->personal_information )
                                                            <input type="file" data-default-file="{{url( 'storage/'.$personInfo->personal_information->employee_letter ?? '' )}}" class="employee_letter" id="employee_letter" name="employee_letter" accept="image/jpg, image/jpeg, image/png">
                                                        @else
                                                            <input type="file" class="employee_letter" id="employee_letter" name="employee_letter" accept="image/jpg, image/jpeg, image/png">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row row mb-4 mt-3">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success pr-4 pl-4" id="submitForm">
                                    <i class="fa fa-save"></i> Save
                                </button>
                                <a href="{{ route('admin.employee.index') }}" class="btn btn-danger pr-4 pl-4">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->

    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('public/backend/assets/js/select2.min.js') }}"></script>
<script src="{{ asset('public/backend/assets/js/employeeForm.js') }}"></script>
@endsection
