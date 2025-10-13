
@extends('backend.layouts.master')

@section('title')
Customer - Admin Panel
@endsection

@section('styles')
    <!-- Start datatable css -->
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css"> --}}
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
        <div class="col-md-7">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left d-none">Customer</h4>
                <ul class="breadcrumbs pull-left m-2">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>All Customer</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3 text-end">
            @if (Auth::guard('admin')->user()->can('customer.edit'))
                <a class="btn btn-add text-white" href="{{ route('admin.customer.create') }}">
                    <i class="fa fa-plus"></i> Customer
                </a>
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
            <h3 class="pb-3">Customer History</h3>
            <div class="card">
                <div class="card-body">

                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead id="customer" class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="3%">Asset No.</th>
                                    <th width="10%">Name</th>
                                    <th width="8%">Email</th>
                                    <th width="5%">Department</th>
                                    <th width="5%">Contact No.</th>
                                    <th width="5%">Joinning Date</th>
                                    <th width="3%">Gender</th>
                                    <th width="3%">Status</th>
                                    <th width="5%">Created At</th>
                                    <th width="5%">Updated At</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($dataArr as $emp)
                                <tr id="row_{{$emp->id}}" class="customer_row">
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $emp->asset_no }}</td>
                                        <td>{{ $emp->first_name."  ".$emp->last_name }}</td>
                                        <td>{{ $emp->email }}</td>
                                        <td>{{ $emp->department->name ?? '' }}</td>
                                        <td>{{ $emp->company_mobile_number."<br>".$emp->personal_mobile_number }}</td>
                                        <td>{{ $emp->joinning_date }}</td>
                                        <td>{{ $emp->gender ? 'Male' : 'Fe Male' }}</td>
                                        <td>
                                            @if( true )
                                                <i class="fa fa-{{ ( $emp->status == 0 ) ? 'times' : 'check' }} update-status" data-status="{{$emp->status}}" data-id="{{$emp->id}}" aria-hidden="true" data-table="persons"></i>
                                            @else
                                                <select class="form-control update-status badge {{ ( $emp->status == 0 ) ? 'bg-warning' : 'bg-success' }} text-white" name="status" data-id="{{$data->id}}" data-table="persons">
                                                    <option value="1" {{($emp->status == 1) ? 'selected' : ''}}>Active</option>
                                                    <option value="0" {{($emp->status == 0) ? 'selected' : ''}}>De-Active</option>
                                                </select>
                                            @endif
                                        </td>
                                        <td>{{ formatDate( "Y-m-d H:i", $emp->created_at )}}</td>
                                        <td>{{ formatDate( "Y-m-d H:i", $emp->updated_at )}}</td>
                                        <td>

                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_{{$emp->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                &#x22EE;
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="action_menu_{{$emp->id}}">

                                                @if (Auth::guard('admin')->user()->can('customer.edit'))
                                                    <a class="btn btn-edit text-white dropdown-item" href="{{ route('admin.customer.edit', $emp->id) }}">
                                                        <i class="fa fa-pencil"></i> Edit
                                                    </a>
                                                @endif

                                                @if (Auth::guard('admin')->user()->can('customer.delete'))
                                                    <button class="btn btn-edit text-white delete-record dropdown-item" data-id="{{$emp->id}}" data-title="{{ $emp->first_name.' '.$emp->last_name }}" data-segment="customer">
                                                        <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->

    </div>
</div>
@endsection


@section('scripts')

    @include('backend.layouts.partials.data-table')

     <script>
         /*================================
        datatable active
        ==================================*/
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true,
                dom: '<"row"<"col-md-4"B><"col-md-4 text-left"l><"col-md-4 text-right"f>>' +
                    'rt' +
                    '<"row"<"col-md-6"i><"col-md-6"p>>', // Custom structure with multiple parameters
                buttons: ['excel', 'pdf'],
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                pageLength: 10,
            });
        }

     </script>
@endsection
