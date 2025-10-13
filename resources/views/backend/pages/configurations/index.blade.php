
@extends('backend.layouts.master')

@section('title')
Configuration - Admin Panel
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
        <div class="col-sm-7">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left d-none">Configuration</h4>
                <ul class="breadcrumbs pull-left m-2">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>All Configuration</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3 text-end">
            <a class="btn btn-add text-white" href="{{ route('admin.configurations.create') }}">
                <i class="fa fa-plus"></i> Configuration
            </a>
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
            <h3 class="pb-3">Configuration History</h3>
            <div class="card">
                <div class="card-body">

                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead id="menu" class="bg-light text-capitalize">
                                <tr>
                                    <th>Sr</th>
                                    <th>Name</th>
                                    <th>Key</th>
                                    <th>Value</th>
                                    <th>Update At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataArr as $data)
                                    <tr id="row_{{$data->id}}" class="menu_row">
                                        <td>{{ $loop->index+1 }}</td>
                                        <td class="text-left">{{$data->display_name}}</td>
                                        <td class="text-left">{{$data->key}}</td>
                                        <td class="text-left">{{$data->value}}</td>
                                        <td class="text-left">{{formatDate( "Y-m-d H:i", $data->updated_at )}}</td>
                                        <td>

                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_{{$data->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                &#x22EE;
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="action_menu_{{$data->id}}">

                                                <a class="btn btn-edit text-white dropdown-item" href="{{ route('admin.configurations.edit', $data->id) }}">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                                <button class="btn btn-edit text-white delete-record dropdown-item" data-id="{{$data->id}}" data-title="{{ $data->name }}" data-segment="menu">
                                                    <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                                                </button>
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

            $('#dataTable').css( "width", "100%" );
        }

     </script>
@endsection
