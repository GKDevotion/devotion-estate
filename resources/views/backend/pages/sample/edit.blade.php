
@extends('backend.layouts.master')

@section('title')
Continent Edit - Admin Panel
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
        <div class="col-sm-8">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left d-none">Continent Edit - {{ $data->name }}</h4>
                <ul class="breadcrumbs pull-left m-2">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.city.index') }}">All Email</a></li>
                    <li><span>Edit Continent</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-4 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                                <i class="fa fa-save"></i>
                            </button>
                            <a href="{{ route('admin.city.index') }}" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>

                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.city.update', $data->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="continent_id">Continent</label>
                                            <select class="form-control continent_id" id="continent_id" name="continent_id" autofocus>
                                                @foreach( $continentArr as $cr )
                                                    <option value="{{$cr->id}}" {{$data->continent_id == $cr->id ? 'Selected' : ''}}>{{$cr->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="country_id">Country</label>
                                            <select class="form-control country_id" id="country_id" name="country_id">
                                                <option class="" value="0">Select Country</option>
                                                @foreach( $countryArr as $cr )
                                                    <option class="continent-id continent_id_{{$cr->continent_id}} {{$data->continent_id == $cr->continent_id ? '' : 'd-none'}}" {{$data->country_id == $cr->id ? 'Selected' : ''}} value="{{$cr->id}}">{{$cr->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="state_id">State</label>
                                            <select class="form-control state_id" id="state_id" name="state_id">
                                                <option class="" value="0">Select State</option>
                                                @foreach( $stateArr as $sr )
                                                    <option class="state-id continent_id_{{$sr->continent_id}} state_id_{{$sr->country_id}} {{$data->country_id == $sr->country_id ? '' : 'd-none'}}" {{$data->state_id == $sr->id ? 'Selected' : ''}} value="{{$sr->id}}">{{$sr->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$data->name}}">
                                        </div>
                                    </div>
                                
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="latitude">Latitude</label>
                                            <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude" value="{{$data->latitude}}">
                                        </div>
                                    </div>
                                
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="longitude">Longitude</label>
                                            <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude" value="{{$data->longitude}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="1" {{$data->status == 1 ? 'selected' : ''}}>Active</option>
                                                <option value="0" {{$data->status == 0 ? 'selected' : ''}}>De Active</option>
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
                                <a href="{{ route('admin.city.index') }}" class="btn btn-danger pr-4 pl-4">
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
        $('#continent_id').on("change", function(){
            $(".continent-id").addClass('d-none')
            $(".continent_id_"+$(this).val()).removeClass('d-none')
        });

        $('#country_id').on("change", function(){
            $(".country-id").addClass('d-none')
            $(".country_id_"+$(this).val()).removeClass('d-none')
        });
    })
</script>
@endsection