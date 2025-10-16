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
                        <li><a href="{{ route('admin.property-features.index') }}">All Property New</a></li>
                        <li><span>Create Property Feature</span></li>
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
                <h3 class="pb-3">Edit New Property</h3>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.property-new.update') }}" onsubmit="return onSubmitValidateForm();"
                            method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 offset-3">
                                    <div class="row">


                                        <div class="form-group">
                                            <label class="mb-0" for="image">Image<span
                                                    class="text-error">*</span></label>
                                            <input type="file" data-required="yes" class="form-control" id="image"
                                                name="image" accept="image/*" value="{{ old('image', $data->image) }}">
                                        </div>
                                        @error('image')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror


                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="name">Name<span
                                                        class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control"
                                                    id="name" name="name" placeholder="Feature Name" autofocus
                                                    value="{{ old('name', $data->name) }}">
                                            </div>
                                            @error('name')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>




                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="sort_order">Sort Order<span
                                                        class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control"
                                                    id="sort_order" name="sort_order" placeholder="Sort Order"
                                                    value="{{ old('sort_order', $data->sort_order) }}">
                                            </div>
                                            @error('sort_order')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="status">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>De
                                                        Active</option>
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
