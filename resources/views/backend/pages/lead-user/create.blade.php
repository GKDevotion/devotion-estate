@extends('backend.layouts.master')

@section('title')
    Lead User Create - Admin Panel
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
                    <h4 class="page-title pull-left d-none">Lead User Create</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.lead-user.index') }}">All Lead User</a></li>
                        <li><span>Create Lead User</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <p class="float-end">
                    @if (Auth::guard('admin')->user()->can('lead-user.create'))
                        <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                            <i class="fa fa-save"></i> Save
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
                <h3 class="pb-3">Lead User </h3>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.lead-user.store') }}" onsubmit="return onSubmitValidateForm();"
                            method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-md-8 offset-2">
                                    <div class="row">
                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="reference_id">Reference ID<span class="text-error"></span></label>
                                                <!-- Text input shows saved user name -->
                                                <input type="text" data-required="no" class="form-control" id="user_search" name="" placeholder="Search User ID" autofocus>

                                                <!-- Hidden field stores saved user_id -->
                                                <input type="hidden" name="reference_id" id="reference_id">

                                                <div id="user_list" class="list-group mt-2"></div>
                                            </div>
                                            @error('reference_id')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="first_name">First Name<span class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                                            </div>
                                            @error('first_name')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="middle_name">Middle Name<span class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name">
                                            </div>
                                            @error('middle_name')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="last_name">Last Name<span class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                                            </div>
                                            @error('last_name')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="email">Email<span class="text-error">*</span></label>
                                                <input type="email" data-required="yes" class="form-control" id="email" name="email" placeholder="Email ">
                                            </div>
                                            @error('email')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="mobile_number">Mobile No.<span class="text-error">*</span></label>
                                                <input type="number" data-required="yes" class="form-control" id="mobile_number" name="mobile_number" placeholder="Mobile Number">
                                            </div>
                                            @error('mobile_number')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="address">Address<span class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control" id="address" name="address" placeholder="Address ">
                                            </div>
                                            @error('address')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="continent_id">Continent<span class="text-error">*</span></label>
                                                <select name="continent_id" data-required="yes" id="continent_id" class="form-control get-country-list continent-id" data-id="country_id">
                                                    <option value="" >Select Continent</option>
                                                    @foreach ($continentArr as $ar)
                                                        <option value="{{ $ar->id }}">{{ $ar->name }}</option>
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
                                                    <option value="" >Select Country</option>
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
                                                    <option value="" >Select State</option>
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
                                                    <option value="" >Select City</option>
                                                </select>
                                                @error('city_id')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="zipcode">Zipcode<span class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control" id="zipcode" name="zipcode" placeholder="Zipcode">
                                            </div>
                                            @error('zipcode')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="gender">Gender</label>
                                                <select class="form-control" id="gender" name="gender">
                                                    <option value="1">Male</option>
                                                    <option value="2">Fe Male</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="religion_id">Religion</label>
                                                <select name="religion_id" data-required="yes" id="religion_id" class="form-control get-country-list continent-id" data-id="country_id">
                                                    <option value="" >Select Religion</option>
                                                    @foreach ($religionArr as $ar)
                                                        <option value="{{ $ar->id }}">{{ $ar->name }}</option>
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
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="status">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="0">De Active</option>
                                                    <option value="1">Active</option>
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
