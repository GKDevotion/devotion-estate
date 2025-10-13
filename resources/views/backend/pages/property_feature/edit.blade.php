
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
                    <li><a href="{{ route('admin.portfolio.index') }}">All Portfolio</a></li>
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
                <a href="{{ route('admin.portfolio.index') }}" class="btn btn-danger">
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

                    <form action="{{ route('admin.portfolio.update', $data->id) }}" enctype="multipart/form-data" onsubmit="return onSubmitValidateForm();" method="POST">
                        @method('PUT')
                        @csrf
                        <span class="get-employee-list-url d-none">{{url('api/get-employee-list')}}</span>
                        <span class="get-employee-details-url d-none">{{url('api/get-employee-details')}}</span>

                        <div class="row">

                            <div class="col-md-3 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="company_id">Company<span class="text-error">*</span></label>
                                    <select class="form-control company_id get-employee-list" data-id="employee_id" data-required="yes" id="company_id" name="company_id" autofocus>
                                        <option value="">Select Company</option>
                                        @foreach( $companyArr as $id=>$name )
                                            <option value="{{$id}}" {{$data->company_id == $id ? 'selected' : ''}}>{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('company_id')
                                    <div class="error text-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <div class="form-group">
                                    <label class="mb-0" for="employee_id">Employee</label>
                                    <select class="form-control get-employee-details employee-id" id="employee_id" name="employee_id">
                                        <option value="0">Select Employee</option>
                                        @foreach( $employeeArr as $id=>$name )
                                            <option value="{{$id}}" {{$data->employee_id == $id ? 'selected' : ''}}>{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('employee_id')
                                    <div class="error text-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Home Section -->
                        <div class="box-shadow-10">
                            <fieldset>
                                <label>Home Section</label>
                                <div class="row mb-3">

                                    <!-- Avtar -->
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="mb-0" for="avtar">Avtar</label>
                                            <input type="file" class="avtar" id="avtar" name="avtar" accept="image/jpg, image/jpeg, image/png"  data-default-file="{{asset( 'storage/'.$data->avtar )}}">
                                        </div>
                                        @if($errors->has('avtar'))
                                            <div class="error">{{ $errors->first('avtar') }}</div>
                                        @endif
                                    </div>

                                    <!-- Background Image -->
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="mb-0" for="background_image">Background Image</label>
                                            <input type="file" class="background_image" id="background_image" name="background_image" accept="image/jpg, image/jpeg, image/png"  data-default-file="{{asset( 'storage/'.$data->background_image )}}">
                                        </div>
                                        @if($errors->has('background_image'))
                                            <div class="error">{{ $errors->first('background_image') }}</div>
                                        @endif
                                    </div>

                                    <!-- Name -->
                                    <div class="col-md-4 mt-2 mb-3">
                                        <div class="form-group">
                                            <label class="mb-0" for="name">Name<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" data-required="yes" id="name" name="name" placeholder="First Name & Last Name" value="{{$data->name}}">
                                        </div>
                                        @if($errors->has('name'))
                                            <div class="error">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-4 mt-2 mb-3">
                                        <div class="form-group">
                                            <label class="mb-0" for="email">Email<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" data-required="yes" id="email" name="email" placeholder="Email ID" value="{{$data->email}}">
                                        </div>
                                        @if($errors->has('email'))
                                            <div class="error">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>

                                    <!-- Contact -->
                                    <div class="col-md-4 mt-2 mb-3">
                                        <div class="form-group">
                                            <label class="mb-0" for="contact">Contact<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" data-required="yes" id="contact" name="contact" placeholder="Contact Number" value="{{$data->contact}}">
                                        </div>
                                        @if($errors->has('contact'))
                                            <div class="error">{{ $errors->first('contact') }}</div>
                                        @endif
                                    </div>

                                    <!-- Location -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-0" for="location">Location<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" data-required="yes" id="location" name="location" placeholder="Full Address" value="{{$data->location}}">
                                        </div>
                                        @if($errors->has('location'))
                                            <div class="error">{{ $errors->first('location') }}</div>
                                        @endif
                                    </div>

                                    <!-- Thoughts -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-0" for="thoughts">Thoughts<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" data-required="yes" id="thoughts" name="thoughts" placeholder="Thoughts or Slogan" value="{{$data->thoughts}}">
                                        </div>
                                        @error('thoughts')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <lable>Social Media</lable>
                                <div class="row" id="addSocialMedia">
                                    @if( COUNT( json_decode( $data->social_media, 1 ) ) > 0 )
                                        @foreach ( json_decode( $data->social_media, 1 ) as $k=>$ar )

                                            <div class="col-md-6 mt-2">
                                                <div class="row">
                                                    <div class="col-md-3 col-sm-12">
                                                        <input name="social_media[{{$k}}][font]" id="social_media_{{$k}}_font" class="form-control" placeholder="fa fa-******" value="{{$ar['font']}}">
                                                    </div>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input name="social_media[{{$k}}][link]" id="social_media_{{$k}}_link" class="form-control" placeholder="Enter Social Media Link" value="{{$ar['link']}}">
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    @else
                                        <div class="col-md-6 mt-2">
                                            <div class="row">
                                                <div class="col-md-3 col-sm-12">
                                                    <input name="social_media[0][font]" id="social_media_0_font" class="form-control" placeholder="fa fa-******">
                                                </div>
                                                <div class="col-md-9 col-sm-12">
                                                    <input name="social_media[0][link]" id="social_media_0_link" class="form-control" placeholder="Enter Social Media Link">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12 text-center col-sm-12">
                                        <button type="button" class="btn btn-outline-success pr-4 pl-4 add-more-social-media">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <lable>Profession</lable>
                                <div class="row" id="addEmployeeProfession">
                                    <div class="col-md-4 mt-2">
                                        <input name="profession[0]" id="profession_0" class="form-control" placeholder="Enter Profession here">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12 text-center col-sm-12">
                                        <button type="button" class="btn btn-outline-success pr-4 pl-4 add-more-employee-profession">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <!-- About Section -->
                        <div class="box-shadow-10">
                            <fieldset>
                                <label>About Section</label>

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label class="mb-0" for="about_title">About Title<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" data-required="yes" id="about_title" name="about_title" placeholder="About Title" value="{{$data->about_title}}">
                                        </div>
                                        @error('about_title')
                                            <div class="error text-error">{{ $errors->first('about_title') }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-8 mb-2">
                                        <div class="form-group">
                                            <label class="mb-0" for="about_description">About Short Description<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" id="about_description" data-required="yes" name="about_description" placeholder="About Short Description" value="{{$data->about_description}}">
                                        </div>
                                        @error('about_description')
                                            <div class="error text-error">{{ $errors->first('about_description') }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <div class="form-group">
                                            <label class="mb-0" for="total_project">Completed Project<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" data-required="yes" id="total_project" name="total_project" placeholder="About Title" value="{{$data->total_project}}">
                                        </div>
                                        @if($errors->has('total_project'))
                                            <div class="error">{{ $errors->first('total_project') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <div class="form-group">
                                            <label class="mb-0" for="client_review">Client Review<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" id="client_review" data-required="yes" name="client_review" placeholder="Client Review" value="{{$data->client_review}}">
                                        </div>
                                        @if($errors->has('client_review'))
                                            <div class="error">{{ $errors->first('client_review') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <div class="form-group">
                                            <label class="mb-0" for="satisfied_client">Satisfied Client<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" id="satisfied_client" data-required="yes" name="satisfied_client" placeholder="Satisfied Client" value="{{$data->satisfied_client}}">
                                        </div>
                                        @if($errors->has('satisfied_client'))
                                            <div class="error">{{ $errors->first('satisfied_client') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <div class="form-group">
                                            <label class="mb-0" for="experience">Experience<span class="text-error">*</span></label>
                                            <input type="text" class="form-control" data-required="yes" id="experience" name="experience" placeholder="Experience" value="{{$data->experience}}">
                                        </div>
                                        @if($errors->has('experience'))
                                            <div class="error">{{ $errors->first('experience') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <label class="mt-2">About Options:</label>
                                <div class="row" id="addAboutOptions">
                                    @if( COUNT( json_decode( $data->about_options, 1 ) ) > 0 )
                                        @foreach ( json_decode( $data->about_options, 1 ) as $k=>$ar )
                                            <div class="col-md-2 col-sm-12 mb-2">
                                                <input name="about_options[{{$k}}][font]" id="about_options_{{$k}}_font" class="form-control" placeholder="fa fa-******" value="{{$ar['font']}}">
                                            </div>
                                            <div class="col-md-3 col-sm-12 mb-2">
                                                <input name="about_options[{{$k}}][title]" id="about_options_{{$k}}_title" class="form-control" placeholder="Enter Option title" value="{{$ar['title']}}">
                                            </div>
                                            <div class="col-md-7 col-sm-12 mb-2">
                                                <input name="about_options[{{$k}}][description]" id="about_options_{{$k}}_description" class="form-control" placeholder="Enter Option Description" value="{{$ar['description']}}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-md-2 col-sm-12 mb-2">
                                            <input name="about_options[0][font]" id="about_options_0_font" class="form-control" placeholder="fa fa-******">
                                        </div>
                                        <div class="col-md-3 col-sm-12 mb-2">
                                            <input name="about_options[0][title]" id="about_options_0_title" class="form-control" placeholder="Enter Option title">
                                        </div>
                                        <div class="col-md-7 col-sm-12 mb-2">
                                            <input name="about_options[0][description]" id="about_options_0_description" class="form-control" placeholder="Enter Option Description">
                                        </div>
                                    @endif
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12 text-center col-sm-12">
                                        <button type="button" class="btn btn-outline-success pr-4 pl-4 add-more-about-options">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <!-- What Provided -->
                        <div class="box-shadow-10">
                            <fieldset>
                                <label>What Provide Services</label>
                                <div class="row" id="addProvidedServiceOptions">
                                    @if( COUNT( json_decode( $data->provide_services, 1 ) ) > 0 )
                                        @foreach ( json_decode( $data->provide_services, 1 ) as $k=>$ar )
                                            <div class="col-md-2 col-sm-12 mb-2">
                                                <input name="provide_services[{{$k}}][font]" id="provide_services_{{$k}}_font" class="form-control" placeholder="fa fa-******" value="{{$ar['font']}}">
                                            </div>
                                            <div class="col-md-3 col-sm-12 mb-2">
                                                <input name="provide_services[{{$k}}][title]" id="provide_services_{{$k}}_title" class="form-control" placeholder="Enter Service title" {{$ar['title']}}>
                                            </div>
                                            <div class="col-md-7 col-sm-12 mb-2">
                                                <input name="provide_services[{{$k}}][description]" id="provide_services_{{$k}}_description" class="form-control" placeholder="Enter Service Description" value="{{$ar['description']}}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-md-2 col-sm-12 mb-2">
                                            <input name="provide_services[0][font]" id="provide_services_0_font" class="form-control" placeholder="fa fa-******">
                                        </div>
                                        <div class="col-md-3 col-sm-12 mb-2">
                                            <input name="provide_services[0][title]" id="provide_services_0_title" class="form-control" placeholder="Enter Service title">
                                        </div>
                                        <div class="col-md-7 col-sm-12 mb-2">
                                            <input name="provide_services[0][description]" id="provide_services_0_description" class="form-control" placeholder="Enter Service Description">
                                        </div>
                                    @endif
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12 text-center col-sm-12">
                                        <button type="button" class="btn btn-outline-success pr-4 pl-4 add-more-provide-service-options">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <!-- SEO Data -->
                        <div class="box-shadow-10">
                            <fieldset>
                                <label>SEO Meta Data</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mb-2">
                                        <div class="form-group">
                                            <label>Meta Title</label>
                                            <input name="meta_title" id="meta_title" class="form-control" placeholder="Meta Title" value="{{$data->meta_title}}">
                                        </div>
                                        @if($errors->has('meta_title'))
                                            <div class="error">{{ $errors->first('meta_title') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-6 col-sm-12 mb-2">
                                        <div class="form-group">
                                            <lable>H1 Tag</lable>
                                            <input name="h1_tag" id="h1_tag" class="form-control" placeholder="H1 tag" value="{{$data->h1_tag}}">
                                        </div>
                                        @if($errors->has('h1_tag'))
                                            <div class="error">{{ $errors->first('h1_tag') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-12 col-sm-12 mb-2">
                                        <div class="form-group">
                                            <lable>Meta Description</lable>
                                            <input name="meta_description" id="meta_description" class="form-control" placeholder="Meta Description" value="{{$data->meta_description}}">
                                        </div>
                                        @if($errors->has('meta_description'))
                                            <div class="error">{{ $errors->first('meta_description') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-12 col-sm-12 mb-2">
                                        <div class="form-group">
                                            <lable>Meta Keyword</lable>
                                            <input name="meta_keyword" id="meta_keyword" class="form-control" placeholder="Meta Keywords" value="{{$data->meta_keyword}}">
                                        </div>
                                        @if($errors->has('meta_keyword'))
                                            <div class="error">{{ $errors->first('meta_keyword') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success pr-4 pl-4" id="submitForm">
                                    <i class="fa fa-save"></i> Update
                                </button>
                                <a href="{{ route('admin.portfolio.index') }}" class="btn btn-danger pr-4 pl-4">
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
