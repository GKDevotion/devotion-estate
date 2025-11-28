@extends('backend.layouts.master')

@section('title')
    Lead User Edit - Admin Panel
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
                    <h4 class="page-title pull-left d-none">Lead User Edit - {{ $data->name }}</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.lead-user.index') }}">All Lead User</a></li>
                        <li><span>Edit Lead User</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 text-end">
                <p class="float-end">
                    @if (Auth::guard('admin')->user()->can('lead-user.edit'))
                        <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                            <i class="fa fa-save"></i> Update
                        </button>
                    @endif
                    <a href="{{ route('admin.lead-user.index') }}" class="btn btn-danger">
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
                <h3 class="pb-3">Update Lead User</h3>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.lead-user.update', $data->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-8 offset-2">
                                    <div class="row">
                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="reference_id">Reference ID<span class="text-error"></span></label>
                                                <!-- Text input shows saved user name -->
                                                <input type="text" data-required="no" class="form-control" id="user_search" name="" placeholder="Search User ID" value="{{( $data->reference_id > 0 ) ? $data->parent->first_name." ".$data->parent->middle_name." ".$data->parent->last_name : ''}}">

                                                <!-- Hidden field stores saved user_id -->
                                                <input type="hidden" name="reference_id" id="reference_id" value="{{$data->reference_id}}">

                                                <div id="user_list" class="list-group mt-2"></div>
                                            </div>
                                            @error('reference_id')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="first_name">First Name<span class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control" id="first_name" name="first_name" placeholder="First Name" autofocus value="{{$data->first_name}}">
                                            </div>
                                            @error('first_name')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="middle_name">Middle Name<span class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name" value="{{$data->middle_name}}">
                                            </div>
                                            @error('middle_name')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="last_name">Last Name<span class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{{$data->last_name}}">
                                            </div>
                                            @error('last_name')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="email">Email<span class="text-error">*</span></label>
                                                <input type="email" data-required="yes" class="form-control" id="email" name="email" placeholder="Email " value="{{$data->email}}">
                                            </div>
                                            @error('email')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="mobile_number">Mobile No.<span class="text-error">*</span></label>
                                                <input type="number" data-required="yes" class="form-control" id="mobile_number" name="mobile_number" placeholder="Mobile Number" value="{{$data->mobile_number}}">
                                            </div>
                                            @error('mobile_number')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="address">Address<span class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control" id="address" name="address" placeholder="Address " value="{{$data->address}}">
                                            </div>
                                            @error('address')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="continent_id">Continent<span class="text-error">*</span></label>
                                                <select name="continent_id" data-required="yes" id="continent_id" class="form-control get-country-list continent-id" data-id="country_id">
                                                    <option value="0" >Select Continent</option>
                                                    @foreach ($continentArr as $ar)
                                                        <option value="{{ $ar->id }}" {{$data->continent_id == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('continent_id')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="country_id">Country<span class="text-error">*</span></label>
                                                <select name="country_id" data-required="yes" id="country_id" class="form-control get-state-list country-id" data-id="state_id">
                                                    <option value="0" >Select Country</option>
                                                     @foreach ($countryArr as $ar)
                                                        <option value="{{ $ar->id }}" {{$data->country_id == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('country_id')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="state_id">State<span class="text-error">*</span></label>
                                                <select name="state_id" data-required="yes" id="state_id" class="form-control get-city-list state-id" data-id="city_id">
                                                    <option value="0" >Select State</option>
                                                     @foreach ($stateArr as $ar)
                                                        <option value="{{ $ar->id }}" {{$data->state_id == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('state_id')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="city_id">City<span class="text-error">*</span></label>
                                                <select name="city_id" data-required="yes" id="city_id" class="form-control city-id">
                                                    <option value="0" >Select City</option>
                                                     @foreach ($cityArr as $ar)
                                                        <option value="{{ $ar->id }}" {{$data->city_id == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('city_id')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="zipcode">Zipcode<span class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control" id="zipcode" name="zipcode" placeholder="Zipcode" value="{{$data->zipcode}}">
                                            </div>
                                            @error('zipcode')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="gender">Gender</label>
                                                <select class="form-control" id="gender" name="gender">
                                                    <option value="1" {{$data->gender_id == 1 ? 'selected' : ''}}>Male</option>
                                                    <option value="2" {{$data->gender_id == 2 ? 'selected' : ''}}>Fe Male</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="religion_id">Religion</label>
                                                <select name="religion_id" data-required="yes" id="religion_id" class="form-control get-country-list continent-id" data-id="country_id">
                                                    <option value="" >Select Religion</option>
                                                    @foreach ($religionArr as $ar)
                                                        <option value="{{ $ar->id }}"  {{$data->religion_id == $ar->id ? 'selected' : ''}}>{{ $ar->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('religion_id')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="is_commission_apply">Use Commission (MLM)</label>
                                                <select class="form-control" id="is_commission_apply" name="is_commission_apply">
                                                    <option value="0" {{$data->is_commission_apply == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{$data->is_commission_apply == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="status">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="0" {{$data->status == 0 ? 'selected' : ''}}>De Active</option>
                                                    <option value="1" {{$data->status == 1 ? 'selected' : ''}}>Active</option>
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
                                    <a href="{{ route('admin.lead-user.index') }}" class="btn btn-danger pr-4 pl-4">
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

@section('scripts')
    <script>
        $(document).ready(function() {

            $('#user_search').keyup(function() {
                let query = $(this).val();

                if (query.length < 5) {
                    $('#user_list').hide();
                    return;
                }

                $.ajax({
                    url: "{{ route('search.users') }}",
                    type: "GET",
                    data: { q: query },
                    success: function (data) {
                        let html = '';
                        if(data.length > 0){
                            data.forEach(item => {
                                html += `<a href="#" class="list-group-item list-group-item-action user-item"
                                            data-id="${item.id}" data-name="${item.first_name+" "+item.middle_name+" "+item.last_name}( ${item.unique_id} )">
                                            ${item.unique_id}
                                        </a>`;
                            });
                        }else{
                            html = `<div class="list-group-item">No results found</div>`;
                        }

                        $('#user_list').html(html).show();
                    }
                });
            });

            // When select from suggestion
            $(document).on('click', '.user-item', function(e) {
                e.preventDefault();

                let id = $(this).data('id');
                let unique_id = $(this).data('name');

                $('#user_search').val(unique_id);
                $('#reference_id').val(id);

                $('#user_list').hide(); // close dropdown
            });

        });
    </script>
@endsection
