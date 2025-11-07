
@extends('backend.layouts.master')

@section('title')
Owner Create - Admin Panel
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

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
        <div class="col-sm-7">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left d-none">Owner Create</h4>
                <ul class="breadcrumbs pull-left m-2">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.owners.index') }}">All Owners</a></li>
                    <li><span>Create Owner</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <p class="float-end">
                @if (Auth::guard('admin')->user()->can('owners.create'))
                    <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                        <i class="fa fa-save"></i> Save
                    </button>
                @endif
                <a href="{{ route('admin.owners.index') }}" class="btn btn-danger">
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
            <h3 class="pb-3">Create Owners</h3>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.owners.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">

                            <div class="col-md-4 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="login_by">Login By</label>
                                    <input type="text" class="form-control" id="login_by" name="login_by" placeholder="Enter Name">
                                    @error('login_by')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name">
                                    @error('first_name')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name">
                                    @error('last_name')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="email_id">Email ID</label>
                                    <input type="text" class="form-control" id="email_id" name="email_id" placeholder="Enter Email ID">
                                    @error('email_id')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-3 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                    @error('password')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-3 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Password">
                                    @error('password_confirmation')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="mobile_no">Contact No</label>
                                    <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Enter Mobile Number">
                                    @error('mobile_no')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="login">Login Allow</label>
                                    <select name="login" id="login" class="form-control">
                                        <option value="0">Disabled</option>
                                        <option value="1">Enabled</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 mb-2">
                                <label class="mb-0" for="status">status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="0">Disabled</option>
                                    <option value="1">Enabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="continent_id">Continent<span class="text-error">*</span></label>
                                    <select name="continent_id" id="continent_id" class="form-control get-country-list continent-id" data-id="country_id">
                                        <option value="" >Select Continent</option>
                                        @foreach ($continentArr as $ar)
                                            <option value="{{ $ar->id }}">{{ $ar->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('continent_id')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="country_id">Country<span class="text-error">*</span></label>
                                    <select name="country_id" id="country_id" class="form-control get-state-list country-id" data-id="state_id">
                                        <option value="" >Select Country</option>
                                    </select>
                                    @error('country_id')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="state_id">State<span class="text-error">*</span></label>
                                    <select name="state_id" id="state_id" class="form-control get-city-list state-id" data-id="city_id">
                                        <option value="" >Select State</option>
                                    </select>
                                    @error('state_id')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="city_id">City<span class="text-error">*</span></label>
                                    <select name="city_id" id="city_id" class="form-control city-id">
                                        <option value="" >Select City</option>
                                    </select>
                                    @error('city_id')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="zipcode">Zipcode<span class="text-error">*</span></label>
                                    <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zipcode" value="">
                                    @error('zipcode')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="address">Address<span class="text-error">*</span></label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="">
                                    @error('address')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success pr-4 pl-4" id="submitForm">
                                    <i class="fa fa-save"></i> Save
                                </button>
                                <a href="{{ route('admin.owners.index') }}" class="btn btn-danger pr-4 pl-4">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->

        <!-- extra hidden values -->
        <span class="get-continent-list-url d-none">{{url('api/get-continent-list')}}</span>
        <span class="get-country-list-url d-none">{{url('api/get-country-list')}}</span>
        <span class="get-state-list-url d-none">{{url('api/get-state-list')}}</span>
        <span class="get-city-list-url d-none">{{url('api/get-city-list')}}</span>
    </div>
</div>
@endsection

@section('scripts')
<script>

</script>
@endsection
