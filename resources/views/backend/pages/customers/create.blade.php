
@extends('backend.layouts.master')

@section('title')
Customer Create - Admin Panel
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .form-check-label {
        text-transform: capitalize;
    }
    .card{
        margin-bottom: 10px;
    }
    .card-header .title {
        font-size: 16px;
        color: #fff;
    }
    .card-header .accicon {
        float: right;
        font-size: 20px;
        width: 1.2em;
    }
    .card-header{
        cursor: pointer;
        border-bottom: none;
    }
    .card{
        border: 1px solid #ab8134;
    }
    .card-body{
        border-top: 1px solid #ab8134;
    }
    .card-header:not(.collapsed) .rotate-icon {
        transform: rotate(180deg);
    }
    .card-header {
        background-color: #ab8134ba;
    }

    .rotate-icon{
        color: #fff;
    }

    #accordionCustomerHistory fieldset{
        border: 1px solid #ab8134ba;
        padding: 15px;
    }

    legend{
        width: auto;
    }
</style>
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-md-7">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left d-none">Customer Create</h4>
                <ul class="breadcrumbs pull-left m-2">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.customer.index') }}">All Customers</a></li>
                    <li><span>Create Customer</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <p class="float-end">
                @if (Auth::guard('admin')->user()->can('customer.create'))
                    <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                        <i class="fa fa-save"></i> Save
                    </button>
                @endif
                <a href="{{ route('admin.customer.index') }}" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </p>
        </div>
        <div class="col-md-2 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-3">
            <h3 class="pb-3">Create Customer</h3>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.customer.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="accordion" id="accordionCustomerHistory">
                            <div class="card">
                                <div class="card-header" data-toggle="collapse" data-target="#collapseClientDetails" aria-expanded="true">
                                    <span class="title">1. Personal Details </span>
                                    <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                </div>
                                <div id="collapseClientDetails" class="collapse show" data-parent="#accordionCustomerHistory">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-4 col-sm-12">
                                                <label for="avtar">Avtar</label>
                                                <input type="file" class="avtar" id="avtar" name="avtar">
                                                @if($errors->has('avtar'))
                                                    <div class="error">{{ $errors->first('avtar') }}</div>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-8 col-sm-12">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="first_name">First Name</label>
                                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="middle_name">Middle Name</label>
                                                        <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name">
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="last_name">Last Name</label>
                                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="email_id">Email ID</label>
                                                        <input type="text" class="form-control" id="email_id" name="email_id" placeholder="Email ID">
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="gender">Gender</label>
                                                        <select name="gender" id="gender" class="form-control">
                                                            <option value="1">Male</option>
                                                            <option value="2">Fe Male</option>
                                                            <option value="3">Trans</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="religion_id">Religion</label>
                                                        <select name="religion_id" id="religion_id" class="form-control">
                                                            @foreach ($religionArr as $ar)
                                                                <option value="{{ $ar->id }}">{{ $ar->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="personal_mobile_number">Mobile Number</label>
                                                        <input type="text" class="form-control" id="personal_mobile_number" name="personal_mobile_number" placeholder="Mobile Number">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <fieldset>
                                            <legend>Permanent Address:</legend>
                                            <div class="form-row">
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label for="address">Address</label>
                                                    <textarea name="address" id="address" class="form-control address" rows="9" placeholder="Business Address"></textarea>
                                                </div>
                                                <div class="form-group col-md-8 col-sm-12">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="unique_id">Unique ID</label>
                                                            <input type="text" class="form-control" id="unique_id" name="unique_id" placeholder="Unique ID">
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="contact_number">Mobile Number</label>
                                                            <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Mobile Number">
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="continent_id">Continent</label>
                                                            <select name="continent_id" id="continent_id" class="form-control">
                                                                <option value="0">Select Continent</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="country_id">Country</label>
                                                            <select name="country_id" id="country_id" class="form-control">
                                                                <option value="0">Select Country</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="state_id">State</label>
                                                            <select name="state_id" id="state_id" class="form-control">
                                                                <option value="0">Select State</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="city_id">City</label>
                                                            <select name="city_id" id="city_id" class="form-control">
                                                                <option value="0">Select City</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="zipcode">Zipcode</label>
                                                            <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zipcode">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12 text-center">
                                                    <button type="button" class="btn btn-outline-secondary mt-4 pr-4 pl-4">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger mt-4 pr-4 pl-4">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseBusinessProfile" aria-expanded="false" aria-controls="collapseBusinessProfile">
                                    <span class="title">2. Business Profile</span>
                                    <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                </div>
                                <div id="collapseBusinessProfile" class="collapse" data-parent="#accordionCustomerHistory">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-4 col-sm-12">
                                            <label for="logo">Logo</label>
                                                <input type="file" class="business-logo" id="logo" name="logo">
                                                @if($errors->has('logo'))
                                                    <div class="error">{{ $errors->first('logo') }}</div>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-8 col-sm-12">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="name">Business Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Business Name">
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="unique_id">Business ID</label>
                                                        <input type="text" class="form-control" id="unique_id" name="unique_id" placeholder="Business ID">
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="email_id">Email ID</label>
                                                        <input type="text" class="form-control" id="email_id" name="email_id" placeholder="Email ID">
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="website">Website</label>
                                                        <input type="text" class="form-control website-link-validation" id="website" name="website" placeholder="Website">
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="contact_number">Mobile Number</label>
                                                        <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Mobile Number">
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="business_type">Type</label>
                                                        <select name="business_type" id="business_type" class="form-control">
                                                            <option value="0">Select Business Type</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12 col-sm-12">
                                                        <label for="description">Description</label>
                                                        <textarea name="description" id="description" class="form-control description" rows="4" placeholder="Business Description"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <fieldset>
                                            <legend>Business Address:</legend>
                                            <div class="form-row">
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label for="address">Address</label>
                                                    <textarea name="address" id="address" class="form-control address" rows="9" placeholder="Business Address"></textarea>
                                                </div>
                                                <div class="form-group col-md-8 col-sm-12">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="business_continent_id">Continent</label>
                                                            <select name="business_continent_id" id="business_continent_id" class="form-control">
                                                                <option value="0">Select Continent</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="business_country_id">Country</label>
                                                            <select name="business_country_id" id="business_country_id" class="form-control">
                                                                <option value="0">Select Country</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="business_state_id">State</label>
                                                            <select name="business_state_id" id="business_state_id" class="form-control">
                                                                <option value="0">Select State</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="business_city_id">City</label>
                                                            <select name="business_city_id" id="business_city_id" class="form-control">
                                                                <option value="0">Select City</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="zipcode">Zip Code</label>
                                                            <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zip Code">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseEmployeeProfile" aria-expanded="false">
                                    <span class="title">3. Employeement Profile</span>
                                    <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                </div>
                                <div id="collapseEmployeeProfile" class="collapse" data-parent="#accordionCustomerHistory">
                                    <div class="card-body">
                                        <fieldset>
                                            <legend>Details:</legend>
                                            <div class="form-row">
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label for="emp_avtar">Avtar</label>
                                                    <input type="file" class="emp_avtar" id="emp_avtar" name="emp_avtar">
                                                    @if($errors->has('emp_avtar'))
                                                        <div class="error">{{ $errors->first('emp_avtar') }}</div>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-8 col-sm-12">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="first_name">First Name</label>
                                                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="middle_name">Middle Name</label>
                                                            <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name">
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="last_name">Last Name</label>
                                                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="email_id">Email ID</label>
                                                            <input type="text" class="form-control" id="email_id" name="email_id" placeholder="Email ID">
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="gender">Gender</label>
                                                            <select name="gender" id="gender" class="form-control">
                                                                <option value="1">Male</option>
                                                                <option value="2">Fe Male</option>
                                                                <option value="3">Trans</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="personal_mobile_number">Mobile Number</label>
                                                            <input type="text" class="form-control" id="personal_mobile_number" name="personal_mobile_number" placeholder="Mobile Number">
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="job_title">Job Title</label>
                                                            <input type="text" class="form-control" id="job_title" name="job_title" placeholder="Job Title">
                                                        </div>
                                                        <div class="form-group col-md-12 col-sm-12">
                                                            <label for="description">Description</label>
                                                            <textarea name="description" id="description" class="form-control description" rows="4" placeholder="Job Description"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <div class="form-group col-md-12 text-center">
                                            <button type="button" class="btn btn-outline-secondary mt-4 pr-4 pl-4">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger mt-4 pr-4 pl-4">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseSocialMedia" aria-expanded="false">
                                    <span class="title">4. Social Media</span>
                                    <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                </div>
                                <div id="collapseSocialMedia" class="collapse" data-parent="#accordionCustomerHistory">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-3 col-sm-12">
                                                <label for="facebook">Facebook</label>
                                                <input type="text" class="form-control" id="facebook" name="facebook" placeholder="Facebook">
                                            </div>
                                            <div class="form-group col-md-3 col-sm-12">
                                                <label for="instagram">Instagram</label>
                                                <input type="text" class="form-control" id="instagram" name="instagram" placeholder="Instagram">
                                            </div>
                                            <div class="form-group col-md-3 col-sm-12">
                                                <label for="twitter">Twitter</label>
                                                <input type="text" class="form-control" id="twitter" name="twitter" placeholder="Twitter">
                                            </div>
                                            <div class="form-group col-md-3 col-sm-12">
                                                <label for="whats_app">WhatsApp</label>
                                                <input type="text" class="form-control" id="whats_app" name="whats_app" placeholder="WhatsApp">
                                            </div>
                                            <div class="form-group col-md-3 col-sm-12">
                                                <label for="youtube">Youtube</label>
                                                <input type="text" class="form-control" id="youtube" name="youtube" placeholder="Youtube">
                                            </div>
                                            <div class="form-group col-md-3 col-sm-12">
                                                <label for="linked_in">Linked In</label>
                                                <input type="text" class="form-control" id="linked_in" name="linked_in" placeholder="Linked In">
                                            </div>
                                            <div class="form-group col-md-3 col-sm-12">
                                                <label for="telegram">Telegram</label>
                                                <input type="text" class="form-control" id="telegram" name="telegram" placeholder="Telegram">
                                            </div>
                                            <div class="form-group col-md-3 col-sm-12">
                                                <label for="pinterest">Pinterest</label>
                                                <input type="text" class="form-control" id="pinterest" name="pinterest" placeholder="Pinterest">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseWealthDetails" aria-expanded="false">
                                    <span class="title">5. Wealth Details</span>
                                    <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                </div>
                                <div id="collapseWealthDetails" class="collapse" data-parent="#accordionCustomerHistory">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-3 col-sm-12">
                                                <label for="propertyControlRange">Min Property Range</label>
                                                <input type="range" class="form-control-range" id="propertyControlRange" onInput="$('#propertyRangeval').html($(this).val())">
                                                $<span id="propertyRangeval">4<!-- Default value --></span>K
                                            </div>
                                            <div class="form-group col-md-3 col-sm-12">
                                                <label for="businessRevenueControlRange">Min Business Revenue</label>
                                                <input type="range" class="form-control-range" id="businessRevenueControlRange" onInput="$('#businessRangeval').html($(this).val())">
                                                $<span id="businessRangeval">4<!-- Default value --></span>K
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="business_type">Business Type</label>
                                                        <select name="business_type" id="business_type" class="form-control business_type">
                                                            <option value="1">Forex</option>
                                                            <option value="2">Commodities</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="businessTypeRevenueControlRange">Business Type Revenue</label>
                                                        <input type="range" class="form-control-range" id="businessTypeRevenueControlRange" onInput="$('#businessTypeRangeval').html($(this).val())">
                                                        $<span id="businessTypeRangeval">4<!-- Default value --></span>K
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseOtherInformation" aria-expanded="false">
                                    <span class="title">6. Other Information</span>
                                    <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                </div>
                                <div id="collapseOtherInformation" class="collapse" data-parent="#accordionCustomerHistory">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <textarea name="other_info" id="other_info" class="form-control other_info" rows="10" placeholder="Other Customer/Employee/Business details"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success pr-4 pl-4">
                                    <i class="fa fa-save"></i> Save
                                </button>
                                <a href="{{ route('admin.customer.index') }}" class="btn btn-danger pr-4 pl-4">
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });

    $('.avtar').dropify({});
    $('.emp_avtar').dropify({});
    $('.business-logo').dropify({});
</script>
@endsection
