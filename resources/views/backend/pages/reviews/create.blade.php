@extends('backend.layouts.master')

@section('title')
    Review Create - Admin Panel
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
                    <h4 class="page-title pull-left d-none">Review Create</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.reviews.index') }}">All Review</a></li>
                        <li><span>Create Review</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <p class="float-end">
                    @if (Auth::guard('admin')->user()->can('reviews.create'))
                        <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                            <i class="fa fa-save"></i> Save
                        </button>
                    @endif
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-danger">
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
                <h3 class="pb-3">Create Review</h3>
                <div class="card">
                    <div class="card-body">
{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

                        <form action="{{ route('admin.reviews.store') }}" onsubmit="return onSubmitValidateForm();"
                            method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 offset-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="name">Name<span
                                                        class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control"
                                                    id="name" name="name" placeholder="username" autofocus>
                                            </div>
                                            @error('name')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="email">Email<span
                                                        class="text-error">*</span></label>
                                                <input type="email" data-required="yes" class="form-control"
                                                    id="email" name="email" placeholder="Email ">
                                            </div>
                                            @error('email')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="contact_no">Contact No.<span
                                                        class="text-error">*</span></label>
                                                <input type="number" data-required="yes" class="form-control"
                                                    id="contact_no" name="contact_no" placeholder="Contact.no">
                                            </div>
                                            @error('contact_no')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 col-sm-12 mb-3">
                                            <label class="mb-0" for="review">Review <span
                                                    class="text-error">*</span></label>
                                            <textarea name="review" id="review" class="form-control required-field" rows="4"
                                                placeholder="Write your review..." data-required="yes"></textarea>
                                            <div class="error text-error"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="mb-0" for="rating">Rating <span
                                                    class="text-error">*</span></label>
                                            <select name="rating" id="rating" class="form-control required-field"
                                                data-required="yes">
                                                <option value="">Select Rating</option>
                                                <option value="1">1 - Very Poor</option>
                                                <option value="2">2 - Poor</option>
                                                <option value="3">3 - Average</option>
                                                <option value="4">4 - Good</option>
                                                <option value="5">5 - Excellent</option>
                                            </select>
                                            <div class="error text-error"></div>
                                        </div>


                                        <div class="col-md-4 mb-2">
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
                                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-danger pr-4 pl-4">
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
