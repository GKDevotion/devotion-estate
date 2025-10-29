@extends('backend.layouts.master')

@section('title')
    Property Create - Admin Panel
@endsection

@section('styles')
    <link href="{{ asset('public/backend/assets/css/select2.min.css') }}" rel="stylesheet" />
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>

    <style>
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
                    <h4 class="page-title pull-left d-none">Property Create</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.properties.index') }}">All Property</a></li>
                        <li><span>Create Property</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <p class="float-end">
                    @if (Auth::guard('admin')->user()->can('properties.create'))
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
            <div class="col-12 mt-3">
                <h3 class="pb-3">Create Property</h3>
                <div class="card">
                    <div class="card-body" id="PropertyRegistrationForm">

                        <!-- extra hidden values -->
                        <span class="get-continent-list-url d-none">{{ url('api/get-continent-list') }}</span>
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
                            <form autocomplete="off" id="PropertyStepForm1" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="1" name="step">
                                <input type="hidden" value="" name="id" class="property-id">

                                <fieldset>
                                    <legend>Property Information</legend>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 mb-2">
                                            <label class="mb-0" for="name">Name/Title <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="name" name="name" placeholder="Property Name/Title"
                                                value="">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 mb-2">
                                            <label class="mb-0" for="h1_tag">H1 Tag <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="h1_tag" name="h1_tag" placeholder="H1 tag" value="">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 mb-2">
                                            <label class="mb-0" for="seo_title">SEO Title <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="seo_title" name="seo_title" placeholder="Property SEO Title"
                                                value="">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 mb-2">
                                            <label class="mb-0" for="meta_description">Meta Desccription <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="meta_description" name="meta_description"
                                                placeholder="SEO Meta Description" value="">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 mb-2">
                                            <label class="mb-0" for="description">Desccription <span
                                                    class="text-error">*</span></label>
                                            <textarea type="text" class="ckeditor form-control" id="description" name="description" placeholder="Description"
                                                rows="16"></textarea>
                                            <div class="error text-error"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="purpose">Purpose <span
                                                    class="text-error">*</span></label>
                                            <select name="purpose" id="purpose" class="form-control"
                                                data-required="yes">
                                                <option value="0">Sale</option>
                                                <option value="1">Rent</option>
                                            </select>
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="type">Type <span
                                                    class="text-error">*</span></label>
                                            <select name="type" id="type" class="form-control"
                                                data-required="yes">
                                                <option value="" selected>Select Type</option>
                                                <option value="0">Residential</option>
                                                <option value="1">Commercial</option>
                                            </select>
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="sub_type_id">Sub Type <span
                                                    class="text-error">*</span></label>
                                            <select name="sub_type_id" id="sub_type_id" class="form-control"
                                                data-required="yes">
                                                <option value="0">Select Sub Type</option>
                                                @foreach ($propertyTypeObj as $ar)
                                                    <option value="{{ $ar->id }}"
                                                        class="show-{{ $ar->main_type }} default-sub-type-hide d-none">
                                                        {{ $ar->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="is_furnish">Furnished Status <span
                                                    class="text-error">*</span></label>
                                            <select name="is_furnish" id="is_furnish" class="form-control"
                                                data-required="yes">
                                                <option value="0">Furnished</option>
                                                <option value="1">UnFurnished</option>
                                            </select>
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2 purpose-for-sale">
                                            <label class="mb-0" for="is_complete">Completion Status <span
                                                    class="text-error">*</span></label>
                                            <select name="is_complete" id="is_complete" class="form-control"
                                                data-required="yes">
                                                <option value="0">Select Completion Status</option>
                                                <option value="1">Ready</option>
                                                <option value="2">Secondary</option>
                                                <option value="3">Off Plan</option>
                                            </select>
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2 d-none purpose-for-rent">
                                            <label class="mb-0" for="is_occupancy">Occupancy Status <span
                                                    class="text-error">*</span></label>
                                            <select name="is_occupancy" id="is_occupancy" class="form-control"
                                                data-required="yes">
                                                <option value="0">Select Occupancy Status</option>
                                                <option value="1">Vecant</option>
                                                <option value="2">Rented</option>
                                            </select>
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="ownership_status">Ownership Status <span
                                                    class="text-error">*</span></label>
                                            <select name="ownership_status" id="ownership_status" class="form-control"
                                                data-required="yes">
                                                <option value="0">Freehold</option>
                                                <option value="1">Leasehold</option>
                                            </select>
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2 d-none is-complete-offplan">
                                            <label class="mb-0" for="off_plan_sale_type">Off-Plan Sale Type <span
                                                    class="text-error">*</span></label>
                                            <select name="off_plan_sale_type" id="off_plan_sale_type"
                                                class="form-control" data-required="yes">
                                                <option value="0">Select Sale Type</option>
                                                <option value="1">Initial Sale</option>
                                                <option value="2">ReSale</option>
                                            </select>
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2 d-none is-complete-offplan">
                                            <label class="mb-0" for="completed_date">Expected Completion Date <span
                                                    class="text-error">*</span></label>
                                            <input type="date" class="form-control mb-2" data-required="yes"
                                                id="completed_date" name="completed_date"
                                                placeholder="Expected Completed Date" value="">
                                            <div class="error text-error"></div>
                                        </div>

                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend>Property <span class="purpose-type-txt">Sale</span> Details</legend>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 mb-2">
                                            <label class="mb-0" for="price"><span
                                                    class="purpose-type-txt">Sale</span>(AED) <span
                                                    class="text-danger">(All Inclusive)</span> <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="price" name="price" placeholder="Enter Amount" value="">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-2 col-sm-12 mb-2 purpose-type-sale">
                                            <label class="mb-0" for="is_finance_available">Financing Available <span
                                                    class="text-error">*</span></label>
                                            <select name="is_finance_available" id="is_finance_available"
                                                class="form-control" data-required="yes">
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                                <option value="0">Not Sure</option>
                                            </select>
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-5 col-sm-12 mb-2 purpose-type-sale">
                                            <label class="mb-0" for="finance_name">Finance Institute Name</label>
                                            <input type="text" class="form-control mb-2" data-required=""
                                                id="finance_name" name="finance_name" placeholder="Finance Intitute Name"
                                                value="">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-3 col-sm-12 mb-2 d-none purpose-type-rent">
                                            <label class="mb-0" for="rent_frequency">Rent Frequency <span
                                                    class="text-error">*</span></label>
                                            <select name="rent_frequency" id="rent_frequency" class="form-control"
                                                data-required="yes">
                                                <option value="1">Daily</option>
                                                <option value="2">Weekly</option>
                                                <option value="3">Monthly</option>
                                                <option value="4">Yearly</option>
                                            </select>
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-3 col-sm-12 mb-2 d-none purpose-type-rent">
                                            <label class="mb-0" for="rent_contract_period">Minimum Contract Period
                                                (Months) <span class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="rent_contract_period" name="rent_contract_period"
                                                placeholder="Minimum Contract Period (Months)" value="">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-3 col-sm-12 mb-2 d-none purpose-type-rent">
                                            <label class="mb-0" for="rent_notice_period">Vacating Notice Period (Months)
                                                <span class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="rent_notice_period" name="rent_notice_period"
                                                placeholder="Vacating Notice Period (Months)" value="">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-3 col-sm-12 mb-2 d-none purpose-type-rent">
                                            <label class="mb-0" for="maintenance_fees">Maintenance Fee (AED) <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="maintenance_fees" name="maintenance_fees"
                                                placeholder="Maintenance Fee (AED)" value="">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-3 col-sm-12 mb-2 d-none purpose-type-rent">
                                            <label class="mb-0" for="maintenance_paid">Maintenance Paid By <span
                                                    class="text-error">*</span></label>
                                            <select name="maintenance_paid" id="maintenance_paid" class="form-control"
                                                data-required="yes">
                                                <option value="1">Landlord</option>
                                                <option value="2">Tenant</option>
                                            </select>
                                            <div class="error text-error"></div>
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
                                                value="">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="rera_number">RERA Number <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="rera_number" name="rera_number" placeholder="Rera Number"
                                                value="">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="permit_number">Permit Number <span
                                                    class="text-error">*</span></label>
                                            <input type="text" class="form-control mb-2" data-required="yes"
                                                id="permit_number" name="permit_number" placeholder="Permit Number"
                                                value="">
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="location_id">Location <span
                                                    class="text-error">*</span></label>
                                            <select name="location_id" id="location_id" class="form-control"
                                                data-required="yes">
                                                <option value="">Select Location</option>
                                                @foreach ($locationObj as $ar)
                                                    <option value="{{ $ar->id }}">{{ $ar->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <label class="mb-0" for="agent_id">Agent <span
                                                    class="text-error">*</span></label>
                                            <select name="agent_id" id="agent_id" class="form-control"
                                                data-required="yes">
                                                <option value="">Select Agent</option>
                                                @foreach ($agentObj as $ar)
                                                    <option value="{{ $ar->id }}">{{ $ar->first_name }}</option>
                                                @endforeach
                                            </select>
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

                                <ul class="nested">
                                    <div class="row">
                                        @foreach (getPropertyFeatures() as $ar)
                                            <div class="col-md-3 col-sm-12">
                                                <li class="child-nested">
                                                    <input type="checkbox" class="form-check-input" name="feature_id[]"
                                                        id="property_feature_{{ $ar->id }}"
                                                        value="{{ $ar->id }}">
                                                    <label class="mb-0 form-check-label"
                                                        for="property_feature_{{ $ar->id }}"
                                                        oninput="trackChanges()">{{ $ar->name }}</label>
                                                </li>
                                            </div>
                                        @endforeach
                                    </div>
                                </ul>


                                <div class="row mt-4">
                                    <div class="col-md-6 col-sm-12 mb-2 ">
                                        <label class="mb-0" for="is_set_new_property">Do you want to set this property
                                            as
                                            new? <span class="text-error">*</span></label>
                                        <select name="is_set_new_property" id="	is_set_new_property" class="form-control"
                                            data-required="yes">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>

                                        </select>
                                        <div class="error text-error"></div>
                                    </div>

                                    <div class="col-md-6 col-sm-12 mb-2 ">
                                        <label class="mb-0" for="is_featured_property">Do you want to set this property
                                            as featured?<span class="text-error">*</span></label>
                                        <select name="is_featured_property" id="is_featured_property"
                                            class="form-control" data-required="yes">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>

                                        </select>
                                        <div class="error text-error"></div>
                                    </div>

                                    <div class="col-md-6 col-sm-12 mb-2 ">
                                        <label class="mb-0" for="is_laxury_Property">Do you want to set this property as
                                            luxury
                                            property?<span class="text-error">*</span></label>
                                        <select name="is_laxury_Property" id="is_laxury_Property" class="form-control"
                                            data-required="yes">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>

                                        </select>
                                        <div class="error text-error"></div>
                                    </div>

                                    <div class="col-md-6 col-sm-12 mb-2 ">
                                        <label class="mb-0" for="is_hot_offer">Do you want to set this property as Hot Offer
                                            Property?<span class="text-error">*</span></label>
                                        <select name="is_hot_offer" id="is_hot_offer" class="form-control"
                                            data-required="yes">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>

                                        </select>
                                        <div class="error text-error"></div>
                                    </div>

                                </div>

                                <!-- start previous / next buttons -->
                                <div class="row mt-4">
                                    <div class="col-md-6 offset-3">
                                        <div class="row form-footer d-flex">
                                            <div class="col-md-6 text-end">
                                                <button type="button" id="prevBtn" onclick="nextPrev(-1, '')">
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
                                        <input type="file" class="property_image" id="property_image"
                                            name="propertyImage[]" accept="image/jpg, image/jpeg, image/png" multiple>
                                        @if ($errors->has('avtar'))
                                            <div class="error">{{ $errors->first('avtar') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-4 col-sm-12 mb-2">
                                        <label class="mb-0" for="publish">Publish</label>
                                        <select name="publish" id="publish" class="form-control" data-required="yes">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-sm-12 mb-2">
                                        <label class="mb-0" for="status">Status</label>
                                        <select name="status" id="status" class="form-control" data-required="yes">
                                            <option value="0">Disabled</option>
                                            <option value="1">Enabled</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- start previous / next buttons -->
                                <div class="row mt-4">
                                    <div class="col-md-6 offset-3">
                                        <div class="row form-footer d-flex">
                                            <div class="col-md-6 text-end">
                                                <button type="button" id="prevBtn" onclick="nextPrev(-1, '')">
                                                    <i class="fa fa-arrow-left"></i> Previous
                                                </button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" id="nextBtn"
                                                    onclick="nextPrev(1, 'PropertyStepForm3')">
                                                    Next <i class="fa fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end previous / next buttons -->

                            </form>

                            <div class="thank-you-page d-none">
                                <div class="properties-thank-you-content">
                                    <h1>Thank you !</h1>
                                    <h4>Awesome! Your Property is onboard.</h4>
                                    <p>Property has been added successfully and ID is: <snap style="font-weight: 800;"
                                            class="property-unique-id"></snap>
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-6 text-end">
                                        <a class="go-back cursor-pointer" onclick="window.location.reload();">
                                            <i class="fa fa-plus"></i> Add Property
                                        </a>
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
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('public/backend/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('public/backend/assets/js/propertyForm.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .then(editor => {
                editorInstance = editor;
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
