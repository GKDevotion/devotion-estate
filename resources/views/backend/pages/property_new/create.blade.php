@extends('backend.layouts.master')

@section('title')
    Property New - Admin Panel
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
                    <h4 class="page-title pull-left d-none">Property New</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.property-new.index') }}">All Property New</a></li>
                        <li><span>Create Property New</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <p class="float-end">
                    @if (Auth::guard('admin')->user()->can('property-new.create'))
                        <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                            <i class="fa fa-save"></i> Save
                        </button>
                    @endif
                    <a href="{{ route('admin.property-new.index') }}" class="btn btn-danger">
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
                <h3 class="pb-3">Create New Property</h3>
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('admin.property-new.store') }}" onsubmit="return onSubmitValidateForm();"
                            method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 offset-3">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">

                                            <div class="form-group">
                                                <label class="mb-0" for="image">Image<span
                                                        class="text-error">*</span></label>
                                                <input type="file" data-required="yes" class="form-control"
                                                    id="image" name="image" accept="image/*">
                                            </div>
                                            @error('image')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror


                                            <div class="form-group">
                                                <label class="mb-0" for="name">Name<span
                                                        class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control"
                                                    id="name" name="name" placeholder="Feature Name" autofocus>
                                            </div>
                                            @error('name')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>



                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="purpose">
                                                    Purpose <span class="text-error">*</span>
                                                </label>
                                                <select class="form-control" id="purpose" name="purpose"
                                                    data-required="yes">
                                                    <option value="">Select Purpose Of Property</option>
                                                    <option value="0" {{ old('purpose') === '0' ? 'selected' : '' }}>
                                                        For Sell
                                                    </option>
                                                    <option value="1" {{ old('purpose') === '1' ? 'selected' : '' }}>
                                                        For Rent
                                                    </option>
                                                </select>
                                            
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="type">Type <span
                                                        class="text-error">*</span></label>
                                                <select class="form-control" id="type" name="type"
                                                    data-required="yes">
                                                    <option value="">Select Type</option>
                                                    <option value="0" {{ old('type') == '0' ? 'selected' : '' }}>
                                                        Residential</option>
                                                    <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>
                                                        Commercial</option>
                                                </select>
                                            </div>
                                            @error('type')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="publish">Publish <span
                                                        class="text-error">*</span></label>
                                                <select class="form-control" id="publish" name="publish"
                                                    data-required="yes">
                                                    <option value="">Select publish</option>
                                                    <option value="0" {{ old('publish') == '0' ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="1" {{ old('publish') == '1' ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </div>
                                            @error('publish')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="area">Area<span
                                                        class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control"
                                                    id="area" name="area" placeholder="Enter Area">
                                            </div>
                                            @error('area')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="price">Price<span
                                                        class="text-error">*</span></label>
                                                <input type="number" data-required="yes" class="form-control"
                                                    id="price" name="price" placeholder="Enter Price"
                                                    min="0" step="any">
                                            </div>
                                            @error('price')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="address">Address<span
                                                        class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control"
                                                    id="address" name="address" placeholder="Enter Address">
                                            </div>
                                            @error('address')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="sort_order">Sort Order<span
                                                        class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control"
                                                    id="sort_order" name="sort_order" placeholder="Sort Order">
                                            </div>
                                            @error('sort_order')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="status">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="1">Active</option>
                                                    <option value="0">De Active</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-success pr-4 pl-4" id="submitForm">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                    <a href="{{ route('admin.property-new.index') }}" class="btn btn-danger pr-4 pl-4">
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
