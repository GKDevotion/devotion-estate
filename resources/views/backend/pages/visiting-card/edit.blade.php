
@extends('backend.layouts.master')

@section('title')
Portfolio Edit - Admin Panel
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
                <h4 class="page-title pull-left d-none">Portfolio Edit - {{ $data->name }}</h4>
                <ul class="breadcrumbs pull-left m-2">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.visiting-card.index') }}">All Portfolio</a></li>
                    <li><span>Edit Portfolio</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <p class="float-end">
                @if (Auth::guard('admin')->user()->can('portfolio.edit'))
                    <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                        <i class="fa fa-save"></i> Update
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
            <h3 class="pb-3">Update Portfolio</h3>
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

                    <form action="{{ route('admin.visiting-card.update', $data->id) }}" enctype="multipart/form-data" onsubmit="return onSubmitValidateForm();" method="POST">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <div class="col-12 col-xl-4">
                                <label class="mb-0" for="avtar">Avtar</label>
                                <input type="file" class="avtar" id="avtar" name="avtar" data-default-file="{{url( 'storage/'.$data->avtar )}}" accept="image/jpg, image/jpeg, image/png">
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
                                                    <option value="{{$id}}" {{( $data->company_id == $id ? 'selected' : '' )}}>{{$name}}</option>
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
                                            <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Name') }}" value="{{old('name', $data->name)}}" autofocus>
                                            @if($errors->has('name'))
                                                <div class="error">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                        <div class="mb-3 form-group">
                                            <label for="email">Email<span class="text-error">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('Email') }}" value="{{old('email', $data->email)}}">
                                            @if($errors->has('email'))
                                                <div class="error">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                        <div class="mb-3 form-group">
                                            <label for="position">Position<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" id="position" name="position" placeholder="{{ __('Position') }}" value="{{old('position', $data->position)}}">
                                            @if($errors->has('position'))
                                                <div class="error">{{ $errors->first('position') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                        <div class="mb-3 form-group">
                                            <label for="mobile_number">Mobile Number<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="{{ __('Mobile Number') }}" value="{{old('mobile_number', $data->mobile_number)}}">
                                            @if($errors->has('mobile_number'))
                                                <div class="error">{{ $errors->first('mobile_number') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                        <div class="mb-3 form-group">
                                            <label for="office_number">Office Number<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" id="office_number" name="office_number" placeholder="{{ __('Office Number') }}" value="{{old('office_number', $data->office_number)}}">
                                            @if($errors->has('office_number'))
                                                <div class="error">{{ $errors->first('office_number') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                        <div class="mb-3 form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="1" {{$data->status == 1 ? 'selected' : ''}}>Active</option>
                                                <option value="0" {{$data->status == 0 ? 'selected' : ''}}>De-Active</option>
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
                                    <input type="text" class="form-control" id="office_address_1" name="office_address_1" placeholder="{{ __('Registered Address') }}" value="{{old('office_address_1' , $data->office_address_1)}}">
                                    @if($errors->has('office_address_1'))
                                        <div class="error">{{ $errors->first('office_address_1') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="office_address_2">Sales Office Address</label>
                                    <input type="text" class="form-control" id="office_address_2" name="office_address_2" placeholder="{{ __('Sales Office Address') }}" value="{{old('office_address_2', $data->office_address_2)}}">
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
                                    <input type="text" class="form-control" id="facebook" name="facebook" placeholder="{{ __('Facebook') }}" value="{{old('facebook', $data->facebook)}}">
                                    @if($errors->has('facebook'))
                                        <div class="error">{{ $errors->first('facebook') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" class="form-control" id="instagram" name="instagram" placeholder="{{ __('Instagram') }}" value="{{old('instagram', $data->instagram)}}">
                                    @if($errors->has('instagram'))
                                        <div class="error">{{ $errors->first('instagram') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="tiktok">TikTok</label>
                                    <input type="text" class="form-control" id="tiktok" name="tiktok" placeholder="{{ __('TikTok') }}" value="{{old('tiktok', $data->tiktok)}}">
                                    @if($errors->has('tiktok'))
                                        <div class="error">{{ $errors->first('tiktok') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="pinterest">Pinterest</label>
                                    <input type="text" class="form-control" id="pinterest" name="pinterest" placeholder="{{ __('Pinterest') }}" value="{{old('pinterest', $data->pinterest)}}">
                                    @if($errors->has('pinterest'))
                                        <div class="error">{{ $errors->first('pinterest') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="snapchat">Snapchat</label>
                                    <input type="text" class="form-control" id="snapchat" name="snapchat" placeholder="{{ __('Snapchat') }}" value="{{old('snapchat', $data->snapchat)}}">
                                    @if($errors->has('snapchat'))
                                        <div class="error">{{ $errors->first('snapchat') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="quora">Quora</label>
                                    <input type="text" class="form-control" id="quora" name="quora" placeholder="{{ __('Quora') }}" value="{{old('quora', $data->quora)}}">
                                    @if($errors->has('quora'))
                                        <div class="error">{{ $errors->first('quora') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="linkedin">Linked In</label>
                                    <input type="text" class="form-control" id="linkedin" name="linkedin" placeholder="{{ __('Linked In') }}" value="{{old('linkedin', $data->linkedin)}}">
                                    @if($errors->has('linkedin'))
                                        <div class="error">{{ $errors->first('linkedin') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="twitter">Twitter</label>
                                    <input type="text" class="form-control" id="twitter" name="twitter" placeholder="{{ __('Twitter') }}" value="{{old('twitter', $data->twitter)}}">
                                    @if($errors->has('twitter'))
                                        <div class="error">{{ $errors->first('twitter') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4 col-sm-12 col-12">
                                <div class="mb-3 form-group">
                                    <label for="youtube">Youtube</label>
                                    <input type="text" class="form-control" id="youtube" name="youtube" placeholder="{{ __('Youtube') }}" value="{{old('youtube', $data->youtube)}}">
                                    @if($errors->has('youtube'))
                                        <div class="error">{{ $errors->first('youtube') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success pr-4 pl-4" id="submitForm">
                                    <i class="fa fa-save"></i> Update
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
