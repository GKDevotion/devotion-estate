@extends('backend.layouts.master')

@section('title')
    Company Payment Plan Page - Admin Panel
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
                    <h4 class="page-title pull-left d-none">Corporate Email</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><span>All Payment Plan</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 text-end">
                @if (Auth::guard('admin')->user()->can('payment-plan.create'))
                    {{-- <a class="btn btn-add text-white" href="{{ route('admin.payment-plan.create') }}">
                    <i class="fa fa-plus"></i> Payment Plan
                </a> --}}
                    <button type="button" class="btn btn-add text-white" data-bs-toggle="modal"
                        data-bs-target="#paymentPlanModal">
                        <i class="fa fa-plus"></i> Payment Plan
                    </button>
                @endif
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
                <h3 class="pb-3">Payment Plan Hisotry</h3>
                <div class="card">
                    <div class="card-body">

                        <div class="data-tables">

                            @include('backend.layouts.partials.messages')

                            <table id="payment-plan_index" class="">
                                <thead id="corporate-emails" class="bg-light text-capitalize">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>

    <!-- Payment Plan Modal -->
    <div class="modal fade" id="paymentPlanModal" tabindex="-1" aria-labelledby="paymentPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header text-white">
                    <h5 class="modal-title" id="paymentPlanModalLabel">Add Payment Plan</h5>
                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>


                </div>

                <form action="{{ route('admin.payment-plan.store') }}" onsubmit="return onSubmitValidateForm();"
                    method="POST" autocomplete="off">
                    @csrf
                    <div class="row">

                        <div class="col-md-6 offset-3">
                            <div class="row">
                                <div class="col-md-12 m-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="name">Value <span class="text-error">*</span></label>
                                        <input type="number" class="form-control" id="name" name="name"
                                            placeholder="Enter value" step="any" min="0" required>
                                    </div>
                                    @error('name')
                                        <div class="error text-error">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="col-md-12 m-2">
                                    <div class="form-group">
                                        <label class="mb-0" for="status">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="1">Active</option>
                                            <option value="0">De Active</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row m-3">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success pr-4 pl-4" id="submitForm">
                                <i class="fa fa-save"></i> Save
                            </button>
                            <a href="{{ route('admin.payment-plan.index') }}" class="btn btn-danger pr-4 pl-4">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Payment Plan Modal -->
    <div class="modal fade" id="editpaymentPlanModal" tabindex="-1" aria-labelledby="paymentPlanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header text-white">
                    <h5 class="modal-title" id="paymentPlanModalLabel">Add Payment Plan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>

                    <div class="col-md-6">
                        <p class="float-end">
                            @if (Auth::guard('admin')->user()->can('payment-plan.edit'))
                                <button type="button" class="btn btn-success pr-4 pl-4"
                                    onclick="$('#submitForm').click();">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            @endif
                            <a href="{{ route('admin.payment-plan.index') }}" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </p>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @include('backend.layouts.partials.data-table')

    <script>
        $(document).ready(function() {
            var table = $('#payment-plan_index').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,

                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                pageLength: 10,
                ajax: {
                    url: "{{ route('payment-plan.ajaxIndex') }}",
                    type: 'GET',
                    data: function(d) {
                        // d.cid = ""; // Pass company parameter
                        // d.iid = ""; // Pass industry parameter
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'status', name: 'status' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('id', 'row_' + data.id); // Assign a custom ID to the row
                    $(row).attr('class', 'payment-plan_row'); // Assign a custom Class to the row
                },
                language: {
                    emptyTable: "No data available in table" // Custom message for empty table
                },
            });

            // Adjust the table width after the data is loaded
            table.on('xhr', function() {
                var data = table.ajax.json().data;

                $('#payment-plan_index').css('width', '100%');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
