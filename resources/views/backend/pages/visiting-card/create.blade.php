
@extends('backend.layouts.master')

@section('title')
Visiting Card Create - Admin Panel
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
                <h4 class="page-title pull-left d-none">Visiting Card Create</h4>
                <ul class="breadcrumbs pull-left m-2">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.visiting-card.index') }}">All Visiting Card</a></li>
                    <li><span>Create Visiting Card</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <p class="float-end">
                @if ( true || Auth::guard('admin')->user()->can('visiting-card.create'))
                    <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                        <i class="fa fa-save"></i> Save
                    </button>
                @endif
                <a href="{{ route('admin.visiting-card.index') }}" class="btn btn-danger">
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
            <h3 class="pb-3">Create Visiting Card</h3>
            <div class="card">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.visiting-card.store') }}" enctype="multipart/form-data" onsubmit="return onSubmitValidateForm();" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12 col-xl-4">
                                <label class="mb-0" for="avtar">Avtar</label>
                                <input type="file" class="avtar" id="avtar" name="avtar" accept="image/jpg, image/jpeg, image/png">
                                @if($errors->has('avtar'))
                                    <div class="error">{{ $errors->first('avtar') }}</div>
                                @endif
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="row">
                                    <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label class="mb-0" for="company_id">Company<span class="text-error">*</span></label>
                                            <select class="form-control company_id" data-required="yes" id="company_id" name="company_id">
                                                <option value="">Select Company</option>
                                                @foreach( $companyArr as $id=>$name )
                                                    <option value="{{$id}}">{{$name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('company_id')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                        <div class="mb-3 form-group">
                                            <label for="name">Name<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Name') }}" value="" autofocus>
                                            @if($errors->has('name'))
                                                <div class="error">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                        <div class="mb-3 form-group">
                                            <label for="email">Email<span class="text-error">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('Email') }}" value="">
                                            @if($errors->has('email'))
                                                <div class="error">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                        <div class="mb-3 form-group">
                                            <label for="position">Position<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" id="position" name="position" placeholder="{{ __('Position') }}" value="">
                                            @if($errors->has('position'))
                                                <div class="error">{{ $errors->first('position') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                        <div class="mb-3 form-group">
                                            <label for="mobile_number">Mobile Number<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="{{ __('Mobile Number') }}" value="">
                                            @if($errors->has('mobile_number'))
                                                <div class="error">{{ $errors->first('mobile_number') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                        <div class="mb-3 form-group">
                                            <label for="office_number">Office Number<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" id="office_number" name="office_number" placeholder="{{ __('Office Number') }}" value="" autofocus>
                                            @if($errors->has('office_number'))
                                                <div class="error">{{ $errors->first('office_number') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                        <div class="mb-3 form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="1">Active</option>
                                                <option value="0">De-Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="office_address_1">Registered Office Address</label>
                                    <input type="text" class="form-control" id="office_address_1" name="office_address_1" placeholder="{{ __('Registered Address') }}" value="">
                                    @if($errors->has('office_address_1'))
                                        <div class="error">{{ $errors->first('office_address_1') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="office_address_2">Sales Office Address</label>
                                    <input type="text" class="form-control" id="office_address_2" name="office_address_2" placeholder="{{ __('Sales Office Address') }}" value="">
                                    @if($errors->has('office_address_2'))
                                        <div class="error">{{ $errors->first('office_address_2') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" class="form-control" id="facebook" name="facebook" placeholder="{{ __('Facebook') }}" value="">
                                    @if($errors->has('facebook'))
                                        <div class="error">{{ $errors->first('facebook') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" class="form-control" id="instagram" name="instagram" placeholder="{{ __('Instagram') }}" value="">
                                    @if($errors->has('instagram'))
                                        <div class="error">{{ $errors->first('instagram') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="tiktok">TikTok</label>
                                    <input type="text" class="form-control" id="tiktok" name="tiktok" placeholder="{{ __('TikTok') }}" value="">
                                    @if($errors->has('tiktok'))
                                        <div class="error">{{ $errors->first('tiktok') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="pinterest">Pinterest</label>
                                    <input type="text" class="form-control" id="pinterest" name="pinterest" placeholder="{{ __('Pinterest') }}" value="">
                                    @if($errors->has('pinterest'))
                                        <div class="error">{{ $errors->first('pinterest') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="snapchat">Snapchat</label>
                                    <input type="text" class="form-control" id="snapchat" name="snapchat" placeholder="{{ __('Snapchat') }}" value="">
                                    @if($errors->has('snapchat'))
                                        <div class="error">{{ $errors->first('snapchat') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="quora">Quora</label>
                                    <input type="text" class="form-control" id="quora" name="quora" placeholder="{{ __('Quora') }}" value="">
                                    @if($errors->has('quora'))
                                        <div class="error">{{ $errors->first('quora') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="linkedin">Linked In</label>
                                    <input type="text" class="form-control" id="linkedin" name="linkedin" placeholder="{{ __('Linked In') }}" value="">
                                    @if($errors->has('linkedin'))
                                        <div class="error">{{ $errors->first('linkedin') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="twitter">Twitter</label>
                                    <input type="text" class="form-control" id="twitter" name="twitter" placeholder="{{ __('Twitter') }}" value="">
                                    @if($errors->has('twitter'))
                                        <div class="error">{{ $errors->first('twitter') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="youtube">Youtube</label>
                                    <input type="text" class="form-control" id="youtube" name="youtube" placeholder="{{ __('Youtube') }}" value="">
                                    @if($errors->has('youtube'))
                                        <div class="error">{{ $errors->first('youtube') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success pr-4 pl-4" id="submitForm">
                                    <i class="fa fa-save"></i> Save
                                </button>
                                <a href="{{ route('admin.visiting-card.index') }}" class="btn btn-danger pr-4 pl-4">
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
<script>
    $(window).ready(function() {
        $('.avtar, .background_image').dropify();
    })
</script>
@endsection
