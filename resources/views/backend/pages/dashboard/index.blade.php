@extends('backend.layouts.master')

@section('title')
    Company Dashboard Page - Admin Panel
@endsection

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .child {
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
                    <h4 class="page-title pull-left d-none">Dashboard</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li class="d-none"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><span>Dashboard</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 text-end">
            </div>
            <div class="col-md-2 clearfix">
                @include('backend.layouts.partials.logout')
            </div>
        </div>
    </div>
    <!-- page title area end -->
    <div class="row mt-4 justify-content-center">

        <!-- Total Properties -->
        <div class="col-md-2">
            <a href="{{ url('/admin/properties') }}">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="bi bi-buildings-fill fs-1"></i>
                        <h6 class="text-muted">Total Properties</h6>
                        <h2 class="fw-bold" style="color: #ab8134">{{ $totalProperties }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- New Property -->
        <div class="col-md-2">
            <a href="{{ url('/admin/new-property') }}">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="bi-tags-fill fs-1"></i>
                        <h6 class="text-muted">New Property</h6>
                        <h2 class="fw-bold" style="color: #ab8134">{{ $newProperties }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- Hot Offer Property -->
        <div class="col-md-2">
            <a href="{{ url('/admin/hot-property') }}">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="bi-building  fs-1"></i>
                        <h6 class="text-muted">Hot Offer Property</h6>
                        <h2 class="fw-bold" style="color: #ab8134">{{ $hotProperties }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- Luxury Property -->
        <div class="col-md-2">
            <a href="{{ url('/admin/luxury-property') }}">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="bi bi-building-fill-down fs-1"></i>
                        <h6 class="text-muted">Luxury Properties</h6>
                        <h2 class="fw-bold" style="color: #ab8134">{{ $luxuryProperties }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- Luxury Property -->
        <div class="col-md-2">
            <a href="{{ url('/admin/developer') }}">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="bi bi-building-fill-down fs-1"></i>
                        <h6 class="text-muted">Developers</h6>
                        <h2 class="fw-bold" style="color: #ab8134">{{ $developer }}</h2>
                    </div>
                </div>
            </a>
        </div>

    </div>

    @if ($contactMessages->count())
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Property Contact Messages</h5>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Read</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contactMessages as $msg)
                                    <tr>
                                        <td>{{ $msg->name }}</td>
                                        <td>{{ $msg->email }}</td>
                                        <td>{{ $msg->mobile_number ?? '-' }}</td>
                                        <td>{{ Str::limit($msg->message, 50) }}</td>
                                        <td>{{ $msg->created_at->format('d M Y') }}</td>
                                        <!-- Read / Unread Status -->
                                        <td class="text-start">
                                            <i class="fa fa-{{ $msg->is_read == 0 ? 'times ' : 'check text-success' }}
                                                 update-field-status"
                                                data-status="{{ $msg->is_read }}" data-id="{{ $msg->id }}"
                                                data-table="property_contact" data-field="is_read"
                                                style="cursor:pointer; color:#ab8134;" aria-hidden="true">
                                            </i>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer text-center bg-white">
                        <a href="{{ url('/admin/property-contact') }}" class="btn btn-sm "
                            style="color:#ab8134; border:none;">
                            View All Messages
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- <div class="text-center text-muted mt-5">
            No property contact messages found.
        </div> --}}
    @endif
@endsection
