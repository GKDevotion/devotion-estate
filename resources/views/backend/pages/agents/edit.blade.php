@extends('backend.layouts.master')

@section('title')
    Agent Edit - Admin Panel
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
                    <h4 class="page-title pull-left d-none">Agent Edit</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.agents.index') }}">All Agents</a></li>
                        <li><span>Edit Agent - {{ $dataObj->login_by }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <p class="float-end">
                    @if (Auth::guard('admin')->user()->can('agents.edit'))
                        <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                            <i class="fa fa-save"></i> Update
                        </button>
                    @endif
                    <a href="{{ route('admin.agents.index') }}" class="btn btn-danger">
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
                <h3 class="pb-3">Update Agents</h3>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.agents.update', $dataObj->id) }}" method="POST" autocomplete="off">
                            @method('PUT')
                            @csrf
                            <div class="row">

                                <div class="col-md-12 mb-2">
                                    <label>Old Image</label><br>
                                    @if ($dataObj->image)
                                        <img src="{{ asset('storage/app/public/agent/' . $dataObj->image) }}" width="200"
                                            height="100" style="object-fit:cover;">
                                    @else
                                        <p>No image uploaded</p>
                                    @endif
                                </div>

                                <div class="col-md-4 col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="image">Upload New Image</label>
                                        <input type="file" name="image" class="form-control">
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="login_by">Login By <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="login_by" name="login_by"
                                            placeholder="Login By" value="{{ old('login_by', $dataObj->login_by) }}">
                                        @error('login_by')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="first_name">First Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            placeholder="First Name" value="{{ old('first_name', $dataObj->first_name) }}">
                                        @error('first_name')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-4 col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="last_name">Last Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            placeholder="Last Name" value="{{ old('last_name', $dataObj->last_name) }}">
                                        @error('last_name')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="email_id">Email ID <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="email_id" name="email_id"
                                            placeholder="Enter Email ID" value="{{ old('email_id', $dataObj->email_id) }}">
                                        @error('email_id')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-3 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Enter Password" value="">
                                        @error('password')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-3 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="mobile_no">Contact No. <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="mobile_no" name="mobile_no"
                                            placeholder="Enter Password"
                                            value="{{ old('mobile_no', $dataObj->mobile_no) }}">
                                        @error('mobile_no')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="designation_id">Designation <span
                                                class="text-danger">*</span></label>
                                        <select name="designation_id" id="designation_id" class="form-control">
                                            <option value="">Select Designation</option>
                                            @foreach ($designationObj as $dt)
                                                <option value="{{ $dt->id }}"
                                                    {{ $dataObj->designation_id == $dt->id ? 'selected' : '' }}>
                                                    {{ $dt->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('designation_id')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="login">Login Allow <span
                                                class="text-danger">*</span></label>
                                        <select name="login" id="login" class="form-control">
                                            <option value="0" {{ 0 == $dataObj->login ? 'selected' : '' }}>Disabled
                                            </option>
                                            <option value="1" {{ 1 == $dataObj->login ? 'selected' : '' }}>Enabled
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="status">status <span
                                                class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="0" {{ 0 == $dataObj->status ? 'selected' : '' }}>Disabled
                                            </option>
                                            <option value="1" {{ 1 == $dataObj->status ? 'selected' : '' }}>Enabled
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-success pr-4 pl-4" id="submitForm">
                                        <i class="fa fa-save"></i> Update
                                    </button>
                                    <a href="{{ route('admin.agents.index') }}" class="btn btn-danger pr-4 pl-4">
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
    <script></script>
@endsection
