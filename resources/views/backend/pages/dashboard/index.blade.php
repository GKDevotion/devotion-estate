
@extends('backend.layouts.master')

@section('title')
Company Location Page - Admin Panel
@endsection

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .child{
            text-align: left;
        }
    </style>
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left d-none">Corporate Email</h4>
                <ul class="breadcrumbs pull-left m-2">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>All Location</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-2 text-end">
            @if (Auth::guard('admin')->user()->can('locations.create'))
                <a class="btn btn-add text-white" href="{{ route('admin.locations.create') }}">
                    <i class="fa fa-plus"></i> Location
                </a>
            @endif
        </div>
        <div class="col-md-2 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

@endsection
