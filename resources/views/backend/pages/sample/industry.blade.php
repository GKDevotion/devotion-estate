
@extends('backend.layouts.master')

@section('title')
Industries Page - Admin Panel
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-8">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left d-none">Industries</h4>
                <ul class="breadcrumbs pull-left m-2">
                    <li><a href="{{url('admin')}}">Home</a></li>
                    <li><span>Industries</span></li>
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
    <div class="row mt-4">
        @foreach( $resultArr as $k=>$ind )
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="seo-fact" style="background: linear-gradient(159deg, rgb(52, 86, 139) 0%, rgb(52, 86, 139, 0.65) 90%);">
                        <a href="#">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    <i class="fa fa-tasks"></i>{{$ind->name}}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
