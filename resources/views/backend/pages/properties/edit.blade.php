@extends('backend.layouts.master')

@section('title')
    Properties - Admin Panel
@endsection

@section('styles')
    <link href="{{ asset('public/backend/assets/css/select2.min.css') }}" rel="stylesheet" />
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
    <style>
        .form-check-label {
            text-transform: capitalize;
        }

        .check-box::before {
            content: "\2611";
            color: #ab8134;
        }

        .form-check-input:checked {
            background-color: #ab8134;
        }

        .active {
            display: block;
        }

        li.child-nested {
            margin-left: 30px;
        }

        li.child-nested .form-check-input {
            width: auto !important;
        }
    </style>
@endsection

@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left d-none">Properties</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.properties.index') }}">All Properties </a></li>
                        <li><span>Edit Properties</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <p class="float-end">
                    @if (Auth::guard('admin')->user()->can('properties.edit'))
                        <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                            <i class="fa fa-save"></i> Save
                        </button>
                    @endif
                    <a href="{{ route('admin.properties.index') }}" class="btn btn-danger">
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
                <h3 class="pb-3">Edit Properties</h3>
                <div class="card">
                    <div class="card-body" id="PropertyRegistrationForm">
                        <!-- extra hidden values -->
                        <span class="get-continent-list-url d-none">{{ url('api/get-continent-list') }}</span>
                        {{-- <span class="property-submit-url d-none">{{ route('admin.properties.update', $data->id) }}</span> --}}
                        <span class="property-submit-url d-none">{{ route('admin.properties.store') }}</span>

                        <!-- start step indicators -->
                        <div class="form-header d-flex mb-4">
                            <span class="stepIndicator">1. Property Details</span>
                            <span class="stepIndicator">2. Feature(s)</span>
                            <span class="stepIndicator">3. Upload</span>
                        </div>
                        <!-- end step indicators -->

                        <!-- 1. Property Details -->
                        <div class="step">
                            <h3 class="text-center mb-2">Property Details</h3>
                            <p class="text-center mb-2">Provide following details of property.</p>


                            <form id="PropertyStepForm1" onsubmit="return onSubmitValidateForm();" method="POST"
                                autocomplete="off">
                                @csrf

                                <input type="hidden" value="1" name="step">
                                <input type="hidden" value="{{ $data->id }}" name="id" class="property-id">

                                <fieldset>
                                    <legend>Property Information</legend>
                                    <div class="row">

                                        <div class="col-md-12 col-sm-12 mb-2">
                                            <label class="mb-0" for="name">Name/Title <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="name" name="name" placeholder="Property Name/Title"
                                                value="{{ old('name', $data->name) }}">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 mb-2">
                                            <label class="mb-0" for="building_name">Tower/Building<span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="building_name" name="building_name"
                                                placeholder="Property Tower/Building"
                                                value="{{ old('tower_name', $data->building_name) }}">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 mb-2 d-none">
                                            <label class="mb-0" for="h1_tag">H1 Tag <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="no"
                                                id="h1_tag" name="h1_tag" placeholder="H1 tag"
                                                value="{{ old('h1_tag', $data->h1_tag) }}">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 mb-2 d-none">
                                            <label class="mb-0" for="seo_title">SEO Title <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="no"
                                                id="seo_title" name="seo_title" placeholder="Property SEO Title"
                                                value="{{ old('seo_title', $data->seo_title) }}">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 mb-2 d-none">
                                            <label class="mb-0" for="meta_description">Meta Desccription <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="no"
                                                id="meta_description" name="meta_description"
                                                placeholder="SEO Meta Description"
                                                value="{{ old('meta_description', $data->meta_description) }}">
                                            <div class="error text-error"></div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 mb-2">
                                            <label class="mb-0" for="description">Description <span
                                                    class="text-error">*</span></label>
                                            <textarea class="ckeditor form-control" id="description" name="description" rows="16"
                                                placeholder="Enter description here...">{{ old('description', $data->description ?? '') }}</textarea>

                                            @error('description')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="purpose">Purpose <span
                                                    class="text-error">*</span></label>
                                            <select name="purpose" id="purpose" class="form-control"
                                                data-required="yes">
                                                <option value="" selected disabled> Select Purpose </option>
                                                <option value="1"
                                                    {{ old('purpose', $data->purpose ?? '') == 1 ? 'selected' : '' }}>
                                                    Sale</option>
                                                <option value="2"
                                                    {{ old('purpose', $data->purpose ?? '') == 2 ? 'selected' : '' }}>
                                                    Rent</option>

                                            </select>

                                            @error('purpose')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="type">Type <span
                                                    class="text-error">*</span></label>
                                            <select name="type" id="type" class="form-control"
                                                data-required="yes">
                                                <option value="" selected disabled>Select Type</option>
                                                <option value="0"
                                                    {{ old('type', $data->type ?? '') == 0 ? 'selected' : '' }}>All
                                                </option>
                                                <option value="1"
                                                    {{ old('type', $data->type ?? '') == 1 ? 'selected' : '' }}>
                                                    Residential</option>
                                                <option value="2"
                                                    {{ old('type', $data->type ?? '') == 2 ? 'selected' : '' }}>
                                                    Commercial</option>
                                                <option value="3"
                                                    {{ old('type', $data->type ?? '') == 3 ? 'selected' : '' }}>
                                                    Land</option>
                                            </select>

                                            @error('type')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="sub_type_id">Sub Type <span
                                                    class="text-error">*</span></label>
                                            <select name="sub_type_id" id="sub_type_id" class="form-control "
                                                data-required="yes">
                                                <option value="">Select Sub Type</option>
                                                @foreach ($propertyTypeObj as $ar)
                                                    <option value="{{ $ar->id }}"
                                                        class="show-{{ $ar->main_type }} default-sub-type-hide d-none"
                                                        {{ old('sub_type_id', $data->sub_type_id ?? '') == $ar->id ? 'selected' : '' }}>
                                                        {{ $ar->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('sub_type_id')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="is_furnish">Furnish Status <span
                                                    class="text-error">*</span></label>
                                            <select name="is_furnish" id="is_furnish" class="form-control"
                                                data-required="yes">
                                                <option value="">Select Furnish Status</option>

                                                <option value="0"
                                                    {{ old('is_furnish', $data->is_furnish ?? '') == 0 ? 'selected' : '' }}>
                                                    Un-Furnished</option>
                                                <option value="1"
                                                    {{ old('is_furnish', $data->is_furnish ?? '') == 1 ? 'selected' : '' }}>
                                                    Furnished</option>
                                                <option value="2"
                                                    {{ old('is_furnish', $data->is_furnish ?? '') == 2 ? 'selected' : '' }}>
                                                    Semi-Furnished</option>
                                            </select>

                                            @error('is_furnish')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-4 col-sm-12 mb-2 purpose-for-sale">
                                            <label class="mb-0" for="is_complete">Completion Status <span
                                                    class="text-error">*</span></label>
                                            <select name="is_complete" id="is_complete" class="form-control"
                                                data-required="yes">
                                                <option value="">Select Completion Status</option>
                                                <option value="1"
                                                    {{ old('is_complete', $data->is_complete ?? '') == 1 ? 'selected' : '' }}>
                                                    Ready</option>
                                                <option value="2"
                                                    {{ old('is_complete', $data->is_complete ?? '') == 2 ? 'selected' : '' }}>
                                                    Secondary</option>
                                                <option value="3"
                                                    {{ old('is_complete', $data->is_complete ?? '') == 3 ? 'selected' : '' }}>
                                                    Off Plan</option>
                                            </select>

                                            @error('is_complete')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2 d-none purpose-for-rent">
                                            <label class="mb-0" for="is_occupancy">Occupancy Status <span
                                                    class="text-error">*</span></label>
                                            <select name="is_occupancy" id="is_occupancy" class="form-control"
                                                data-required="yes">
                                                <option value=""> Select Occupancy Status </option>
                                                <option value="1"
                                                    {{ old('is_occupancy', $data->is_occupancy ?? '') == 1 ? 'selected' : '' }}>
                                                    Vacant</option>
                                                <option value="2"
                                                    {{ old('is_occupancy', $data->is_occupancy ?? '') == 2 ? 'selected' : '' }}>
                                                    Rented</option>
                                            </select>

                                            @error('is_occupancy')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="ownership_status">Ownership Status <span
                                                    class="text-error">*</span></label>
                                            <select name="ownership_status" id="ownership_status" class="form-control"
                                                data-required="yes">
                                                <option value="">Select Ownership Status</option>
                                                <option value="0"
                                                    {{ old('ownership_status', $data->ownership_status ?? '') == 0 ? 'selected' : '' }}>
                                                    Freehold</option>
                                                <option value="1"
                                                    {{ old('ownership_status', $data->ownership_status ?? '') == 1 ? 'selected' : '' }}>
                                                    Leasehold</option>
                                            </select>

                                            @error('ownership_status')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>



                                        <div class="col-md-4 col-sm-12 mb-2 d-none is-complete-offplan">
                                            <label class="mb-0" for="off_plan_sale_type">Off-Plan Sale Type <span
                                                    class="text-error">*</span></label>
                                            <select name="off_plan_sale_type" id="off_plan_sale_type"
                                                class="form-control" data-required="yes">
                                                <option value="">Select Sale Type</option>
                                                <option value="1"
                                                    {{ old('off_plan_sale_type', $data->off_plan_sale_type ?? '') == 1 ? 'selected' : '' }}>
                                                    Initial Sale</option>
                                                <option value="2"
                                                    {{ old('off_plan_sale_type', $data->off_plan_sale_type ?? '') == 2 ? 'selected' : '' }}>
                                                    ReSale</option>
                                            </select>

                                            @error('off_plan_sale_type')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-4 col-sm-12 mb-2 d-none is-complete-offplan">
                                            <label class="mb-0" for="quarter">Expected Quarter <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="no"
                                                id="quarter" name="quarter" placeholder="Expected Quarter"
                                                value="{{ old('quarter', $data->quarter) }}">
                                            @error('quarter')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-4 col-sm-12 mb-2 is-complete-offplan">
                                            <label class="mb-0" for="plan_detail">Payment Plan<span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="no"
                                                id="plan_detail" name="plan_detail" placeholder="Plan Detail"
                                                value="{{ old('plan_detail', $data->plan_detail) }}">
                                            <div class="error text-error"></div>
                                        </div>

                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend>Property <span class="purpose-type-txt">Sale</span> Details</legend>

                                    <div class="row">

                                        <div class="col-md-3 col-sm-12 mb-2">
                                            <label class="mb-0" for="price">
                                                <span class="purpose-type-txt">Sale</span>(AED)
                                                <span class="text-danger">(All Inclusive)</span>
                                                <span class="text-error">*</span>
                                            </label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="price" name="price" placeholder="Enter Amount"
                                                value="{{ old('price', $data->price) }}">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-2 col-sm-12 mb-2 purpose-type-sale">
                                            <label class="mb-0" for="is_finance_available">Financing Available <span
                                                    class="text-error">*</span></label>
                                            <select name="is_finance_available" id="is_finance_available"
                                                class="form-control" data-required="yes">
                                                <option value="">Select Option</option>
                                                <option value="1"
                                                    {{ old('is_finance_available', $data->is_finance_available ?? '') == 1 ? 'selected' : '' }}>
                                                    Yes</option>
                                                <option value="2"
                                                    {{ old('is_finance_available', $data->is_finance_available ?? '') == 2 ? 'selected' : '' }}>
                                                    No</option>
                                                <option value="0"
                                                    {{ old('is_finance_available', $data->is_finance_available ?? '') == 0 ? 'selected' : '' }}>
                                                    Not Sure</option>
                                            </select>

                                            @error('is_finance_available')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-7 col-sm-12 mb-2 purpose-type-sale">
                                            <label class="mb-0" for="finance_name">Finance Institute Name</label>
                                            <input type="text" class="form-control mb-2" data-required=""
                                                id="finance_name" name="finance_name" placeholder="Finance Intitute Name"
                                                value="{{ old('finance_name', $data->finance_name) }}">
                                            <div class="error text-error"></div>
                                        </div>


                                        <div class="row mt-2">

                                            <div class="col-md-4 col-sm-12 mb-2 d-none type-type-residential">
                                                <label class="mb-0" for="beds">Bedroom(s)</label>

                                                <select name="beds" id="beds" class="form-control"
                                                    data-required="yes">

                                                    <option value="0"
                                                        {{ old('beds', $data->beds ?? '') == 0 ? 'selected' : '' }}>
                                                        studio</option>
                                                    <option value="1"
                                                        {{ old('beds', $data->beds ?? '') == 1 ? 'selected' : '' }}>
                                                        1</option>
                                                    <option value="2"
                                                        {{ old('beds', $data->beds ?? '') == 2 ? 'selected' : '' }}>
                                                        2</option>
                                                    <option value="3"
                                                        {{ old('beds', $data->beds ?? '') == 3 ? 'selected' : '' }}>
                                                        3</option>
                                                    <option value="4"
                                                        {{ old('beds', $data->beds ?? '') == 4 ? 'selected' : '' }}>
                                                        4</option>
                                                    <option value="5"
                                                        {{ old('beds', $data->beds ?? '') == 5 ? 'selected' : '' }}>
                                                        5</option>

                                                </select>
                                            </div>


                                            <div class="col-md-4 col-sm-12 mb-2 d-none type-type-residential">
                                                <label class="mb-0" for="baths">Bathroom(s)</label>
                                                <input type="number" class="form-control mb-2" data-required=""
                                                    id="baths" name="baths" placeholder="0"
                                                    value="{{ old('baths', $data->baths) }}">
                                                <div class="error text-error"></div>
                                            </div>


                                            <div class="col-md-4 col-sm-12 mb-2 d-none type-type-commercial">
                                                <label class="mb-0" for="staff_accomodation">Staff Accomodation <span
                                                        class="text-error">*</span></label>
                                                <input type="text" class="form-control mb-2" data-required="yes"
                                                    id="staff_accomodation" name="staff_accomodation"
                                                    placeholder="Staff Accomodation"
                                                    value="{{ old('staff_accomodation', $data->staff_accomodation) }}">
                                                <div class="error text-error"></div>
                                            </div>



                                        </div>

                                        <div class="col-md-3 col-sm-12 mb-2 d-none purpose-type-rent">
                                            <label class="mb-0" for="rent_frequency">Rent Frequency <span
                                                    class="text-error">*</span></label>
                                            <select name="rent_frequency" id="rent_frequency" class="form-control"
                                                data-required="yes">
                                                <option value="">Select Rent Frequency</option>
                                                <option value="1"
                                                    {{ old('rent_frequency', $data->rent_frequency ?? '') == 1 ? 'selected' : '' }}>
                                                    Daily</option>
                                                <option value="2"
                                                    {{ old('rent_frequency', $data->rent_frequency ?? '') == 2 ? 'selected' : '' }}>
                                                    Weekly</option>
                                                <option value="3"
                                                    {{ old('rent_frequency', $data->rent_frequency ?? '') == 3 ? 'selected' : '' }}>
                                                    Monthly</option>
                                                <option value="4"
                                                    {{ old('rent_frequency', $data->rent_frequency ?? '') == 4 ? 'selected' : '' }}>
                                                    Yearly</option>
                                            </select>

                                            @error('rent_frequency')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3 col-sm-12 mb-2 d-none purpose-type-rent">
                                            <label class="mb-0" for="rent_contract_period">Minimum Contract Period
                                                (Months) <span class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="rent_contract_period" name="rent_contract_period"
                                                placeholder="Minimum Contract Period (Months)"
                                                value="{{ old('rent_contract_period', $data->rent_contract_period) }}">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-3 col-sm-12 mb-2 d-none purpose-type-rent">
                                            <label class="mb-0" for="rent_notice_period">Vacating Notice Period (Months)
                                                <span class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="rent_notice_period" name="rent_notice_period"
                                                placeholder="Vacating Notice Period (Months)"
                                                value="{{ old('rent_notice_period', $data->rent_notice_period) }}">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-3 col-sm-12 mb-2 d-none purpose-type-rent">
                                            <label class="mb-0" for="maintenance_fees">Maintenance Fee (AED) <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="maintenance_fees" name="maintenance_fees"
                                                placeholder="Maintenance Fee (AED)"
                                                value="{{ old('maintenance_fees', $data->maintenance_fees) }}">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-3 col-sm-12 mb-2 d-none purpose-type-rent">
                                            <label class="mb-0" for="maintenance_paid">Maintenance Paid By <span
                                                    class="text-error">*</span></label>
                                            <select name="maintenance_paid" id="maintenance_paid" class="form-control"
                                                data-required="yes">
                                                <option value="">Select Payer</option>
                                                <option value="1"
                                                    {{ old('maintenance_paid', $data->maintenance_paid ?? '') == 1 ? 'selected' : '' }}>
                                                    Landlord</option>
                                                <option value="2"
                                                    {{ old('maintenance_paid', $data->maintenance_paid ?? '') == 2 ? 'selected' : '' }}>
                                                    Tenant</option>
                                            </select>

                                            @error('maintenance_paid')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>


                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend>Property Other Information</legend>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="area">Area(Square Feet.) <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="area" name="area" placeholder="Area (Square Feet.)"
                                                value="{{ old('area', $data->area) }}">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="rera_number">RERA Number <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="rera_number" name="rera_number" placeholder="Rera Number"
                                                value="{{ old('rera_number', $data->rera_number) }}">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="permit_number">Permit Number <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="permit_number" name="permit_number" placeholder="Permit Number"
                                                value="{{ old('permit_number', $data->permit_number) }}">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="location_id">Location <span
                                                    class="text-error">*</span></label>
                                            <select name="location_id" id="location_id" class="form-control select2"
                                                data-required="yes">
                                                <option value="">Select Location</option>
                                                @foreach ($locationObj as $ar)
                                                    <option value="{{ $ar->id }}"
                                                        {{ old('location_id', $data->location_id ?? '') == $ar->id ? 'selected' : '' }}>
                                                        {{ $ar->name }}
                                                    </option>
                                                @endforeach
                                                <option value="other">Other</option>
                                            </select>

                                            @error('location_id')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="develop_by">Develop By <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="develop_by" name="develop_by" placeholder="Developer Name"
                                                value="{{ old('develop_by', $data->develop_by) }}">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="agent_id">Agent <span
                                                    class="text-error">*</span></label>
                                            <select name="agent_id" id="agent_id" class="form-control"
                                                data-required="yes">
                                                <option value="">Select Agent</option>
                                                @foreach ($agentObj as $ar)
                                                    <option value="{{ $ar->id }}"
                                                        {{ old('agent_id', $data->agent_id ?? '') == $ar->id ? 'selected' : '' }}>
                                                        {{ $ar->first_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('agent_id')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-4 col-sm-12 mb-2" id="other_location_wrapper"
                                            style="display: none;">
                                            <label class="mb-0" for="other_location">Other Location <span
                                                    class="text-error">*</span></label>
                                            <input type="text" name="other_location" id="other_location"
                                                class="form-control" placeholder="Enter location name"
                                                value="{{ old('other_location', $data->other_location) }}">
                                            <div class="error text-error"></div>
                                        </div>

                                    </div>
                                </fieldset>

                                <!-- start previous / next buttons -->
                                <div class="row mt-4">
                                    <div class="col-md-6 offset-3">
                                        <div class="row form-footer d-flex">
                                            <div class="col-md-6 text-end">
                                                <button type="button" id="prevBtn" disabled
                                                    onclick="nextPrev(-1, '')">
                                                    <i class="fa fa-arrow-left"></i> Previous
                                                </button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" id="nextBtn"
                                                    onclick="nextPrev(1, 'PropertyStepForm1')">
                                                    Next <i class="fa fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end previous / next buttons -->

                            </form>
                        </div>


                        <!-- 2. Feature(s) -->
                        <div class="step">
                            <h3 class="text-center mb-2">Additional Feature(s)</h3>
                            <p class="text-center mb-2">Provide details of additional features(if any.)</p>

                            <form autocomplete="off" id="PropertyStepForm2" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="2" name="step">
                                <input type="hidden" value="" name="id" class="property-id">

                                <div class="col-md-12 col-sm-12 mb-2">
                                    <label class="form-check-label mb-2">Property Features</label>
                                    <textarea class="ckeditor form-control" id="property_features" name="additional_features"
                                        placeholder="Add additional property Features">{{ $data->additional_features }}</textarea>
                                    <div class="error text-error"></div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6 col-sm-12 mb-2">
                                        <label class="mb-0" for="is_new_property">
                                            Do you want to set this property as new? <span class="text-error">*</span>
                                        </label>
                                        <select name="is_new_property" id="is_new_property" class="form-control"
                                            data-required="yes">
                                            <option value="">Select New Property</option>
                                            <option value="1"
                                                {{ old('is_new_property', $data->is_new_property ?? '') == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="0"
                                                {{ old('is_new_property', $data->is_new_property ?? '') == 0 ? 'selected' : '' }}>
                                                No</option>

                                        </select>
                                        @error('is_new_property')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6 col-sm-12 mb-2">
                                        <label class="mb-0" for="is_featured_property">
                                            Do you want to set this property as featured? <span class="text-error">*</span>
                                        </label>
                                        <select name="is_featured_property" id="is_featured_property"
                                            class="form-control" data-required="yes">
                                            <option value="">Select Featured Property</option>
                                            <option value="1"
                                                {{ old('is_featured_property', $data->is_featured_property ?? 0) == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="0"
                                                {{ old('is_featured_property', $data->is_featured_property ?? 0) == 0 ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                        @error('is_featured_property')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6 col-sm-12 mb-2">
                                        <label class="mb-0" for="is_luxury_property">
                                            Do you want to set this property as luxury property? <span
                                                class="text-error">*</span>
                                        </label>
                                        <select name="is_luxury_property" id="is_luxury_property" class="form-control"
                                            data-required="yes">
                                            <option value="1"
                                                {{ old('is_luxury_property', $data->is_luxury_property ?? 0) == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="0"
                                                {{ old('is_luxury_property', $data->is_luxury_property ?? 0) == 0 ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                        @error('is_luxury_property')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6 col-sm-12 mb-2">
                                        <label class="mb-0" for="is_hot_offer">
                                            Do you want to set this property as Hot Offer Property?
                                            <span class="text-error">*</span>
                                        </label>
                                        <select name="is_hot_offer" id="is_hot_offer" class="form-control"
                                            data-required="yes">
                                            <option value="1"
                                                {{ old('is_hot_offer', $property->is_hot_offer ?? 0) == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="0"
                                                {{ old('is_hot_offer', $property->is_hot_offer ?? 0) == 0 ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                        <div class="error text-error"></div>
                                    </div>


                                </div>



                                <!-- start previous / next buttons -->
                                <div class="row mt-4">
                                    <div class="col-md-6 offset-3">
                                        <div class="row form-footer d-flex">
                                            <div class="col-md-6 text-end">
                                                <button type="button" id="prevBtn" onclick="nextPrev(-1, 'PREV')">
                                                    <i class="fa fa-arrow-left"></i> Previous
                                                </button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" id="nextBtn"
                                                    onclick="nextPrev(1, 'PropertyStepForm2')">
                                                    Next <i class="fa fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end previous / next buttons -->
                            </form>
                        </div>


                        <!-- 3. Upload -->
                        <div class="step">
                            <h3 class="text-center mb-2">Upload(s)</h3>
                            <p class="text-center mb-2">Provide images of property.</p>
                            <form autocomplete="off" id="PropertyStepForm3" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="3" name="step">
                                <input type="hidden" value="4" name="id" class="property-id">

                                <div class="row box-shadow-10">
                                    <div class="col-md-4 col-sm-12 mb-2">
                                        <label class="mb-0" for="property_image">Property Images</label>
                                        <input type="file" class="dropify" id="property_image" name="propertyImage[]"
                                            accept="image/jpg, image/jpeg, image/png" multiple>

                                        <span id="image-error" class="text-danger">You can select only five images.</span>
                                        @if ($errors->has('avtar'))
                                            <div class="error">{{ $errors->first('avtar') }}</div>
                                        @endif


                                        <!-- Show existing images -->
                                        @if (!empty($data->images) && count($data->images) > 0)
                                            <div class="col-12 mb-3">
                                                <label class="fw-semibold">Existing Images</label>
                                                <div class="d-flex flex-wrap gap-3">
                                                    @foreach ($data->images as $image)
                                                        <div class="position-relative border rounded p-1"
                                                            style="width:120px; height:120px; overflow:hidden;">
                                                            <img src="{{ asset('storage/app/propertyImage/' . $image->filename) }}"
                                                                alt="Property Image"
                                                                class="img-fluid w-100 h-100 object-fit-cover rounded">
                                                            <!-- Delete Checkbox -->
                                                            <div
                                                                class="form-check position-absolute top-0 end-0 bg-white rounded-circle m-1 p-1 shadow-sm">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="delete_images[]" value="{{ $image->id }}"
                                                                    id="delete_{{ $image->id }}">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <small class="text-muted d-block mt-1">Check images you want to
                                                    remove</small>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-4 col-sm-12 mb-2">
                                        <label class="mb-0" for="publish">Publish <span
                                                class="text-error">*</span></label>
                                        <select name="publish" id="publish" class="form-control" data-required="yes">
                                            <option value="0"
                                                {{ old('publish', $data->publish ?? '') == 0 ? 'selected' : '' }}>No
                                            </option>
                                            <option value="1"
                                                {{ old('publish', $data->publish ?? '') == 1 ? 'selected' : '' }}>Yes
                                            </option>
                                        </select>

                                        @error('publish')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 col-sm-12 mb-2">
                                        <label class="mb-0" for="status">Status <span
                                                class="text-error">*</span></label>
                                        <select name="status" id="status" class="form-control" data-required="yes">
                                            <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Disabled
                                            </option>
                                            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Enabled
                                            </option>
                                        </select>

                                        @error('status')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <!-- start previous / next buttons -->
                                <div class="row mt-4">
                                    <div class="col-md-6 offset-3">
                                        <div class="row form-footer d-flex">
                                            <div class="col-md-6 text-end">
                                                <button type="button" id="prevBtn" onclick="nextPrev(-1, 'PREV')">
                                                    <i class="fa fa-arrow-left"></i> Previous
                                                </button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" id="nextBtn"
                                                    onclick="nextPrev(1, 'PropertyStepForm3')">
                                                    Save <i class="fa fa-save"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end previous / next buttons -->

                            </form>


                            <div class="thank-you-page d-none">
                                <div class="properties-thank-you-content">
                                    <h1>Thank you for updation!</h1>
                                    <h4>Awesome! Your Property is onboard.</h4>
                                    <p>Property has been edited successfully and ID is: <snap style="font-weight: 800;"
                                            class="property-unique-id"></snap>
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-6 text-end">
                                        <button type="submit" class="btn btn-success pr-4 pl-4" id="submitForm">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                    </div>
                                    <div class="col-md-6 text-start">
                                        <a href="{{ route('admin.properties.index') }}" class="go-back">
                                            <i class="fa fa-back"></i> go Back
                                        </a>
                                    </div>
                                </div>
                            </div>





                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection
<style>
    .select2-container .select2-selection--single {
        height: 48px !important;
        /* same as form-control-lg */
        padding: 8px 12px !important;
        border: 1px solid lightgray !important;
        border-radius: 6px !important;
        display: flex !important;
        align-items: center !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px !important;
        right: 10px !important;
    }

    /* Hover color */
    .select2-results__option--highlighted {
        background-color: #ab8134 !important;
        /* your custom hover color */
        color: white !important;
    }
</style>
@section('scripts')
    <script src="{{ asset('public/backend/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('public/backend/assets/js/propertyForm.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .then(editor => {
                editorDescriptionInstance = editor;
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#property_features'))
            .then(editor => {
                editorAdditionFetureInstance = editor;
            })
            .catch(error => {
                console.error(error);
            });


        $(document).ready(function() {
            $('#location_id').select2({
                placeholder: "Search Location",
                allowClear: true,
                width: '100%' // IMPORTANT: keeps same layout
            });
        });

         // Initialize Dropify
        var drEvent = $('.dropify').dropify();

        // Limit to max 5 images
        $('#property_image').on('change', function() {

            if (this.files.length > 5) {

                Swal.fire({
                    icon: 'warning',
                    title: 'You can select only five images.',
                    text: 'Only the first five images will be accepted.',
                    confirmButtonColor: '#ab8134'
                }).then(() => {

                    // Clear selected files
                    this.value = "";

                    // Reset Dropify preview
                    var dropifyInstance = drEvent.data('dropify');
                    dropifyInstance.clearElement();

                });
            }
        });
    </script>
@endsection
