@extends('backend.layouts.master')

@section('title')
    Properties - Admin Panel
@endsection
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
@section('styles')
    <style>
        .form-check-label {
            text-transform: capitalize;
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
                        <li><span>Create Properties </span></li>
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
            <!-- data table start -->
            <div class="col-12 mt-3">
                {{-- <h3 class="pb-3">Create Properties</h3> --}}
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.properties.store') }}" onsubmit="return onSubmitValidateForm();"
                            method="POST" autocomplete="off">
                            @csrf
                            <div class="row">

                                <div class="title-container text-center mb-3">
                                    <h1>PROPERTY DETAILS</h1>
                                    <p>Provide following details of property.</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="unique_code">Unique Code<span
                                                class="text-error">*</span></label>
                                        <input type="text" data-required="yes" class="form-control" id="unique_code"
                                            name="unique_code" placeholder="unique_code" autofocus>
                                    </div>
                                    @error('unique_code')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="name">Name<span class="text-error">*</span></label>
                                        <input type="text" data-required="yes" class="form-control" id="name"
                                            name="name" placeholder="Property Name/Title" autofocus>
                                    </div>
                                    @error('type_name')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="h1_tag">H1 Tag<span class="text-error">*</span></label>
                                        <input type="text" data-required="yes" class="form-control" id="h1_tag"
                                            name="h1_tag" placeholder="H1 Tag Property Name/Title" autofocus>
                                    </div>
                                    @error('h1_tag')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="seo_title">Seo Title<span
                                                class="text-error">*</span></label>
                                        <input type="text" data-required="yes" class="form-control" id="seo_title"
                                            name="seo_title" placeholder="Property Seo Title" autofocus>
                                    </div>
                                    @error('seo_title')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="slug">Slug<span class="text-error">*</span></label>
                                        <input type="text" data-required="yes" class="form-control" id="slug"
                                            name="slug" placeholder="" autofocus>
                                    </div>
                                    @error('slug')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-12 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="meta_description">Meta Description<span
                                                class="text-error">*</span></label>
                                        <input type="text" data-required="yes" class="form-control" id="meta_description"
                                            name="meta_description" placeholder="" autofocus>
                                    </div>
                                    @error('slug')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group  mb-2">
                                    <label for="description">Description</label>
                                    <textarea type="text" class="ckeditor form-control" id="description" name="description"
                                        placeholder="description" rows="16"> {{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="error">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="property_purpose">Purpose <span
                                                class="text-error">*</span></label>
                                        <select class="form-control" id="property_purpose" name="property_purpose"
                                            data-required="yes">
                                            <option value="">Select Purpose Of Property</option>
                                            <option value="0" {{ old('property_purpose') == '0' ? 'selected' : '' }}>
                                                For Sell</option>
                                            <option value="1" {{ old('property_purpose') == '1' ? 'selected' : '' }}>
                                                For Rent</option>
                                        </select>
                                    </div>
                                    @error('property_purpose')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="property_type">Type <span
                                                class="text-error">*</span></label>
                                        <select class="form-control" id="property_type" name="property_type"
                                            data-required="yes">
                                            <option value="">Select Property Type</option>
                                            <option value="0" {{ old('property_type') == '0' ? 'selected' : '' }}>
                                                Residential</option>
                                            <option value="1" {{ old('property_type') == '1' ? 'selected' : '' }}>
                                                Commercial</option>
                                        </select>
                                    </div>
                                    @error('property_type')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="property_sub_type">Sub Type <span
                                                class="text-error">*</span></label>
                                        <select class="form-control" id="property_sub_type" name="property_sub_type"
                                            data-required="yes">
                                            <option value="">Select Property Sub Type</option>
                                            <option value="0"
                                                {{ old('property_sub_type') == '0' ? 'selected' : '' }}>
                                                For Sell</option>
                                            <option value="1"
                                                {{ old('property_sub_type') == '1' ? 'selected' : '' }}>
                                                For Rent</option>
                                        </select>
                                    </div>
                                    @error('property_sub_type')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-2">
                                    <div class="form-group text-center">
                                        <label class="mb-3 d-block">Furnished Status</label>

                                        <div class="d-flex justify-content-center gap-5 mt-3">
                                            <!-- Furnished -->
                                            <div class="text-center">
                                                <input class="form-check-input" type="radio" name="furnished_status"
                                                    id="furnished_yes" value="1"
                                                    {{ old('furnished_status') == '1' ? 'checked' : '' }}
                                                    style="width: 20px; height: 20px;"> <!-- Bigger circle -->
                                                <label class="form-check-label d-block mt-2" for="furnished_yes">
                                                    Furnished
                                                </label>
                                            </div>

                                            <!-- Unfurnished -->
                                            <div class="text-center">
                                                <input class="form-check-input" type="radio" name="furnished_status"
                                                    id="furnished_no" value="0"
                                                    {{ old('furnished_status') == '0' ? 'checked' : '' }}
                                                    style="width: 20px; height: 20px;"> <!-- Bigger circle -->
                                                <label class="form-check-label d-block mt-2" for="furnished_no">
                                                    Unfurnished
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    @error('furnished_status')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-2">
                                    <div class="form-group text-center">
                                        <label class="mb-3 d-block">Completion Status</label>

                                        <div class="d-flex justify-content-center gap-5 mt-3">
                                            <!-- Furnished -->
                                            <div class="text-center">
                                                <input class="form-check-input" type="radio" name="completion_status"
                                                    id="completion_yes" value="1"
                                                    {{ old('completion_status') == '1' ? 'checked' : '' }}
                                                    style="width: 20px; height: 20px;"> <!-- Bigger circle -->
                                                <label class="form-check-label d-block mt-2" for="completion_yes">
                                                    Ready
                                                </label>
                                            </div>

                                            <!-- Unfurnished -->
                                            <div class="text-center">
                                                <input class="form-check-input" type="radio" name="completion_status"
                                                    id="completion_no" value="0"
                                                    {{ old('completion_status') == '0' ? 'checked' : '' }}
                                                    style="width: 20px; height: 20px;"> <!-- Bigger circle -->
                                                <label class="form-check-label d-block mt-2" for="completion_no">
                                                    Secondary
                                                </label>
                                            </div>

                                            <div class="text-center">
                                                <input class="form-check-input" type="radio" name="completion_status"
                                                    id="completion_no" value="0"
                                                    {{ old('completion_status') == '0' ? 'checked' : '' }}
                                                    style="width: 20px; height: 20px;"> <!-- Bigger circle -->
                                                <label class="form-check-label d-block mt-2" for="completion_no">
                                                    Off Plan
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    @error('completion_status')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-2">
                                    <div class="form-group text-center">
                                        <label class="mb-3 d-block">Ownership Status</label>

                                        <div class="d-flex justify-content-center gap-5 mt-3">
                                            <!-- Furnished -->
                                            <div class="text-center">
                                                <input class="form-check-input" type="radio" name="ownership_status"
                                                    id="ownership_yes" value="1"
                                                    {{ old('ownership_status') == '1' ? 'checked' : '' }}
                                                    style="width: 20px; height: 20px;"> <!-- Bigger circle -->
                                                <label class="form-check-label d-block mt-2" for="ownership_yes">
                                                    Freehold
                                                </label>
                                            </div>

                                            <!-- Unfurnished -->
                                            <div class="text-center">
                                                <input class="form-check-input" type="radio" name="ownership_status"
                                                    id="ownership_no" value="0"
                                                    {{ old('ownership_status') == '0' ? 'checked' : '' }}
                                                    style="width: 20px; height: 20px;"> <!-- Bigger circle -->
                                                <label class="form-check-label d-block mt-2" for="ownership_no">
                                                    Leasehold
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    @error('ownership_status')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="title-container text-center mb-3">
                                    <h3>SELL DETAILS</h3>
                                </div>

                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="price">Price(AED)<span
                                                class="text-error">*</span></label>
                                        <input type="number" data-required="yes" class="form-control" id="price"
                                            name="price" placeholder="Price(AED)" min="0" step="1"
                                            autofocus>
                                    </div>
                                    @error('price')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="financing_available">Financing Available
                                            <span class="text-error">*</span></label>
                                        <select class="form-control" id="financing_available" name="financing_available"
                                            data-required="yes">
                                            <option value="">Select Property Financing Available</option>
                                            <option value="0"
                                                {{ old('financing_available') == '0' ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="1"
                                                {{ old('financing_available') == '1' ? 'selected' : '' }}>
                                                No</option>
                                            <option value="2"
                                                {{ old('financing_available') == '2' ? 'selected' : '' }}>
                                                Not Sure</option>
                                        </select>
                                    </div>
                                    @error('financing_available')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="finance_institute">Finance Institute
                                            Name<span class="text-error">*</span></label>
                                        <input type="text" data-required="yes" class="form-control"
                                            id="finance_institute" name="finance_institute"
                                            placeholder="Finance Institute" min="0" step="1" autofocus>

                                    </div>
                                    @error('finance_institute')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="title-container text-center mb-3">
                                    <h3>OTHER(S) DETAILS</h3>
                                </div>

                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="area">Area(Square Feet.)<span
                                                class="text-error">*</span></label>
                                        <input type="number" data-required="yes" class="form-control" id="area"
                                            name="area" placeholder="Area (Square Feet)" min="0"
                                            step="1" autofocus>
                                    </div>
                                    @error('area')
                                        <div class="error text-error text-center">{{ $message }}</div>
                                    @else
                                        @if (!old('area'))
                                            <div class="text-error text-center">0.00 Sq.Meter/0.00 Sq.Yd Please
                                                provide
                                                total property area.
                                            </div>
                                        @endif
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="rera_number">RERA Number<span
                                                class="text-error">*</span></label>
                                        <input type="number" data-required="yes" class="form-control" id="rera_number"
                                            name="rera_number" placeholder="RERA No." min="0" step="1"
                                            autofocus>

                                    </div>
                                    @error('rera_number')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="permit_number">Permit Number<span
                                                class="text-error">*</span></label>
                                        <input type="number" data-required="yes" class="form-control"
                                            id="permit_number" name="permit_number" placeholder="PERMIT No."
                                            min="0" step="1" autofocus>

                                    </div>
                                    @error('permit_number')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="title-container mt-3">
                                    <div class="row">
                                        <!-- Address Section -->
                                        <div class="col-md-8 mb-2">
                                            <div class="text-center mb-2">
                                                <h3 class="">Location & Address</h3>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-0" for="address">Address <span
                                                        class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control"
                                                    id="address" name="address" placeholder="Address" autofocus>
                                            </div>
                                            @error('address')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- List Owner Section -->
                                        <div class="col-md-4 mb-2">
                                            <div class="text-center mb-2">
                                                <h3 class="">Agent Detail(s)</h3>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-0" for="list_owner">List Owner <span
                                                        class="text-error">*</span></label>
                                                <select class="form-control" id="list_owner" name="list_owner"
                                                    data-required="yes">
                                                    <option value="">Select Agent</option>
                                                    <option value="1">owner</option>
                                                </select>
                                            </div>
                                            @error('list_owner')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>



                                        <div class="title-container text-center mb-3 mt-3">
                                            <h1>Additional features</h1>
                                            <p>Provide details of additional features(if any.)</p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label d-block">Additional Features*</label>
                                            <div class="row g-2">
                                                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="Balcony"
                                                            onclick="SaveAdditionalFeature('Balcony')">
                                                        <label class="form-check-label" for="Balcony"
                                                            onclick="additionalFeatureChecked('Balcony')">
                                                            Balcony
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="emergency_exit"
                                                            onclick="SaveAdditionalFeature('emergency_exit')">
                                                        <label class="form-check-label" for="emergency_exit"
                                                            onclick="additionalFeatureChecked('emergency_exit')">
                                                            Emergency Exit
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="CCTV"
                                                            onclick="SaveAdditionalFeature('CCTV')">
                                                        <label class="form-check-label" for="CCTV"
                                                            onclick="additionalFeatureChecked('CCTV')">
                                                            CCTV
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="free_wifi"
                                                            onclick="SaveAdditionalFeature('free_wifi')">
                                                        <label class="form-check-label" for="free_wifi"
                                                            onclick="additionalFeatureChecked('free_wifi')">
                                                            Free Wi-Fi
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="free_parking"
                                                            onclick="SaveAdditionalFeature('free_parking')">
                                                        <label class="form-check-label" for="free_parking"
                                                            onclick="additionalFeatureChecked('free_parking')">
                                                            Free Parking In The Area
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="air_conditioning"
                                                            onclick="SaveAdditionalFeature('air_conditioning')">
                                                        <label class="form-check-label" for="air_conditioning"
                                                            onclick="additionalFeatureChecked('air_conditioning')">
                                                            Air Conditioning
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="security_guard"
                                                            onclick="SaveAdditionalFeature('security_guard')">
                                                        <label class="form-check-label" for="security_guard"
                                                            onclick="additionalFeatureChecked('security_guard')">
                                                            Security Guard
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="terrace"
                                                            onclick="SaveAdditionalFeature('terrace')">
                                                        <label class="form-check-label" for="terrace"
                                                            onclick="additionalFeatureChecked('terrace')">
                                                            Terrace
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="laundry"
                                                            onclick="SaveAdditionalFeature('laundry')">
                                                        <label class="form-check-label" for="laundry"
                                                            onclick="additionalFeatureChecked('laundry')">
                                                            Laundry Service
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="elevator"
                                                            onclick="SaveAdditionalFeature('elevator')">
                                                        <label class="form-check-label" for="elevator"
                                                            onclick="additionalFeatureChecked('elevator')">
                                                            Elevator Lift
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="swimming_pool"
                                                            onclick="SaveAdditionalFeature('swimming_pool')">
                                                        <label class="form-check-label" for="swimming_pool"
                                                            onclick="additionalFeatureChecked('swimming_pool')">
                                                            Swimming pool
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="gym"
                                                            onclick="SaveAdditionalFeature('gym')">
                                                        <label class="form-check-label" for="gym"
                                                            onclick="additionalFeatureChecked('gym')">
                                                            Gym
                                                        </label>
                                                    </div>
                                                </div>




                                                <div class="title-container text-center mb-3 mt-3">
                                                    <fieldset>
                                                        <h2 class="fs-title">Upload(s)</h2>
                                                        <h3 class="fs-subtitle">Provide images of property.</h3>

                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label for="propertyImages" class="form-label">Upload
                                                                    File</label>

                                                                <!-- Preview Zone -->
                                                                <div class="preview-zone d-none border rounded mb-3">
                                                                    <div
                                                                        class="p-3 d-flex justify-content-between align-items-center bg-light border-bottom">
                                                                        <b>Preview</b>
                                                                        <div>
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm remove-preview">
                                                                                <i class="fa-solid fa-xmark me-1"></i>
                                                                                Reset
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="box-body p-3 d-flex flex-wrap gap-2">
                                                                        <!-- Image previews will be appended here -->
                                                                    </div>
                                                                </div>

                                                                <!-- Dropzone -->
                                                                <div class="dropzone-wrapper border p-5 text-center rounded position-relative"
                                                                    style="cursor:pointer;">
                                                                    <div class="dropzone-desc">
                                                                        <i
                                                                            class="fa-solid fa-cloud-arrow-down fa-2xl mb-3"></i>
                                                                        <!-- FA6 free -->

                                                                        <p>Choose image files or drag them here.</p>
                                                                    </div>
                                                                    <input type="file" id="propertyImages"
                                                                        name="propertyImages[]"
                                                                        class="dropzone position-absolute top-0 start-0 w-100 h-100"
                                                                        style="opacity:0;" multiple>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="status">Status</label>
                                                        <select class="form-control" name="status" id="status">
                                                            <option value="1">Active</option>
                                                            <option value="0">De-Active</option>
                                                        </select>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>





                                        <div class="row mt-4">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-success pr-4 pl-4" id="submitForm">
                                                    <i class="fa fa-save"></i> Save
                                                </button>
                                                <a href="{{ route('admin.properties.index') }}"
                                                    class="btn btn-danger pr-4 pl-4">
                                                    <i class="fa fa-arrow-left"></i> Back
                                                </a>
                                            </div>
                                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- data table end -->

            <script>
                ClassicEditor
                    .create(document.querySelector('#description'))
                    .catch(error => {
                        console.error(error);
                    });

                const input = document.getElementById('propertyImages');
                const previewZone = document.querySelector('.preview-zone');
                const boxBody = previewZone.querySelector('.box-body');
                const resetBtn = previewZone.querySelector('.remove-preview');

                function updatePreview(files) {
                    boxBody.innerHTML = '';
                    if (files.length === 0) {
                        previewZone.classList.add('d-none');
                        return;
                    }
                    previewZone.classList.remove('d-none');

                    Array.from(files).forEach(file => {
                        if (!file.type.startsWith('image/')) return;
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.height = '100px';
                            img.style.width = 'auto';
                            img.classList.add('border', 'p-1', 'rounded');
                            boxBody.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    });
                }

                // When files are selected
                input.addEventListener('change', (e) => {
                    updatePreview(e.target.files);
                });

                // Reset button
                resetBtn.addEventListener('click', () => {
                    input.value = '';
                    boxBody.innerHTML = 'No images to show.';
                    previewZone.classList.add('d-none');
                });

                // Optional: drag and drop styling
                const dropzoneWrapper = document.querySelector('.dropzone-wrapper');
                dropzoneWrapper.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropzoneWrapper.classList.add('border-primary');
                });
                dropzoneWrapper.addEventListener('dragleave', () => {
                    dropzoneWrapper.classList.remove('border-primary');
                });
                dropzoneWrapper.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dropzoneWrapper.classList.remove('border-primary');
                    input.files = e.dataTransfer.files;
                    updatePreview(input.files);
                });
            </script>

        </div>
    </div>
@endsection
