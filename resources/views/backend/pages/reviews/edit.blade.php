
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
                    <li><a href="{{ route('admin.reviews.index') }}">All Location</a></li>
                    <li><span>Edit Location</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3 text-end">
            <p class="float-end">
                @if (Auth::guard('admin')->user()->can('reviews.edit'))
                    <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                        <i class="fa fa-save"></i> Update
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
            <h3 class="pb-3">Update Location</h3>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.reviews.update', $data->id) }}" method="POST">
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
                                            <label class="mb-0" for="email">Display Name<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" data-required="yes" id="email" name="email" value="{{$data->email}}" placeholder="email">
                                        </div>
                                        @error('email')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <div class="form-group">
                                            <label class="mb-0" for="contact_no">Contact No.<span class="text-error">*</span></label>
                                            <input type="text" data-required="yes" class="form-control" id="contact_no" name="contact_no" value="{{$data->contact_no}}" placeholder="contact_no">
                                        </div>
                                        @error('contact_no')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
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
