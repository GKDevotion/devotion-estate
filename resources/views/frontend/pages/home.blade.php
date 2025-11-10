@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>

        <link href="{{ asset('public/frontend/css/custom.css') }}" rel="stylesheet">
    </head>

    <style>
        .search-overlay {
            z-index: 50;
            pointer-events: auto;
        }

        .carousel-caption {
            position: absolute;
            right: 15%;
            top: 5.5rem;
            left: 15%;
            padding-top: 1.25rem;
            padding-bottom: 1.25rem;
            color: var(--bs-carousel-caption-color);
            text-align: center;
        }

        /* Hover effect */
        .btn-light:hover {
            background-color: #aa8038;
            /* Bootstrap primary color */
            color: #fff;
            border-color: #a78234;
            transition: all 0.3s ease;
        }

        /* Active (selected tab) effect */
        .btn-light.active {
            background-color: #aa8038;
            color: #fff;
            border-color: #a78234;
            box-shadow: 0 0 8px #c29444;
        }

        /* Optional: add small animation */
        .btn-light {
            transition: all 0.3s ease;
        }
    </style>

    <!-- Hero Carousel -->
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">

        <div class="carousel-inner">

            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="{{ url('public/frontend/assets/images/img/slide3.jpg') }}" class="d-block w-100" alt="">
                <div class="carousel-caption">
                    <h1 class="carousel-title mb-2">Find your dream home</h1>
                    <h1 class="carousel-title mb-4">with Us</h1>
                    <p class="carousel-subtitle mb-4">
                        Affordable options, easy financing, expert advice every step of the way
                    </p>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="{{ url('public/frontend/assets/images/img/slide1.jpg') }}" class="d-block w-100" alt="">
                <div class="carousel-caption">
                    <h1 class="carousel-title mb-2">Find your perfect</h1>
                    <h1 class="carousel-title mb-4">home</h1>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="{{ url('public/frontend/assets/images/img/slide2.jpg') }}" class="d-block w-100" alt="">
                <div class="carousel-caption">
                    <h1 class="carousel-title mb-4">Start your journey</h1>
                </div>
            </div>

        </div>

        <!-- ✅ ONE SEARCH BOX FOR ALL SLIDES -->
        <div class="search-overlay position-absolute top-50 mt-5 start-50 translate-middle w-100 d-flex justify-content-center">
            <div class="carousel-content text-center p-4 rounded-3">

                <!-- Buttons act as tab triggers -->
                <div class="mb-3" role="tablist">

                    <button class="btn btn-light active" id="btn-buy" data-bs-toggle="tab" data-bs-target="#content-buy"
                        type="button" role="tab" aria-controls="content-buy" aria-selected="true">
                        Buy
                    </button>

                    <button class="btn btn-light" id="btn-rent" data-bs-toggle="tab" data-bs-target="#content-rent"
                        type="button" role="tab" aria-controls="content-rent" aria-selected="false">
                        Rent
                    </button>

                    <button class="btn btn-light d-none" id="btn-land" data-bs-toggle="tab" data-bs-target="#content-land"
                        type="button" role="tab" aria-controls="content-land" aria-selected="false">
                        Land
                    </button>

                </div>

                <!-- Tab Content -->
                <div class="tab-content carousel-tab-content shadow-sm rounded-3">

                    <!-- BUY -->
                    <div class="tab-pane fade show active p-3" id="content-buy" role="tabpanel" aria-labelledby="btn-buy">
                        <form action="{{ route('properties.search') }}" autocomplete="off">
                            <div class="row g-3 align-items-center justify-content-center">

                                <!-- Location -->
                                <div class="col-lg-3 col-md-6 col-sm-12">
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

                     
                                <div class="col-lg-3 col-md-6 col-sm-12">

                                    <select class="form-select" id="type" name="type" style="font-size: 0.9rem;"
                                        required>
                                        <option value="" selected>Select Property Type</option>
                                        <option value="1">Residential</option>
                                        <option value="2">Commercial</option>
                                    </select>
                                </div>

                                <div class="col-lg-2 col-md-6 col-sm-12">
                                    <select class="form-select" id="sub_type" name="sub_type" style="font-size: 0.9rem;"
                                        required>
                                        <option value="">Select Sub Type</option>
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
                                        <option value="0">Select Location</option>
                                        @foreach ($location as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-12">

                                    <select class="form-select" id="type" name="type" style="font-size: 0.9rem;"
                                        required>
                                        <option value="" selected>Select Property Type</option>
                                        <option value="1">Residential</option>
                                        <option value="2">Commercial</option>
                                    </select>
                                </div>

                                <div class="col-lg-2 col-md-6 col-sm-12">
                                    <select class="form-select" id="sub_type" name="sub_type" style="font-size: 0.9rem;"
                                        required>
                                        <option value="">Select Sub Type</option>
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
                    <div class="tab-pane fade p-3 text-center " id="content-land" role="tabpanel"
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

    </div>

    <style>
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
    </style>

    <!-- Properties For New -->
    <section class="py-5" style="background-color: #f8f5ee;">
        <div class="container">
            <div class="text-end mb-5">
                <div class="text-center flex-grow-1">
                    <h2 class="fw-bold text-uppercase mb-1" style="font-size: 45px;">New Properties</h2>
                    <p class="text-muted mb-0">Find newly listed properties in your local area with best pricing.</p>
                </div>
                <a href="" class="text-decoration-none small text-secondary">View all &rarr;</a>
            </div>

            @php
                /**
                 * $type = 0: 'sell', 1: 'rent'
                 */
                $allproperties = getPropertiesByType([1, 2]);
                $chunks = $allproperties->chunk(3);
            @endphp


            @if ($allproperties->isNotEmpty())
                <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">

                        @foreach ($chunks as $chunkIndex => $chunk)
                            <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    @foreach ($chunk as $property)
                                        <div class="col">
                                            <a href="{{ route('property.detail', $property->slug) }}"
                                                class="text-decoration-none text-dark">

                                                <div class="card property-card h-100 border-1 shadow-sm rounded-3">
                                                    <div class="position-relative">
                                                        <img src="{{ asset('storage/app/propertyImage/' . ($property->single_image->filename ?? 'devotion-trusted-real-estate.png')) }}"
                                                            class="card-img-top rounded-top-3"
                                                            alt="{{ $property->name }}">

                                                        <span
                                                            class="badge badge-new position-absolute top-0 start-0 m-2">New</span>
                                                        <span
                                                            class="badge {{ $property->purpose == 1 ? 'badge-rent' : 'badge-sale' }} position-absolute top-0 end-0 m-2">
                                                            {{ $property->purpose == 1 ? 'For Rent' : 'For sale' }}
                                                        </span>

                                                    </div>

                                                    <div class="card-body">

                                                        <div class="d-flex align-items-start mb-2">
                                                            <h5 class="card-title mb-0 me-3">
                                                                {{ $property->name }}
                                                            </h5>
                                                        </div>

                                                        <p class="card-text small text-muted mb-1">
                                                            <i class="bi bi-map me-2"></i>
                                                            {{ ucfirst($property->location->name ?? 'N/A') }}
                                                        </p>
                                                        <p class="card-text small mb-4">
                                                            <i class="bi bi-door-closed me-2"></i>Beds:
                                                            {{ $property->beds }}
                                                            |
                                                            <i class="bi bi-bucket me-2"></i>Baths: {{ $property->baths }}
                                                        </p>
                                                        <p class="card-text small">
                                                            <i class="bi bi-rulers me-2"></i>Area:
                                                            {{ $property->area }} Sq.Ft.
                                                        </p>

                                                        <button class="btn btn-type rounded-pill btn-sm featureMap">
                                                            {{ $property->subType->name ?? '' }}
                                                        </button>

                                                    </div>

                                                    <hr class="property-divider">

                                                    <div
                                                        class="card-footer bg-white border-top-0 d-flex mb-2 justify-content-between align-items-center">
                                                        <p class="fs-5  property-price mb-0">
                                                            AED {{ number_format($property->price, 2) }}</p>
                                                        <div class="text-end">
                                                            <img src="{{ asset('public/frontend/assets/images/Devotion Real Estate.png') }}"
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
                <a href="" class="text-decoration-none small text-secondary">View all &rarr;</a>
            </div>

            @php
                $saleProperties = getPropertiesByType([1]);
                $saleChunks = $saleProperties->chunk(3);
            @endphp


            @if ($saleProperties->isNotEmpty())
                <div id="salePropertyCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">

                        @foreach ($saleChunks as $chunkIndex => $chunk)
                            <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    @foreach ($chunk as $propertysale)
                                        <div class="col">

                                            <a href="{{ route('property.detail', $propertysale->slug) }}"
                                                class="text-decoration-none text-dark">
                                                <div class="card property-card h-100 border-1 shadow-sm rounded-3">
                                                    <div class="position-relative">
                                                        <img src="{{ asset('storage/app/propertyImage/' . ($propertysale->single_image->filename ?? 'devotion-trusted-real-estate.png')) }}"
                                                            class="card-img-top rounded-top-3"
                                                            alt="{{ $propertysale->title }}">

                                                        <span
                                                            class="badge badge-new position-absolute top-0 start-0 m-2">New</span>
                                                        <span
                                                            class="badge {{ $propertysale->purpose == 1 ? 'badge-rent' : 'badge-sell' }} position-absolute top-0 end-0 m-2">
                                                            {{ $propertysale->purpose == 1 ? 'For sale' : 'For Rent' }}
                                                        </span>

                                                    </div>

                                                    <div class="card-body">

                                                        <div class="d-flex align-items-start mb-2">
                                                            <h5 class="card-title mb-0 me-3">
                                                                {{ $propertysale->name }}
                                                            </h5>

                                                        </div>

                                                        <p class="card-text small text-muted mb-1">
                                                            <i class="bi bi-map me-2"></i>
                                                            {{ ucfirst($propertysale->location->name ?? 'N/A') }}
                                                        </p>
                                                        <p class="card-text small mb-4">
                                                            <i class="bi bi-door-closed me-2"></i>Beds:
                                                            {{ $propertysale->beds }}
                                                            |
                                                            <i class="bi bi-bucket me-2"></i>Baths:
                                                            {{ $propertysale->baths }}
                                                        </p>
                                                        <p class="card-text small">
                                                            <i class="bi bi-rulers me-2"></i>Area:
                                                            {{ $propertysale->area }} Sq.Ft.
                                                        </p>

                                                        <button class="btn btn-type rounded-pill btn-sm featureMap">
                                                            {{ ucfirst($propertysale->feature->name ?? 'N/A') }}
                                                        </button>
                                                    </div>

                                                    <hr class="property-divider">

                                                    <div
                                                        class="card-footer bg-white border-top-0 d-flex mb-2 justify-content-between align-items-center">
                                                        <p class="fs-5  property-price mb-0">
                                                            AED {{ number_format($propertysale->price, 2) }}</p>
                                                        <div class="text-end">
                                                            <img src="{{ asset('public/frontend/assets/images/Devotion Real Estate.png') }}"
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

    <!-- List Your Property -->
    <section class="py-5 list-property-section">
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
                            <h4 class="card-title fw-semibold">Sell Residential</h4>
                            <p class="card-text property-text">
                                We will connect you to thousands of people who need to buy a home.
                            </p>
                        </div>
                        <a href="login" class="btn property-btn">
                            <i class="bi bi-house-door-fill me-2"></i>Sell Residential
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
                            <h4 class="card-title fw-semibold">Rent Residential</h4>
                            <p class="card-text property-text">
                                Tell us your needs, we will give you thousands of suggestions for the dream home.
                            </p>
                        </div>
                        <a href="login" class="btn property-btn">
                            <i class="bi bi-house-door-fill me-2"></i>Rent Residential
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
                            <h4 class="card-title fw-semibold">Sell Commercial</h4>
                            <p class="card-text property-text">
                                We will connect you to thousands of people who need to buy an office.
                            </p>
                        </div>
                        <a href="login" class="btn property-btn">
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
                            <h4 class="card-title fw-semibold">Rent Commercial</h4>
                            <p class="card-text property-text">
                                Tell us your needs, we will give you thousands of suggestions for the dream office.
                            </p>
                        </div>
                        <a href="login" class="btn property-btn">
                            <i class="bi bi-shop me-2"></i>Rent Commercial
                        </a>
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

                <!-- Blog Card 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-50">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf"
                                class="card-img-top rounded-3" alt="Rental Property Management in UAE">
                            <div
                                class="position-absolute bottom-0 start-50 translate-middle-x mb-3 bg-white rounded-pill px-3 py-1 small shadow-sm d-flex align-items-center">
                                <span class="me-2">December</span>
                                <i class="bi bi-folder2-open me-1"></i>
                                <span>Real Estate</span>
                            </div>

                        </div>
                        <div class="card-body">
                            <h6 class="mt-2 fw-semibold">Rental Property Management in UAE</h6>
                            <a href="" class="text-decoration-none fw-semibold small" style="color: #aa8038;">
                                Read more <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Blog Card 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-50">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85"
                                class="card-img-top rounded-3" alt="Role of Real Estate Broker">
                            <div
                                class="position-absolute bottom-0 start-50 translate-middle-x mb-3 bg-white rounded-pill px-3 py-1 small shadow-sm d-flex align-items-center">
                                <span class="me-2">December</span>
                                <i class="bi bi-folder2-open me-1"></i>
                                <span>Real Estate</span>
                            </div>

                        </div>
                        <div class="card-body">
                            <h6 class="mt-2 fw-semibold">The Indispensable Role of a Real Estate Broker</h6>
                            <a href="#" class="text-decoration-none fw-semibold small" style="color: #aa8038;">
                                Read more <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Blog Card 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-50">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1494526585095-c41746248156"
                                class="card-img-top rounded-3" alt="Best Real Estate Agent in Dubai">
                            <div
                                class="position-absolute bottom-0 start-50 translate-middle-x mb-3 bg-white rounded-pill px-3 py-1 small shadow-sm d-flex align-items-center">
                                <span class="me-2">December</span>
                                <i class="bi bi-folder2-open me-1"></i>
                                <span>Real Estate</span>
                            </div>

                        </div>
                        <div class="card-body">
                            <h6 class="mt-2 fw-semibold">How to Find the Best Real Estate Agent in Dubai: A Comprehensive
                                Guide</h6>
                            <a href="#" class="text-decoration-none fw-semibold small" style="color: #aa8038;">
                                Read more <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>
                </div>

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
        <!-- jQuery -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    </script>

@endsection
