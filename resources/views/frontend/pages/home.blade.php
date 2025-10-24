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

        <link href="{{ asset('public\frontend\css\custom.css') }}" rel="stylesheet">
    </head>

    <!-- Hero Carousel -->
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner">

            <!-- Carousel Item 1 -->
            <div class="carousel-item active">
                <img src="public\frontend\assets\images\img\slide3.jpg" class="d-block w-100" alt="Building 1">

                <div class="carousel-caption d-flex align-items-center justify-content-center h-100">
                    <div class="carousel-content text-center p-4 rounded-3">

                        <h1 class="carousel-title mb-2">Find your dream home</h1>
                        <h1 class="carousel-title mb-4">with Us</h1>
                        <p class="carousel-subtitle mb-4">
                            Affordable options, easy financing, expert advice every step of the way
                        </p>

                        <!-- Tabs -->
                        <ul class="nav nav-tabs justify-content-center border-0 carousel-tabs">
                            <li class="nav-item">
                                <button class="nav-link active tab-search" id="tab-search" data-bs-toggle="tab"
                                    data-bs-target="#content-search" type="button" role="tab"
                                    aria-controls="content-search" aria-selected="true">
                                    Property Search <i class="bi bi-search"></i>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link tab-project" id="tab-project" data-bs-toggle="tab"
                                    data-bs-target="#content-project" type="button" role="tab"
                                    aria-controls="content-project" aria-selected="false">
                                    New Project <i class="bi bi-house"></i>
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content carousel-tab-content shadow-sm rounded-3">

                            <!-- Property Search -->
                            <div class="tab-pane fade show active p-2" id="content-search" role="tabpanel"
                                aria-labelledby="tab-search">
                                <div class="input-group mb-3 input-group-search rounded gap-3 justify-content-center">
                                    <input type="text" class="form-control search-input" placeholder="Enter Location">
                                    <select class="form-select search-select">
                                        <option selected>All</option>
                                        <option>Rent</option>
                                        <option>Buy</option>
                                    </select>
                                    <select class="form-select search-select">
                                        <option selected>Residential</option>
                                        <option>Commercial</option>
                                    </select>
                                    <select class="form-select search-select">
                                        <option selected>Bed/Bath</option>
                                        <option>1 BHK</option>
                                        <option>2 BHK</option>
                                    </select>
                                </div>
                                <button class="btn search-btn">Search Now <i class="bi bi-search"></i></button>
                            </div>

                            <!-- New Project -->
                            <div class="tab-pane fade p-3 text-center" id="content-project" role="tabpanel"
                                aria-labelledby="tab-project">
                                <div class="input-group mb-3 input-group-project rounded gap-3 justify-content-center">
                                    <input type="text" class="form-control project-input" placeholder="Enter Location">
                                    <select class="form-select project-select">
                                        <option selected>Residential</option>
                                        <option>Commercial</option>
                                    </select>
                                    <select class="form-select project-select">
                                        <option selected>Handover By</option>
                                        <option>Q2 2024</option>
                                        <option>Q3 2024</option>
                                        <option>Q4 2024</option>
                                        <option>Q1 2025</option>
                                        <option>Q2 2025</option>
                                        <option>Q3 2025</option>
                                        <option>Q4 2025</option>
                                        <option>2026</option>
                                        <option>2027</option>
                                        <option>2028</option>
                                        <option>2029</option>
                                        <option>2030</option>
                                    </select>
                                    <select class="form-select project-select">
                                        <option selected>(%) Completion</option>
                                        <option>0 - 25 %</option>
                                        <option>25 - 50 %</option>
                                        <option>50 - 75 %</option>
                                        <option>75 - 100 %</option>
                                        <option>Any</option>
                                    </select>
                                    <select class="form-select project-select">
                                        <option selected>Up to 100% pre-handover</option>
                                    </select>
                                </div>
                                <button class="btn search-btn">Search Now <i class="bi bi-search"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Carousel Item 2 -->
            <div class="carousel-item">
                <img src="public\frontend\assets\images\img\slide1.jpg" class="d-block w-100" alt="Building 1">

                <div class="carousel-caption d-flex align-items-center justify-content-center h-100">
                    <div class="carousel-content text-center p-4 rounded-3">

                        <h1 class="carousel-title mb-2">Find your perfect</h1>
                        <h1 class="carousel-title mb-4">home</h1>

                        <!-- Tabs -->
                        <ul class="nav nav-tabs justify-content-center border-0 carousel-tabs">
                            <li class="nav-item">
                                <button class="nav-link active tab-search" id="tab-search-1" data-bs-toggle="tab"
                                    data-bs-target="#content-search-1" type="button" role="tab"
                                    aria-controls="content-search-1" aria-selected="true">
                                    Property Search <i class="bi bi-search"></i>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link tab-project" id="tab-project-1" data-bs-toggle="tab"
                                    data-bs-target="#content-project-1" type="button" role="tab"
                                    aria-controls="content-project-1" aria-selected="false">
                                    New Project <i class="bi bi-house"></i>
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content carousel-tab-content shadow-sm rounded-3">

                            <!-- Property Search -->
                            <div class="tab-pane fade show active p-2" id="content-search-1" role="tabpanel"
                                aria-labelledby="tab-search-1">
                                <div class="input-group mb-3 input-group-search rounded gap-3 justify-content-center">
                                    <input type="text" class="form-control search-input" placeholder="Enter Location">
                                    <select class="form-select search-select">
                                        <option selected>All</option>
                                        <option>Rent</option>
                                        <option>Buy</option>
                                    </select>
                                    <select class="form-select search-select">
                                        <option selected>Residential</option>
                                        <option>Commercial</option>
                                    </select>
                                    <select class="form-select search-select">
                                        <option selected>Bed/Bath</option>
                                        <option>1 BHK</option>
                                        <option>2 BHK</option>
                                    </select>
                                </div>
                                <button class="btn search-btn">Search Now <i class="bi bi-search"></i></button>
                            </div>

                            <!-- New Project -->
                            <div class="tab-pane fade p-3 text-center" id="content-project-1" role="tabpanel"
                                aria-labelledby="tab-project-1">
                                <div class="input-group mb-3 input-group-project rounded gap-3 justify-content-center">
                                    <input type="text" class="form-control project-input"
                                        placeholder="Enter Location">
                                    <select class="form-select project-select">
                                        <option selected>Residential</option>
                                        <option>Commercial</option>
                                    </select>
                                    <select class="form-select project-select">
                                        <option selected>Handover By</option>
                                        <option>Q2 2024</option>
                                        <option>Q3 2024</option>
                                        <option>Q4 2024</option>
                                        <option>Q1 2025</option>
                                        <option>Q2 2025</option>
                                        <option>Q3 2025</option>
                                        <option>Q4 2025</option>
                                        <option>2026</option>
                                        <option>2027</option>
                                        <option>2028</option>
                                        <option>2029</option>
                                        <option>2030</option>
                                    </select>
                                    <select class="form-select project-select">
                                        <option selected>(%) Completion</option>
                                        <option>0 - 25 %</option>
                                        <option>25 - 50 %</option>
                                        <option>50 - 75 %</option>
                                        <option>75 - 100 %</option>
                                        <option>Any</option>
                                    </select>
                                    <select class="form-select project-select">
                                        <option selected>Up to 100% pre-handover</option>
                                    </select>
                                </div>
                                <button class="btn search-btn">Search Now <i class="bi bi-search"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <!-- Carousel Item 3 -->
            <div class="carousel-item">
                <img src="public\frontend\assets\images\img\slide2.jpg" class="d-block w-100" alt="Building 1">

                <div class="carousel-caption d-flex align-items-center justify-content-center h-100">
                    <div class="carousel-content text-center p-4 rounded-3">

                        <h1 class="carousel-title mb-4">Start your journey</h1>

                        <!-- Tabs -->
                        <ul class="nav nav-tabs justify-content-center border-0 carousel-tabs">
                            <li class="nav-item">
                                <button class="nav-link active tab-search" id="tab-search-2" data-bs-toggle="tab"
                                    data-bs-target="#content-search-2" type="button" role="tab"
                                    aria-controls="content-search-2" aria-selected="true">
                                    Property Search <i class="bi bi-search"></i>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link tab-project" id="tab-project-2" data-bs-toggle="tab"
                                    data-bs-target="#content-project-2" type="button" role="tab"
                                    aria-controls="content-project-2" aria-selected="false">
                                    New Project <i class="bi bi-house"></i>
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content carousel-tab-content shadow-sm rounded-3">

                            <!-- Property Search -->
                            <div class="tab-pane fade show active p-2" id="content-search-2" role="tabpanel"
                                aria-labelledby="tab-search-2">
                                <div class="input-group mb-3 input-group-search rounded gap-3 justify-content-center">
                                    <input type="text" class="form-control search-input" placeholder="Enter Location">
                                    <select class="form-select search-select">
                                        <option selected>All</option>
                                        <option>Rent</option>
                                        <option>Buy</option>
                                    </select>
                                    <select class="form-select search-select">
                                        <option selected>Residential</option>
                                        <option>Commercial</option>
                                    </select>
                                    <select class="form-select search-select">
                                        <option selected>Bed/Bath</option>
                                        <option>1 BHK</option>
                                        <option>2 BHK</option>
                                    </select>
                                </div>
                                <button class="btn search-btn">Search Now <i class="bi bi-search"></i></button>
                            </div>

                            <!-- New Project -->
                            <div class="tab-pane fade p-3 text-center" id="content-project-2" role="tabpanel"
                                aria-labelledby="tab-project-2">
                                <div class="input-group mb-3 input-group-project rounded gap-3 justify-content-center">
                                    <input type="text" class="form-control project-input"
                                        placeholder="Enter Location">
                                    <select class="form-select project-select">
                                        <option selected>Residential</option>
                                        <option>Commercial</option>
                                    </select>
                                    <select class="form-select project-select">
                                        <option selected>Handover By</option>
                                        <option>Q2 2024</option>
                                        <option>Q3 2024</option>
                                        <option>Q4 2024</option>
                                        <option>Q1 2025</option>
                                        <option>Q2 2025</option>
                                        <option>Q3 2025</option>
                                        <option>Q4 2025</option>
                                        <option>2026</option>
                                        <option>2027</option>
                                        <option>2028</option>
                                        <option>2029</option>
                                        <option>2030</option>
                                    </select>
                                    <select class="form-select project-select">
                                        <option selected>(%) Completion</option>
                                        <option>0 - 25 %</option>
                                        <option>25 - 50 %</option>
                                        <option>50 - 75 %</option>
                                        <option>75 - 100 %</option>
                                        <option>Any</option>
                                    </select>
                                    <select class="form-select project-select">
                                        <option selected>Up to 100% pre-handover</option>
                                    </select>
                                </div>
                                <button class="btn search-btn">Search Now <i class="bi bi-search"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>

    <section class="py-5" style="background-color: #f8f5ee;">
        <div class="container">
            <div class="text-end mb-5">
                <div class="text-center flex-grow-1">
                    <h2 class="fw-bold text-uppercase mb-1" style=" font-size: 45px;">New Properties</h2>
                    <p class="text-muted mb-0">Find newly listed properties in your local area with best pricing.</p>
                </div>
                <a href="#" class="text-decoration-none small text-secondary">View all &rarr;</a>
            </div>

            <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-inner">

                    <div class="carousel-item active">

                        <div class="row row-cols-1 row-cols-md-3 g-4">

                            <div class="col">
                                <div class="card property-card h-100 border-1 shadow-sm rounded-3">
                                    <div class="position-relative">
                                        <img src="public\frontend\assets\images\img\property1.jpg"
                                            class="card-img-top rounded-top-3" alt="Townhouse">
                                        <span class="badge badge-new position-absolute top-0 start-0 m-2">New</span>
                                        <span class="badge badge-sell position-absolute top-0 end-0 m-2">For Sell</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="card-title text-truncate mb-0">Ultra Luxury &...</h5>
                                            <button class="btn btn-type rounded-pill btn-sm">Townhouse</button>
                                        </div>

                                        <p class="card-text small text-muted mb-1"><i class="bi bi-map me-2"></i>Jumeirah
                                            Village Circle,
                                            Dubai...</p>
                                        <p class="card-text small mb-4"><i class="bi bi-door-closed me-2"></i>Beds: 4 | <i
                                                class="bi bi-bucket me-2"></i>Baths: 5</p>
                                        <p class="card-text small"><i class="bi bi-rulers me-2"></i>Area: 3203.00 Sq.Ft.
                                        </p>

                                        <button class="btn btn-sm btn-icon me-2"><i class="bi bi-compass"></i></button>
                                        <button class="btn btn-sm btn-icon"><i class="bi bi-heart"></i></button>
                                    </div>

                                    <hr class="property-divider">

                                    <div
                                        class="card-footer bg-white border-top-0 d-flex mb-2 justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <p class="small fw-bold property-price mb-0">₹83,722,383.66</p>
                                        </div>
                                        <div class="text-end">
                                            <img src="public\frontend\assets\images\Devotion Real Estate.png"
                                                alt="Logo" class="property-logo img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col">
                                <div class="card property-card h-100 border-1 shadow-sm rounded-3">
                                    <div class="position-relative">
                                        <img src="public\frontend\assets\images\img\property2.jpg"
                                            class="card-img-top rounded-top-3" alt="Apartment">
                                        <span class="badge badge-new position-absolute top-0 start-0 m-2">New</span>
                                        <span class="badge badge-rent position-absolute top-0 end-0 m-2">For Rent</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="card-title text-truncate mb-0">Modern 2-Bed Flat</h5>
                                            <button class="btn btn-type rounded-pill btn-sm">Apartment</button>
                                        </div>

                                        <p class="card-text small text-muted mb-1"><i class="bi bi-map me-2"></i>Downtown,
                                            New York City...
                                        </p>
                                        <p class="card-text small mb-4"><i class="bi bi-door-closed me-2"></i>Beds: 2 | <i
                                                class="bi bi-bucket me-2"></i>Baths: 2</p>
                                        <p class="card-text small"><i class="bi bi-rulers me-2"></i>Area: 1100.00 Sq.Ft.
                                        </p>

                                        <button class="btn btn-sm btn-icon me-2"><i class="bi bi-compass"></i></button>
                                        <button class="btn btn-sm btn-icon"><i class="bi bi-heart"></i></button>
                                    </div>

                                    <hr class="property-divider">

                                    <div
                                        class="card-footer bg-white border-top-0 d-flex mb-2 justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <p class="small fw-bold property-price mb-0">₹2,50,000 / Month</p>
                                        </div>
                                        <div class="text-end">
                                            <img src="public\frontend\assets\images\Devotion Real Estate.png"
                                                alt="Logo" class="property-logo img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card property-card h-100 border-1 shadow-sm rounded-3">
                                    <div class="position-relative">
                                        <img src="public\frontend\assets\images\img\property3.jpg"
                                            class="card-img-top rounded-top-3" alt="Villa">
                                        <span class="badge badge-new position-absolute top-0 start-0 m-2">New</span>
                                        <span class="badge badge-sell position-absolute top-0 end-0 m-2">For Sell</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="card-title text-truncate mb-0">Luxury Garden Villa</h5>
                                            <button class="btn btn-type rounded-pill btn-sm">Villa</button>
                                        </div>

                                        <p class="card-text small text-muted mb-1"><i class="bi bi-map me-2"></i>Beverly
                                            Hills,
                                            California...</p>
                                        <p class="card-text small mb-4"><i class="bi bi-door-closed me-2"></i>Beds: 6 | <i
                                                class="bi bi-bucket me-2"></i>Baths: 7</p>
                                        <p class="card-text small"><i class="bi bi-rulers me-2"></i>Area: 8500.00 Sq.Ft.
                                        </p>

                                        <button class="btn btn-sm btn-icon me-2"><i class="bi bi-compass"></i></button>
                                        <button class="btn btn-sm btn-icon"><i class="bi bi-heart"></i></button>
                                    </div>

                                    <hr class="property-divider">

                                    <div
                                        class="card-footer bg-white border-top-0 d-flex mb-2 justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <p class="small fw-bold property-price mb-0">₹417,000,000 / Sell</p>
                                        </div>
                                        <div class="text-end">
                                            <img src="public\frontend\assets\images\Devotion Real Estate.png"
                                                alt="Logo" class="property-logo img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="row row-cols-1 row-cols-md-3 g-4">

                            <div class="col">
                                <div class="card property-card h-100 border-1 shadow-sm rounded-3">
                                    <div class="position-relative">
                                        <img src="public\frontend\assets\images\img\property1.jpg"
                                            class="card-img-top rounded-top-3" alt="Apartment">
                                        <span class="badge badge-new position-absolute top-0 start-0 m-2">New</span>
                                        <span class="badge badge-rent position-absolute top-0 end-0 m-2">For Rent</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="card-title text-truncate mb-0">Modern 2-Bed Flat</h5>
                                            <button class="btn btn-type rounded-pill btn-sm">Apartment</button>
                                        </div>

                                        <p class="card-text small text-muted mb-1"><i class="bi bi-map me-2"></i>Downtown,
                                            New York City...
                                        </p>
                                        <p class="card-text small mb-4"><i class="bi bi-door-closed me-2"></i>Beds: 2 | <i
                                                class="bi bi-bucket me-2"></i>Baths: 2</p>
                                        <p class="card-text small"><i class="bi bi-rulers me-2"></i>Area: 1100.00 Sq.Ft.
                                        </p>

                                        <button class="btn btn-sm btn-icon me-2"><i class="bi bi-compass"></i></button>
                                        <button class="btn btn-sm btn-icon"><i class="bi bi-heart"></i></button>
                                    </div>

                                    <hr class="property-divider">

                                    <div
                                        class="card-footer bg-white border-top-0 d-flex mb-2 justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <p class="small fw-bold property-price mb-0">₹2,50,000 / Month</p>
                                        </div>
                                        <div class="text-end">
                                            <img src="public\frontend\assets\images\Devotion Real Estate.png"
                                                alt="Logo" class="property-logo img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col">
                            </div>

                            <div class="col">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="carousel-indicators position-relative mt-4">
                    <button type="button" data-bs-target="#propertyCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#propertyCarousel" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- third section -->
    <section class="py-5" style="background-color: white;">
        <div class="container">
            <div class="text-end mb-5">
                <div class="text-center flex-grow-1">
                    <h2 class="fw-bold text-uppercase mb-1" style=" font-size: 45px;">Properties for sale</h2>
                    <p class="text-muted mb-0">Search properties which are listed as available for sale in your local area
                        with
                        best pricing.</p>
                </div>
                <a href="#" class="text-decoration-none small text-secondary">View all &rarr;</a>
            </div>

            <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-inner">

                    <div class="carousel-item active">

                        <div class="row row-cols-1 row-cols-md-3 g-4">

                            <div class="col">
                                <div class="card property-card h-100 border-1 shadow-sm rounded-3">
                                    <div class="position-relative">
                                        <img src="public\frontend\assets\images\img\property1.jpg"
                                            class="card-img-top rounded-top-3" alt="Townhouse">
                                        <span class="badge badge-new position-absolute top-0 start-0 m-2">New</span>
                                        <span class="badge badge-sell position-absolute top-0 end-0 m-2">For Sell</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="card-title text-truncate mb-0">Ultra Luxury &...</h5>
                                            <button class="btn btn-type rounded-pill btn-sm">Townhouse</button>
                                        </div>

                                        <p class="card-text small text-muted mb-1"><i class="bi bi-map me-2"></i>Jumeirah
                                            Village Circle,
                                            Dubai...</p>
                                        <p class="card-text small mb-4"><i class="bi bi-door-closed me-2"></i>Beds: 4 | <i
                                                class="bi bi-bucket me-2"></i>Baths: 5</p>
                                        <p class="card-text small"><i class="bi bi-rulers me-2"></i>Area: 3203.00 Sq.Ft.
                                        </p>

                                        <button class="btn btn-sm btn-icon me-2"><i class="bi bi-compass"></i></button>
                                        <button class="btn btn-sm btn-icon"><i class="bi bi-heart"></i></button>
                                    </div>

                                    <hr class="property-divider">

                                    <div
                                        class="card-footer bg-white border-top-0 d-flex mb-2 justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <p class="small fw-bold property-price mb-0">₹83,722,383.66</p>
                                        </div>
                                        <div class="text-end">
                                            <img src="public\frontend\assets\images\Devotion Real Estate.png"
                                                alt="Logo" class="property-logo img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card property-card h-100 border-1 shadow-sm rounded-3">
                                    <div class="position-relative">
                                        <img src="public\frontend\assets\images\img\property2.jpg"
                                            class="card-img-top rounded-top-3" alt="Apartment">
                                        <span class="badge badge-new position-absolute top-0 start-0 m-2">New</span>
                                        <span class="badge badge-rent position-absolute top-0 end-0 m-2">For Rent</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="card-title text-truncate mb-0">Modern 2-Bed Flat</h5>
                                            <button class="btn btn-type rounded-pill btn-sm">Apartment</button>
                                        </div>

                                        <p class="card-text small text-muted mb-1"><i class="bi bi-map me-2"></i>Downtown,
                                            New York City...
                                        </p>
                                        <p class="card-text small mb-4"><i class="bi bi-door-closed me-2"></i>Beds: 2 | <i
                                                class="bi bi-bucket me-2"></i>Baths: 2</p>
                                        <p class="card-text small"><i class="bi bi-rulers me-2"></i>Area: 1100.00 Sq.Ft.
                                        </p>

                                        <button class="btn btn-sm btn-icon me-2"><i class="bi bi-compass"></i></button>
                                        <button class="btn btn-sm btn-icon"><i class="bi bi-heart"></i></button>
                                    </div>

                                    <hr class="property-divider">

                                    <div
                                        class="card-footer bg-white border-top-0 d-flex mb-2 justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <p class="small fw-bold property-price mb-0">₹2,50,000 / Month</p>
                                        </div>
                                        <div class="text-end">
                                            <img src="public\frontend\assets\images\Devotion Real Estate.png"
                                                alt="Logo" class="property-logo img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card property-card h-100 border-1 shadow-sm rounded-3">
                                    <div class="position-relative">
                                        <img src="public\frontend\assets\images\img\property3.jpg"
                                            class="card-img-top rounded-top-3" alt="Villa">
                                        <span class="badge badge-new position-absolute top-0 start-0 m-2">New</span>
                                        <span class="badge badge-sell position-absolute top-0 end-0 m-2">For Sell</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="card-title text-truncate mb-0">Luxury Garden Villa</h5>
                                            <button class="btn btn-type rounded-pill btn-sm">Villa</button>
                                        </div>

                                        <p class="card-text small text-muted mb-1"><i class="bi bi-map me-2"></i>Beverly
                                            Hills,
                                            California...</p>
                                        <p class="card-text small mb-4"><i class="bi bi-door-closed me-2"></i>Beds: 6 | <i
                                                class="bi bi-bucket me-2"></i>Baths: 7</p>
                                        <p class="card-text small"><i class="bi bi-rulers me-2"></i>Area: 8500.00 Sq.Ft.
                                        </p>

                                        <button class="btn btn-sm btn-icon me-2"><i class="bi bi-compass"></i></button>
                                        <button class="btn btn-sm btn-icon"><i class="bi bi-heart"></i></button>
                                    </div>

                                    <hr class="property-divider">

                                    <div
                                        class="card-footer bg-white border-top-0 d-flex mb-2 justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <p class="small fw-bold property-price mb-0">₹417,000,000 / Sell</p>
                                        </div>
                                        <div class="text-end">
                                            <img src="public\frontend\assets\images\Devotion Real Estate.png"
                                                alt="Logo" class="property-logo img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="row row-cols-1 row-cols-md-3 g-4">

                            <div class="col">
                                <div class="card property-card h-100 border-1 shadow-sm rounded-3">
                                    <div class="position-relative">
                                        <img src="public\frontend\assets\images\img\property1.jpg"
                                            class="card-img-top rounded-top-3" alt="Apartment">
                                        <span class="badge badge-new position-absolute top-0 start-0 m-2">New</span>
                                        <span class="badge badge-rent position-absolute top-0 end-0 m-2">For Rent</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="card-title text-truncate mb-0">Modern 2-Bed Flat</h5>
                                            <button class="btn btn-type rounded-pill btn-sm">Apartment</button>
                                        </div>

                                        <p class="card-text small text-muted mb-1">
                                            <i class="bi bi-map me-2"></i>Downtown, New York City...
                                        </p>
                                        <p class="card-text small mb-4">
                                            <i class="bi bi-door-closed me-2"></i>Beds: 2 |
                                            <i class="bi bi-bucket me-2"></i>Baths: 2
                                        </p>
                                        <p class="card-text small">
                                            <i class="bi bi-rulers me-2"></i>Area: 1100.00 Sq.Ft.
                                        </p>

                                        <button class="btn btn-sm btn-icon me-2"><i class="bi bi-compass"></i></button>
                                        <button class="btn btn-sm btn-icon"><i class="bi bi-heart"></i></button>
                                    </div>

                                    <hr class="property-divider">

                                    <div
                                        class="card-footer bg-white border-top-0 d-flex mb-2 justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <p class="small fw-bold property-price mb-0">₹2,50,000 / Month</p>
                                        </div>
                                        <div class="text-end">
                                            <img src="public\frontend\assets\images\Devotion Real Estate.png"
                                                alt="Logo" class="property-logo img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                            </div>

                            <div class="col">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="carousel-indicators position-relative mt-4">
                    <button type="button" data-bs-target="#propertyCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#propertyCarousel" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- List Your Property -->
    <section class="py-5 list-property-section">
        <div class="container py-5">
            <h1 class="text-center mb-5 fw-bold section-title" style="      color: #000;
      font-size: 45px;">LIST YOUR PROPERTY</h1>
            <div class="row g-4 justify-content-center">

                <!-- Sell Residential -->
                <div class="col-lg-3 col-md-6 col-sm-10 mx-auto">
                    <div class="card property-card h-100 border-0 shadow-sm text-center">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <img src="public\frontend\assets\images\img\sell-house.png" alt="Sell Residential Icon"
                                    class="property-icon">
                            </div>
                            <h4 class="card-title fw-semibold">Sell Residential</h4>
                            <p class="card-text property-text">
                                We will connect you to thousands of people who need to buy a home.
                            </p>
                        </div>
                        <a href="../devotion/owner-register.html" class="btn property-btn">
                            <i class="bi bi-house-door-fill me-2"></i>Sell Residential
                        </a>
                    </div>
                </div>

                <!-- Rent Residential -->
                <div class="col-lg-3 col-md-6 col-sm-10 mx-auto">
                    <div class="card property-card h-100 border-0 shadow-sm text-center">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <img src="public\frontend\assets\images\img\rent-house.png" alt="Rent Residential Icon"
                                    class="property-icon">
                            </div>
                            <h4 class="card-title fw-semibold">Rent Residential</h4>
                            <p class="card-text property-text">
                                Tell us your needs, we will give you thousands of suggestions for the dream home.
                            </p>
                        </div>
                        <a href="../devotion/owner-register.html" class="btn property-btn">
                            <i class="bi bi-house-door-fill me-2"></i>Rent Residential
                        </a>
                    </div>
                </div>

                <!-- Sell Commercial -->
                <div class="col-lg-3 col-md-6 col-sm-10 mx-auto">
                    <div class="card property-card h-100 border-0 shadow-sm text-center">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <img src="public\frontend\assets\images\img\office-1.png" alt="Sell Commercial Icon"
                                    class="property-icon">
                            </div>
                            <h4 class="card-title fw-semibold">Sell Commercial</h4>
                            <p class="card-text property-text">
                                We will connect you to thousands of people who need to buy an office.
                            </p>
                        </div>
                        <a href="../devotion/owner-register.html" class="btn property-btn">
                            <i class="bi bi-shop me-2"></i>Sell Commercial
                        </a>
                    </div>
                </div>

                <!-- Rent Commercial -->
                <div class="col-lg-3 col-md-6 col-sm-10 mx-auto">
                    <div class="card property-card h-100 border-0 shadow-sm text-center">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <img src="public\frontend\assets\images\img\rent-office.png" alt="Rent Commercial Icon"
                                    class="property-icon">
                            </div>
                            <h4 class="card-title fw-semibold">Rent Commercial</h4>
                            <p class="card-text property-text">
                                Tell us your needs, we will give you thousands of suggestions for the dream office.
                            </p>
                        </div>
                        <a href="../devotion/owner-register.html" class="btn property-btn">
                            <i class="bi bi-shop me-2"></i>Rent Commercial
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>


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




@endsection
