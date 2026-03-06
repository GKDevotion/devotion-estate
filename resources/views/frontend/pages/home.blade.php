@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

    <style>
        body {
            background: #faf3e9;
            font-family: 'Segoe UI', sans-serif;
        }

        .btn-type {
            border: 1px solid transparent;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-type:hover {
            border-color: lightgray;
            background-color: #aa8038;
            color: white;
            /* black border on hover */
        }

        /* Custom hover style */
        .btn-icon {

            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            border-radius: 20%;
            border: 1px solid transparent;
            /* default border invisible */
            transition: all 0.3s ease;
        }

        .btn-icon:hover {
            border-color: #aa8038;
            color: #aa8038;
            /* black border on hover */
            background-color: #f8f9fa;
            /* light background (optional) */
        }

        .carousel-item {
            transition: transform 0.8s ease-in-out;
            /* smoother slide */
        }

        /* ===== WHAT WE OFFER SECTION START ===== */
        .offer-section {
            position: relative;
            background: white;
        }

        .offer-header {
            padding: 80px 0 60px;
        }

        /* BACKGROUND IMAGE */
        .offer-bg {
            height: 450px;
            background: url('public/frontend/assets/images/img/shanghai-aerial-sunset.jpg') center/cover no-repeat;
            background-attachment: fixed;
        }

        /* CARDS */
        .offer-cards {
            margin-top: -200px;
            /* overlap */
            padding-bottom: 80px;
            position: relative;
            z-index: 2;
        }

        .offer-card {
            background: white;
            padding: 40px 30px;
            border-radius: 16px;
            transition: 0.4s ease;
            border: 1px solid transparent;
        }

        .offer-card p,
        .offer-card h4 {
            color: black;
        }

        .center-card {
            margin-top: -40px;
        }

        .offer-card:hover {
            border: 1px solid #aa8038;
            box-shadow: 0 0 25px rgba(197, 168, 128, 0.5);
            transform: translateY(-10px);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background: #aa8038;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 24px;
            color: white;
        }

        .btn-gold {
            background-color: #aa8038;
            border: 1px solid #aa8038;
            color: white;
        }

        /* ===== WHAT WE OFFER SECTION END ===== */
    </style>

    <!-- Hero Carousel -->
    @if (getConfigurationField('SHOW_VIDEO'))

        <div id="heroCarousel" class="carousel slide vh-100" data-bs-ride="carousel">
            <div class="carousel-inner" style="height: 100% !important;">

                <div class="carousel-item active h-100 position-relative">
                    {{-- <iframe
                        class="w-100 h-100 position-absolute top-0 start-0"
                        src="https://www.youtube.com/embed/yQj5YxLEMuw?autoplay=1&mute=1&loop=1&playlist=yQj5YxLEMuw&controls=0&rel=0"
                        frameborder="0"
                        allow="autoplay; encrypted-media"
                        allowfullscreen>
                    </iframe> --}}

                    <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover">
                        <source src="{{ url('public/frontend/assets/video/Inside-Riviera-Jumeirah-720.mp4') }}" type="video/mp4">
                    </video>
                </div>

            </div>

            <!-- ✅ ONE SEARCH BOX FOR ALL SLIDES -->
            <div
                class="search-overlay position-absolute top-50 mt-5 start-50 translate-middle w-100 d-flex justify-content-center">

                <div class="carousel-content text-center">
                    <h1 class="carousel-title mb-2 fs-1" style="color: #aa8038">
                        Find your dream home
                    </h1>

                    <!-- Buttons act as tab triggers -->
                    <div class="mb-3 role-list" role="tablist">

                        <button class="btn btn-light active" id="btn-buy" data-bs-toggle="tab"
                            data-bs-target="#content-buy" type="button" role="tab" aria-controls="content-buy"
                            aria-selected="true">
                            Buy
                        </button>

                        <button class="btn btn-light" id="btn-rent" data-bs-toggle="tab" data-bs-target="#content-rent"
                            type="button" role="tab" aria-controls="content-rent" aria-selected="false">
                            Rent
                        </button>

                        <button class="btn btn-light d-none" id="btn-land" data-bs-toggle="tab"
                            data-bs-target="#content-land" type="button" role="tab" aria-controls="content-land"
                            aria-selected="false">
                            Land
                        </button>

                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content carousel-tab-content  rounded-3">

                        <!-- BUY -->
                        <div class="tab-pane fade show active p-3" id="content-buy" role="tabpanel"
                            aria-labelledby="btn-buy">
                            <form action="{{ route('properties.search') }}" autocomplete="off">

                                <div class="row g-3 align-items-end justify-content-center" style="width: 1077px;">

                                    <!-- Location -->
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="input-group">
                                            <select name="location" class="form-select select-location">
                                                <option value="">Search Location</option>
                                                @foreach ($location as $p)
                                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <!-- Developer -->
                                    <div class="col-lg-2 col-md-6 col-sm-12">
                                        <div class="input-group">
                                            <select name="developer" class="form-select select-developer">
                                                <option value="">Search Developer</option>
                                                @foreach ($developer as $p)
                                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Property Type -->
                                    <div class="col-lg-2 col-md-6 col-sm-12">

                                        <select class="form-select" id="type" name="type" style="font-size: 1rem;">
                                            <option value="" selected disabled>Property Type</option>
                                            <option value="1">Residential</option>
                                            <option value="2">Commercial</option>
                                        </select>
                                    </div>

                                    <!-- Property Sub Type -->
                                    <div class="col-lg-2 col-md-6 col-sm-12">
                                        <select class="form-select" id="sub_type" name="sub_type" style="font-size: 1rem;">
                                            <option value="" select disabled> Sub Type</option>
                                            @foreach ($propertyTypeObj as $type)
                                                <option value="{{ $type->id }}" data-main="{{ $type->main_type }}"
                                                    class="dynamic default-sub-type-hide d-none">
                                                    {{ $type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Keyword -->
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <input type="text" class="form-control rounded-2" name="keyword"
                                            placeholder="Search Keyword here">
                                    </div>

                                    <!-- Search Button -->
                                    <div class="col-lg-1 col-md-6 col-sm-12 d-grid" style="width: 148px;">
                                        <button class="btn search-btn" type="submit">
                                            Search Now <i class="bi bi-search"></i>
                                        </button>
                                    </div>

                                </div>

                            </form>
                        </div>

                        <!-- RENT -->
                        <div class="tab-pane fade p-3 text-center" id="content-rent" role="tabpanel"
                            aria-labelledby="btn-rent">

                            <div class="row g-3 align-items-end justify-content-center" style="width: 1077px;">

                                <!-- Location -->
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="input-group">
                                        <select name="location" class="form-select select2">
                                            <option value="">Search Location</option>
                                            @foreach ($location as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Developer -->
                                <div class="col-lg-2 col-md-6 col-sm-12">
                                    <div class="input-group">
                                        <select name="developer" class="form-select select-developer">
                                            <option value="">Search Developer</option>
                                            @foreach ($developer as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Property Type -->
                                <div class="col-lg-2 col-md-6 col-sm-12">

                                    <select class="form-select" id="type" name="type" style="font-size: 1rem;">
                                        <option value="" selected disabled>Property Type</option>
                                        <option value="1">Residential</option>
                                        <option value="2">Commercial</option>
                                    </select>
                                </div>

                                <!-- Property Sub Type -->
                                <div class="col-lg-2 col-md-6 col-sm-12">
                                    <select class="form-select" id="sub_type" name="sub_type" style="font-size: 1rem;">
                                        <option value="" select disabled> Sub Type</option>
                                        @foreach ($propertyTypeObj as $type)
                                            <option value="{{ $type->id }}" data-main="{{ $type->main_type }}"
                                                class="dynamic default-sub-type-hide d-none">
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <!-- Keyword -->
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <input type="text" class="form-control rounded-2" name="keyword"
                                        placeholder="Search Keyword here">
                                </div>

                                <!-- Search Button -->
                                <div class="col-lg-1 col-md-6 col-sm-12 d-grid" style="width: 148px;">
                                    <button class="btn search-btn" type="submit">
                                        Search Now <i class="bi bi-search"></i>
                                    </button>
                                </div>

                            </div>
                        </div>

                        <!-- LAND -->
                        <div class="tab-pane fade p-3 text-center d-none " id="content-land" role="tabpanel"
                            aria-labelledby="btn-land">

                            <div class="row g-3 align-items-end justify-content-center" style="width: 1077px;">

                                <!-- Location -->
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="input-group">
                                        <select name="location" class="form-select select2">
                                            <option value="">Search Location</option>
                                            @foreach ($location as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Developer -->
                                <div class="col-lg-2 col-md-6 col-sm-12">
                                    <div class="input-group">
                                        <select name="developer" class="form-select select-developer">
                                            <option value="">Search Developer</option>
                                            @foreach ($developer as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <!-- Property Type -->
                                <div class="col-lg-2 col-md-6 col-sm-12">

                                    <select class="form-select" id="type" name="type" style="font-size: 1rem;">
                                        <option value="" selected disabled>Property Type</option>
                                        <option value="1">Residential</option>
                                        <option value="2">Commercial</option>
                                    </select>
                                </div>

                                <!-- Property Sub Type -->
                                <div class="col-lg-2 col-md-6 col-sm-12">
                                    <select class="form-select" id="sub_type" name="sub_type" style="font-size: 1rem;">
                                        <option value="" select disabled> Sub Type</option>
                                        @foreach ($propertyTypeObj as $type)
                                            <option value="{{ $type->id }}" data-main="{{ $type->main_type }}"
                                                class="dynamic default-sub-type-hide d-none">
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <!-- Keyword -->
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <input type="text" class="form-control rounded-2" name="keyword"
                                        placeholder="Search Keyword here">
                                </div>

                                <!-- Search Button -->
                                <div class="col-lg-1 col-md-6 col-sm-12 d-grid" style="width: 148px;">
                                    <button class="btn search-btn" type="submit">
                                        Search Now <i class="bi bi-search"></i>
                                    </button>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    @else
        <div id="heroCarousel" class="carousel slide carousel-fade h-100" data-bs-ride="carousel"
            data-bs-interval="4000">
            <div class="carousel-inner">

                @if (count($bannerObjs) > 0)
                    @foreach ($bannerObjs as $key => $banner)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/app/banner/' . $banner->image) }}" class="d-block w-100"
                                alt="{{ $banner->name }}">
                            <div class="carousel-caption">
                                <h1 class="carousel-title mb-2">{{ $banner->name }}</h1>
                                <p class="carousel-subtitle mb-4">{{ $banner->sub_title }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Default message if no banners exist -->
                    <div class="carousel-item active">
                        <div class="d-flex justify-content-center align-items-center"
                            style="height: 400px; background:#dcd6d6;">
                            <h3 class="text-muted"></h3>
                        </div>
                    </div>
                @endif

            </div>

            <!-- ✅ ONE SEARCH BOX FOR ALL SLIDES -->
            <div class="d-none search-overlay position-absolute top-50 mt-5 start-50 translate-middle w-100 d-flex justify-content-center">
                <div class="carousel-content text-center p-4 rounded-3">
                </div>
            </div>

            <div class="container" style="position: absolute; left: 50%; bottom: -50px; transform: translateX(-50%); z-index: 10;">

                <!-- Buttons act as tab triggers -->
                <div class="mb-3 d-none" role="tablist">

                    <button class="btn btn-light active" id="btn-buy" data-bs-toggle="tab"
                        data-bs-target="#content-buy" type="button" role="tab" aria-controls="content-buy"
                        aria-selected="true">
                        Buy
                    </button>

                    <button class="btn btn-light" id="btn-rent" data-bs-toggle="tab" data-bs-target="#content-rent"
                        type="button" role="tab" aria-controls="content-rent" aria-selected="false">
                        Rent
                    </button>

                    <button class="btn btn-light d-none" id="btn-land" data-bs-toggle="tab"
                        data-bs-target="#content-land" type="button" role="tab" aria-controls="content-land"
                        aria-selected="false">
                        Land
                    </button>

                </div>

                <!-- Tab Content -->
                <div class="tab-content carousel-tab-content rounded-3">

                    <!-- BUY -->
                    <div class="tab-pane fade show active p-3" id="content-buy" role="tabpanel"
                        aria-labelledby="btn-buy">
                        <form action="{{ route('properties.search') }}" autocomplete="off">
                            <div class="row g-3 align-items-center justify-content-center">

                                <!-- Location -->
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-geo-alt"></i>
                                        </span>
                                        <select name="location" class="form-select border-start-1">
                                            <option value="" select>All Location</option>
                                            @foreach ($location as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-6 col-sm-12">

                                    <select class="form-select" id="type" name="type"
                                        style="font-size: 0.9rem;">
                                        <option value="" selected disabled>Property Type</option>
                                        <option value="1">Residential</option>
                                        <option value="2">Commercial</option>
                                    </select>
                                </div>

                                <div class="col-lg-2 col-md-6 col-sm-12">
                                    <select class="form-select" id="sub_type" name="sub_type"
                                        style="font-size: 0.9rem;">
                                        <option value="" selected disabled> Sub Type</option>
                                        @foreach ($propertyTypeObj as $type)
                                            <option value="{{ $type->id }}" data-main="{{ $type->main_type }}"
                                                class="dynamic default-sub-type-hide d-none">
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Hidden input -->
                                <input type="hidden" name="redirect_page" value="off">

                                <!-- Keyword -->
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <input type="text" class="form-control" name="keyword"
                                        placeholder="Search Keyword here">
                                </div>

                                <!-- Search Button -->
                                <div class="col-lg-2 col-md-6 col-sm-12">
                                    <button class="btn search-btn px-3" type="submit">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </div>

                            <button class="btn search-btn mt-4 d-none" type="submit">
                                Search Now <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- RENT -->
                    <div class="tab-pane fade p-3 text-center" id="content-rent" role="tabpanel"
                        aria-labelledby="btn-rent">
                        <div class="row g-3 align-items-center justify-content-center">

                            <!-- Location -->
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>
                                    <select name="location" class="form-select border-start-1">
                                        <option value="0" select disabled>Location</option>
                                        @foreach ($location as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-12">

                                <select class="form-select" id="type" name="type" style="font-size: 0.9rem;"
                                    required>
                                    <option value="" selected disabled>Property Type</option>
                                    <option value="1">Residential</option>
                                    <option value="2">Commercial</option>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-6 col-sm-12">
                                <select class="form-select" id="sub_type" name="sub_type"
                                    style="font-size: 0.9rem;" required>
                                    <option value="" select disabled>Sub Type</option>
                                    @foreach ($propertyTypeObj as $type)
                                        <option value="{{ $type->id }}" data-main="{{ $type->main_type }}"
                                            class="dynamic default-sub-type-hide d-none">
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Hidden input -->
                            <input type="hidden" name="redirect_page" value="off">

                            <!-- Keyword -->
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <input type="text" class="form-control" name="keyword"
                                    placeholder="Search Keyword here">
                            </div>
                        </div>

                        <button class="btn search-btn mt-4" type="submit">
                            Search Now <i class="bi bi-search"></i>
                        </button>
                    </div>

                    <!-- LAND -->
                    <div class="tab-pane fade p-3 text-center d-none " id="content-land" role="tabpanel"
                        aria-labelledby="btn-land">
                        <div class="row g-3 align-items-center justify-content-center">

                            <!-- Location -->
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>
                                    <select name="location" class="form-select border-start-1">
                                        <option value="0">Select Location</option>
                                        @foreach ($location as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Rent/Buy/Land -->
                            <div class="col-lg-2 col-md-6 col-sm-12">
                                <select name="purpose" class="form-select">
                                    <option value="0">All</option>
                                    <option value="1">Rent</option>
                                    <option value="2">Buy</option>
                                    <option value="3">Land</option>
                                </select>
                            </div>

                            <!-- Residential/Commercial -->
                            <div class="col-lg-2 col-md-6 col-sm-12">
                                <select name="type" class="form-select">
                                    <option value="0">All</option>
                                    <option value="1">Residential</option>
                                    <option value="2">Commercial</option>
                                </select>
                            </div>

                            <!-- Hidden input -->
                            <input type="hidden" name="redirect_page" value="off">

                            <!-- Keyword -->
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <input type="text" class="form-control" name="keyword"
                                    placeholder="Search Keyword here">
                            </div>
                        </div>

                        <button class="btn search-btn mt-4" type="submit">
                            Search Now <i class="bi bi-search"></i>
                        </button>
                    </div>

                </div>

            </div>
        </div>
    @endif

    <!-- Properties For New -->
    <section class="py-5" style="background-color: #fff;">
        <div class="container">
            <div class="text-end mb-0 mt-5">
                <div class="text-center flex-grow-1">
                    <h2 class="fw-bold text-uppercase mb-1">New Properties</h2>
                    <p class="text-muted mb-0">Find newly listed properties in your local area with best pricing.</p>
                </div>

                <div>
                    <a href="{{ route('new.properties') }}" class="text-decoration-none small text-secondary">View all
                        &rarr;</a>
                </div>

            </div>
            <style>
                h2 {
                    font-size: 40px;
                }
            </style>
            @php
                /**
                 * $type = 0: 'sell', 1: 'rent'
                 */
                $allproperties = getPropertiesByType([1, 2], 'is_new_property');
                $chunks = $allproperties->chunk(3);
            @endphp


            @if ($allproperties->isNotEmpty())
                <div id="propertyCarousel" class="carousel slide" data-bs-wrap="false" data-bs-ride="carousel"
                    data-bs-interval="{{ $carouselInterval }}">
                    <div class="carousel-inner">

                        @foreach ($chunks as $chunkIndex => $chunk)
                            <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    @foreach ($chunk as $property)
                                        <div class="col pt-2">
                                            <a href="{{ route('property.detail', $property->slug) }}"
                                                class="text-decoration-none text-dark">

                                                <div class="card property-card h-100 border-1 shadow-sm rounded-3">

                                                    <div class="position-relative">
                                                        <img src="{{ asset('storage/app/propertyImage/' . ($property->single_image->filename ?? 'devotion-trusted-real-estate.png')) }}"
                                                            class="card-img-top rounded-top-3"
                                                            alt="{!! $property->name !!}">
                                                    </div>

                                                    <!-- BODY -->
                                                    <div class="card-body">

                                                        <!-- TITLE -->

                                                        <div class="d-flex align-items-start mb-2">
                                                            <h5 class="card-title mb-0 " style="min-height: 50px">
                                                                {!! $property->name !!}
                                                            </h5>
                                                        </div>

                                                        <!-- LOCATION -->
                                                        <p class="card-text small text-muted mb-1">
                                                            <i class="bi bi-map me-2"></i>
                                                            {{ ucfirst($property->location->name ?? 'N/A') }}
                                                        </p>

                                                        <!-- DETAILS -->
                                                        <p class="card-text small mb-0">
                                                            @if ($property->type != 2)
                                                                <i class="bi bi-door-closed me-1"></i>
                                                                Beds:
                                                                {{ $property->beds == 0 ? 'Studio' : $property->beds }}
                                                            @endif
                                                            @if ($property->type != 2)
                                                                <i class="bi bi-bucket me-1 "></i>
                                                                Baths: {{ $property->baths }}
                                                            @endif
                                                            @if ($property->type == 2)
                                                                <i class="bi bi-bookmark me-1"></i>
                                                                <span class="small">
                                                                    {{ $property->subType->name }}</span>
                                                            @endif
                                                            <i class="bi bi-rulers me-1 ms-2"></i>
                                                            Area: {{ $property->area }} Sq.Ft.
                                                        </p>

                                                    </div>

                                                    <hr class="property-divider my-2">

                                                    <!-- FOOTER -->
                                                    <div
                                                        class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                                                        <p class="fs-5 property-price mb-0">
                                                            AED {{ number_format($property->price, 2) }}
                                                        </p>
                                                        <img src="{{ url('public/frontend/assets/images/Devotion Real Estate.png') }}"
                                                            alt="Logo" class="property-logo img-fluid">
                                                    </div>

                                                </div>

                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="carousel-indicators position-relative mt-4">
                        @foreach ($chunks as $index => $chunk)
                            <button type="button" data-bs-target="#propertyCarousel"
                                data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"
                                aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-center text-muted">No new properties available at the moment.</p>
            @endif
        </div>
    </section>

    <!-- Properties For Sale -->
    <section class="py-5" style="background-color: #fefefe;">
        <div class="container">
            <div class="text-end mb-5">
                <div class="text-center flex-grow-1">
                    <h2 class="fw-bold text-uppercase mb-1" style="font-size: 45px;">Properties for sale</h2>
                    <p class="text-muted mb-0">Search properties which are listed as available for sale in your local area
                        with
                        best pricing.</p>
                </div>
                <a href="{{ route('buy.properties') }}" class="text-decoration-none small text-secondary">View all
                    &rarr;</a>
            </div>

            @php
                $saleProperties = getPropertiesByType([1], null, true)->shuffle();
                $saleChunks = $saleProperties->chunk(3);
            @endphp


            @if ($saleProperties->isNotEmpty())
                <div id="salePropertyCarousel" class="carousel slide" data-bs-wrap="true" data-bs-ride="carousel"
                    data-bs-interval="{{ $carouselInterval }}">
                    <div class="carousel-inner">

                        @foreach ($saleChunks as $chunkIndex => $chunk)
                            <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    @foreach ($chunk as $propertysale)
                                        <div class="col pt-2">

                                            <a href="{{ route('property.detail', $propertysale->slug) }}"
                                                class="text-decoration-none text-dark">
                                                <div class="card property-card h-100 border-1 shadow-sm rounded-3">
                                                    <div class="position-relative">
                                                        <img src="{{ asset('storage/app/propertyImage/' . ($propertysale->single_image->filename ?? 'devotion-trusted-real-estate.png')) }}"
                                                            class="card-img-top rounded-top-3"
                                                            alt="{{ $propertysale->title }}">

                                                    </div>

                                                    <div class="card-body">

                                                        <div class="d-flex align-items-start mb-2">
                                                            <h5 class="card-title mb-0" style="min-height: 50px">
                                                                {!! $propertysale->name !!}
                                                            </h5>
                                                        </div>

                                                        <p class="card-text small text-muted mb-1">
                                                            <i class="bi bi-map me-2"></i>
                                                            {{ ucfirst($propertysale->location->name ?? 'N/A') }}
                                                        </p>
                                                        <p class="card-text small mt-0">
                                                            @if ($propertysale->type != 2)
                                                                <i class="bi bi-door-closed me-1"></i>
                                                                Beds:
                                                                {{ $propertysale->beds == 0 ? 'Studio' : $propertysale->beds }}
                                                            @endif
                                                            @if ($propertysale->type != 2)
                                                                <i class="bi bi-bucket me-2"></i>
                                                                Baths: {{ $propertysale->baths }}
                                                            @endif
                                                            {{-- </p>
                                                        <p class="card-text small"> --}}
                                                            @if ($propertysale->type == 2)
                                                                <i class="bi bi-bookmark me-1"></i>
                                                                <span class="small">
                                                                    {{ $propertysale->subType->name }}</span>
                                                            @endif
                                                            <i class="bi bi-rulers me-2 ms-2"></i>
                                                            Area: {{ $propertysale->area }} Sq.Ft.
                                                            {{-- </p> --}}

                                                            {{-- <button class="d-none btn btn-type rounded-pill btn-sm featureMap">
                                                            {{ $property->subType->name ?? '' }}
                                                        </button> --}}

                                                    </div>

                                                    <hr class="property-divider">

                                                    <div
                                                        class="card-footer bg-white border-top-0 d-flex mb-2 justify-content-between align-items-center">
                                                        <p class="fs-5  property-price mb-0">
                                                            AED {{ number_format($propertysale->price, 2) }}</p>
                                                        <div class="text-end">
                                                            <img src="{{ url('public/frontend/assets/images/Devotion Real Estate.png') }}"
                                                                alt="Logo" class="property-logo img-fluid">
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="carousel-indicators position-relative mt-4">
                        @foreach ($saleChunks as $index => $chunk)
                            <button type="button" data-bs-target="#salePropertyCarousel"
                                data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"
                                aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $index + 1 }}" style="background-color: lightgray"></button>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-center text-muted">No new properties available at the moment.</p>
            @endif
        </div>
    </section>

    <!-- Our Developers -->
    <section class="py-5 bg-white">
        <div class="container position-relative">

            <div class="text-center mb-4">
                <h2 class="fw-bold text-uppercase mb-1 pb-3">Our Trusted Partners</h2>
            </div>

            <!-- Swiper -->
            <div class="swiper partnerSwiper">
                <div class="swiper-wrapper align-items-center">

                    @foreach ($developerImages as $partner)
                        @if (!empty($partner->image))
                            <div class="swiper-slide d-flex justify-content-center">
                                <a href="{{ route('developer.properties', $partner->id) }}"
                                    class="partner-card text-center">

                                    <img src="{{ asset('storage/app/developer/' . $partner->image) }}"
                                        alt="{{ $partner->name }}" class="img-fluid grayscale">
                                </a>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>

        </div>
    </section>

    <!-- ===== WHAT WE OFFER SECTION ===== -->
    <section class="offer-section d-none">

        <!-- HEADER -->
        <div class="offer-header text-center">
            <div class="container">
                <h2 class="fw-bold text-dark text-uppercase mb-1">What We Offer</h2>
                <p class="text-muted mb-0">
                    From property advisory to investment planning and full transaction support,
                    we provide end-to-end real estate solutions you can trust.
                </p>
            </div>
        </div>

        <!-- BACKGROUND IMAGE -->
        <div class="offer-bg"></div>

        <!-- CARDS -->
        <div class="offer-cards">
            <div class="container">
                <div class="row g-4 justify-content-center">

                    <!-- Card 1 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="offer-card">
                            <div class="icon-box mb-4">
                                <i class="bi bi-gem"></i>
                            </div>
                            <h4>Luxury Real Estate Advisory</h4>
                            <p>
                                Personalized guidance for buyers and investors seeking long-term value
                                in Dubai’s premium real estate market.
                            </p>
                            <a href="#" class="btn btn-gold mt-3">Learn More</a>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="offer-card center-card">
                            <div class="icon-box mb-4">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <h4>Investment Consulting</h4>
                            <p>
                                Strategic advice focused on rental demand, appreciation potential,
                                exit planning, and portfolio growth.
                            </p>
                            <a href="#" class="btn btn-gold mt-3">Learn More</a>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="offer-card">
                            <div class="icon-box mb-4">
                                <i class="bi bi-flag"></i>
                            </div>
                            <h4>End-to-End Support</h4>
                            <p>
                                From property shortlisting and booking to documentation, payments,
                                and handover coordination – handled seamlessly.
                            </p>
                            <a href="#" class="btn btn-gold mt-3">Learn More</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>

    <!-- List Your Property -->
    <section class="d-none py-5 list-property-section">
        <div class="container py-5">
            <h1 class="text-center mb-5 fw-bold section-title" style="color: #000; font-size: 45px;">LIST YOUR
                PROPERTY</h1>
            <div class="row g-4 justify-content-center">

                <!-- Sell Residential -->
                <div class="col-lg-3 col-md-6 col-sm-10 mx-auto">
                    <div class="card property-card h-100 border-0 shadow-sm text-center"
                        style=" background: linear-gradient(#FBEED3, #F9E5B8);">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <img src="{{ url('public/frontend/assets/images/img/sell-house.png') }}"
                                    alt="Sell Residential Icon" class="property-icon">
                            </div>
                            <h4 class="card-title fw-semibold text-center">Sell Residential</h4>
                            <p class="card-text property-text">
                                We will connect you to thousands of people who need to buy a home.
                            </p>
                        </div>
                        <a class="btn property-btn">
                            <i class="bi bi-house-door me-2"></i>Sell Residential
                        </a>
                    </div>
                </div>

                <!-- Rent Residential -->
                <div class="col-lg-3 col-md-6 col-sm-10 mx-auto">
                    <div class="card property-card h-100 border-0 shadow-sm text-center"
                        style="background: linear-gradient(#FBEED3, #F9E5B8);">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <img src="{{ url('public/frontend/assets/images/img/rent-house.png') }}"
                                    alt="Rent Residential Icon" class="property-icon">
                            </div>
                            <h4 class="card-title fw-semibold text-center">Rent Residential</h4>
                            <p class="card-text property-text">
                                Tell us your needs, we will give you thousands of suggestions for the dream home.
                            </p>
                        </div>
                        <a class="btn property-btn">
                            <i class="bi bi-house-door me-2"></i>Rent Residential
                        </a>
                    </div>
                </div>

                <!-- Sell Commercial -->
                <div class="col-lg-3 col-md-6 col-sm-10 mx-auto">
                    <div class="card property-card h-100 border-0 shadow-sm text-center"
                        style="background: linear-gradient(#FBEED3, #F9E5B8);">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <img src="{{ url('public/frontend/assets/images/img/office-1.png') }}"
                                    alt="Sell Commercial Icon" class="property-icon">
                            </div>
                            <h4 class="card-title fw-semibold text-center">Sell Commercial</h4>
                            <p class="card-text property-text">
                                We will connect you to thousands of people who need to buy an office.
                            </p>
                        </div>
                        <a class="btn property-btn">
                            <i class="bi bi-shop me-2"></i>Sell Commercial
                        </a>
                    </div>
                </div>

                <!-- Rent Commercial -->
                <div class="col-lg-3 col-md-6 col-sm-10 mx-auto">
                    <div class="card property-card h-100 border-0 shadow-sm text-center"
                        style="background: linear-gradient(#FBEED3, #F9E5B8);">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <img src="{{ url('public/frontend/assets/images/img/rent-office.png') }}"
                                    alt="Rent Commercial Icon" class="property-icon">
                            </div>
                            <h4 class="card-title fw-semibold text-center">Rent Commercial</h4>
                            <p class="card-text property-text">
                                Tell us your needs, we will give you thousands of suggestions for the dream office.
                            </p>
                        </div>
                        <a class="btn property-btn">
                            <i class="bi bi-shop me-2"></i>Rent Commercial
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-5">
            <h2 class="section-title">LIST YOUR PROPERTY</h2>

            <div class="row g-4">

                <!-- Sell Residential -->
                <div class="col-md-6 col-lg-3">
                    <div class="property-card" style="padding: 10px;">
                        <i class="bi bi-house-door-fill property-icon"></i>
                        <h5>Sell Residential</h5>
                        <p>We will connect you to thousands of people who need to buy a home.</p>
                        <button class="property-btn">Sell Residential</button>
                    </div>
                </div>

                <!-- Rent Residential -->
                <div class="col-md-6 col-lg-3">
                    <div class="property-card" style="padding: 10px;">
                        <i class="fa-solid fa-house-circle-check property-icon"></i>
                        <h5>Rent Residential</h5>
                        <p>Tell us your needs; we’ll give you thousands of suggestions for your dream home.</p>
                        <button class="property-btn">Rent Residential</button>
                    </div>
                </div>

                <!-- Sell Commercial -->
                <div class="col-md-6 col-lg-3">
                    <div class="property-card" style="padding: 10px;">
                        <i class="fa-solid fa-store property-icon"></i>
                        <h5>Sell Commercial</h5>
                        <p>We help you find thousands of buyers looking for office or commercial spaces.</p>
                        <button class="property-btn">Sell Commercial</button>
                    </div>
                </div>

                <!-- Rent Commercial -->
                <div class="col-md-6 col-lg-3">
                    <div class="property-card" style="padding: 10px;">
                        <i class="bi bi-building-fill property-icon"></i>
                        <h5>Rent Commercial</h5>
                        <p>Share your needs and we’ll offer suitable options for your commercial property.</p>
                        <button class="property-btn">Rent Commercial</button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Our Blog -->
    <section class="py-5 text-center" style="background: #fffaf5;">
        <div class="container">
            <div class="col-12 blog-header text-center mb-4">
                <h1 class="text-uppercase fw-bold section-title">OUR BLOGS</h1>
                <p class="text-muted section-subtitle">
                    "Insights, Updates, and Expert Advice to Empower Your Financial Journey"
                </p>
            </div>

            <div class="row g-4 justify-content-center">

                @foreach ($blogs as $blog)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-50">
                            <div class="position-relative">
                                <a href="{{ route('blog.details', $blog->slug) }}"
                                    class="text-decoration-none fw-semibold small" style="color: #aa8038;">
                                    <img src="{{ asset('storage/app/blog/' . $blog->image) }}"
                                        class="card-img-top rounded-3" alt="{{ $blog->title }}">
                                </a>

                                <div
                                    class="position-absolute bottom-0 start-50 translate-middle-x mb-3 bg-white rounded-pill px-3 py-1 small shadow-sm d-flex align-items-center">
                                    <span class="me-2">
                                        {{ $blog->created_at->format('d F') }}
                                    </span>

                                    <i class="bi bi-folder2-open me-1"></i>
                                    <span>{{ $blog->category?->title ?? 'Devotion  ' }}</span>

                                </div>
                            </div>

                            <div class="card-body-blog ">
                                <h6 class="mt-2 fw-semibold">
                                    {{ Str::limit($blog->title, 60) }}
                                </h6>

                                <a href="{{ route('blog.details', $blog->slug) }}"
                                    class="text-decoration-none fw-semibold small" style="color: #aa8038;">
                                    Read more <i class="bi bi-arrow-right-short"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>


    <!-- OUR HAPPY CUSTOMERS  -->
    <section class="py-5" style="background-color: white;">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h1 class="text-uppercase fw-bold text-black" style=" font-size: 45px;">OUR HAPPY CUSTOMERS</h1>
                    <p class="text-muted" style="font-size: smaller;">Real Stories, Genuine Feedback - See What Our
                        Customers
                        Have to Say</p>
                </div>
            </div>

            <div class="row justify-content-center g-4">

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 p-4 shadow-sm border-0">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <span class="fs-2" style="color: #aa8038;"><i class="bi bi-chat-right-text"></i></span>
                            </div>
                            <p class="card-text " style="text-align: justify;">

                                “ I first met Nikunj in 2022, but did not buy anything as was looking just for some options.
                                He was
                                really nice and offered me multiple units. When I was ready in the beginning of 2023, Nikunj
                                helped me
                                to find best solutions for my needs and used his all power and good connections with
                                developers to get
                                me the best unit for best price. I have used Nikunj help multiple times and he is more than
                                agent, he
                                became my good friend who also helped me a lot with Dubai questions, as he lives here more
                                than 15 years
                                and know more about Dubai than most of agents. His kindness makes him not only good broker
                                but a good
                                person and You can rely on his promises.. ”

                            </p>
                            <p class="text-end fw-bold mb-0">
                                - Sander
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 p-4 shadow-sm border-0">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <span class="fs-2" style="color: #aa8038;"><i class="bi bi-chat-right-text"></i></span>
                            </div>
                            <p class="card-text" style="text-align: justify;">
                                "Your professionalism, expertise, and attention to detail made the entire process smooth and
                                stress-free. We truly appreciate your patience and guidance throughout each step. Your
                                ability to
                                understand our needs and preferences was instrumental in finding the perfect home for our
                                family."
                                <br>
                                " Thank you once again for your outstanding service. We will certainly recommend you to
                                anyone in need
                                of a top-notch real estate agent. ”
                            </p>
                            <p class="text-end fw-bold mb-0" style="text-align: justify;">
                                - Severin
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 p-4 shadow-sm border-0">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <span class="fs-2" style="color: #aa8038;"><i class="bi bi-chat-right-text"></i></span>
                            </div>
                            <p class="card-text">
                                “Our agent Mr waseem was excellent, his proactive approach ,along with her friendly and
                                professional
                                attitude made the entire process smooth, he was always ready to answer any queries and
                                assured that we
                                were comfortable every step of the way.
                                Overall very satisfied ”
                            </p>
                            <p class="text-end fw-bold mb-0">
                                - Fathima Mufeel
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @if (count($awardObjs) > 0)
        <!-- Our Achivements -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Our Achievements</h2>
                    <p class="text-muted">Recognizing excellence and commitment</p>
                </div>

                <div class="row g-4">

                    @foreach ($awardObjs as $key => $award)
                        <!-- Award -->
                        <div class="col-md-4">
                            <div class="award-box text-center p-4 shadow-sm rounded">
                                <img src="{{ asset('storage/app/award/' . $award->image) }}"
                                    class="img-fluid mb-3 award-img" alt="{{ $award->name }}">
                                <h5 class="fw-bold">{{ $award->name }}</h5>
                                <p class="text-muted small">
                                    {{ $award->sub_title }}
                                </p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>

    @endif

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
        $(function() {
            const $type = $('#type');
            const $sub = $('#sub_type');
            const $opts = $sub.find('option.dynamic, .default-sub-type-hide');

            $type.on('change', function() {
                const val = String($(this).val() ?? '').trim();
                $opts.addClass('d-none').prop('disabled', true)
                    .filter(`[data-main="${val}"], .show-${val}`)
                    .removeClass('d-none').prop('disabled', false);
                $sub.val('');
            });

            // Initial check (for edit pages)
            $type.trigger('change');
        });

        $(document).ready(function() {
            $('.select-developer').select2({
                placeholder: "Search Developer",
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.select-location').select2({
                placeholder: "Search Location",
                allowClear: true,
                width: '100%',
                minimumInputLength: 3,
                ajax: {
                    transport: function(params, success, failure) {
                        let term = params.data.q ? params.data.q.trim() : '';

                        // 🔥 BLOCK space-only or short input
                        if (term.length < 3) {
                            success({
                                results: []
                            });
                            return;
                        }

                        params.data.q = term;

                        return $.ajax(params).then(success).fail(failure);
                    },
                    url: "{{ route('locations.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                language: {
                    noResults: function() {
                        return 'Type at least 3 characters';
                    }
                }
            });

            $(window).on('scroll', function() {
                $('.select-location').select2('close');
            });
        });
    </script>

    <script>
        const partnerSwiper = new Swiper('.partnerSwiper', {
            slidesPerView: 5,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            breakpoints: {
                320: {
                    slidesPerView: 2
                },
                576: {
                    slidesPerView: 3
                },
                768: {
                    slidesPerView: 4
                },
                992: {
                    slidesPerView: 5
                },
            }
        });

        // Pause on hover
        const swiperEl = document.querySelector('.partnerSwiper');

        swiperEl.addEventListener('mouseenter', () => {
            partnerSwiper.autoplay.stop();
        });

        swiperEl.addEventListener('mouseleave', () => {
            partnerSwiper.autoplay.start();
        });
    </script>

@endsection
