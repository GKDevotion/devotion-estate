
@extends('backend.layouts.master')

@section('title')
Company Location Edit - Admin Panel
@endsection

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
                <h4 class="page-title pull-left d-none">Location Edit - {{ $data->name }}</h4>
                <ul class="breadcrumbs pull-left m-2">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.locations.index') }}">All Location</a></li>
                    <li><span>Edit Location</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3 text-end">
            <p class="float-end">
                @if (Auth::guard('admin')->user()->can('locations.edit'))
                    <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                        <i class="fa fa-save"></i> Update
                    </button>
                @endif
                <a href="{{ route('admin.locations.index') }}" class="btn btn-danger">
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
            <h3 class="pb-3">Update Location</h3>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.locations.update', $data->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-6 offset-3">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="mb-0" for="name">Name<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" data-required="yes" id="name" name="name" value="{{$data->name}}" placeholder="First Name" autofocus>
                                        </div>
                                        @error('name')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="mb-0" for="display_name">Display Name<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" data-required="yes" id="display_name" name="display_name" value="{{$data->display_name}}" placeholder="Display Name">
                                        </div>
                                        @error('display_name')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <div class="form-group">
                                            <label class="mb-0" for="address">Address<span class="text-error">*</span></label>
                                            <input type="text" data-required="yes" class="form-control" id="address" name="address" value="{{$data->address}}" placeholder="Address">
                                        </div>
                                        @error('address')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 col-sm-12 mb-2">
                                        <label class="mb-0" for="continent_id">Continent<span class="text-error">*</span></label>
                                        <select name="continent_id" id="continent_id" class="form-control get-country-list continent-id required-field" data-id="country_id" data-required="yes">
                                            <option value="0" >Select Continent</option>
                                            @foreach ($continentObj as $ar)
                                                <option value="{{ $ar->id }}" {{$data->continent_id == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="error text-error"></div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 mb-2">
                                        <label class="mb-0" for="country_id">Country<span class="text-error">*</span></label>
                                        <select name="country_id" id="country_id" class="form-control get-state-list country-id required-field" data-id="state_id" data-required="yes">
                                            <option value="0" >Select Country</option>
                                            @foreach ($countryObj as $ar)
                                                <option value="{{ $ar->id }}" {{$data->country_id == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="error text-error"></div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 mb-2">
                                        <label class="mb-0" for="state_id">State<span class="text-error">*</span></label>
                                        <select name="state_id" id="state_id" class="form-control get-city-list state-id required-field" data-id="city_id" data-required="yes">
                                            <option value="0" >Select State</option>
                                            @foreach ($stateObj as $ar)
                                                <option value="{{ $ar->id }}" {{$data->state_id == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="error text-error"></div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 mb-2">
                                        <label class="mb-0" for="city_id">City<span class="text-error">*</span></label>
                                        <select name="city_id" id="city_id" class="form-control city-id required-field" data-required="yes">
                                            <option value="0" >Select City</option>
                                            @foreach ($cityObj as $ar)
                                                <option value="{{ $ar->id }}" {{$data->city_id == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="error text-error"></div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 mb-2">
                                        <label class="mb-0" for="zipcode">Zipcode<span class="text-error">*</span></label>
                                        <input type="text" class="form-control required-field" id="zipcode" name="zipcode" placeholder="Zipcode" value="{{$data->zipcode}}" data-required="yes">
                                        <div class="error text-error"></div>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label class="mb-0" for="status">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="1" {{$data->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{$data->status == 0 ? 'selected' : '' }}>De Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success pr-4 pl-4" id="submitForm">
                                    <i class="fa fa-save"></i> Update
                                </button>
                                <a href="{{ route('admin.locations.index') }}" class="btn btn-danger pr-4 pl-4">
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
