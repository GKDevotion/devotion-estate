@extends('layouts.app')

@section('title', 'Buy Properties')


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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

        <link href="{{ asset('public\frontend\css\custom.css') }}" rel="stylesheet">
    </head>

    <div class="container my-5">
        <!-- Filters and Search Section -->
        <div class="row g-2 justify-content-center mb-4" style="padding-top: 100px">

            <!-- Location Input -->
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-geo-alt"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Enter Location"
                        aria-label="Location">
                </div>

            </div>

            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="dropdown property-type-dropdown">
                    <button class="btn btn-outline w-100 border bg-white d-flex justify-content-between align-items-center"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        Residential
                        <i class="bi bi-chevron-up"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end p-3 shadow border-0" style="min-width: 300px;">
                        <div class="container-fluid p-0">

                            <ul class="nav nav-pills nav-justified mb-3 custom-nav-links" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-residential-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-residential" type="button" role="tab"
                                        aria-controls="pills-residential" aria-selected="true">Residential</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-commercial-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-commercial" type="button" role="tab"
                                        aria-controls="pills-commercial" aria-selected="false">Commercial</button>
                                </li>
                            </ul>
                            <hr class="mt-0 mb-3">

                            <div class="tab-content" id="pills-tabContent">

                                <div class="tab-pane fade show active" id="pills-residential" role="tabpanel"
                                    aria-labelledby="pills-residential-tab">
                                    <div class="row g-2">
                                        <div class="col-6"><button class="btn btn-outline-custom w-100 py-2">Villa</button>
                                        </div>
                                        <div class="col-6"><button
                                                class="btn btn-outline-custom w-100 py-2">Apartment</button></div>
                                        <div class="col-6"><button
                                                class="btn btn-outline-custom w-100 py-2">Townhouse</button></div>
                                        <div class="col-6"><button class="btn btn-outline-custom w-100 py-2">Residential
                                                Plot</button></div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pills-commercial" role="tabpanel"
                                    aria-labelledby="pills-commercial-tab">
                                    <div class="row g-2">
                                        <div class="col-6"><button
                                                class="btn btn-outline-custom w-100 py-2">Office</button></div>
                                        <div class="col-6"><button
                                                class="btn btn-outline-custom w-100 py-2">Retail</button></div>

                                    </div>
                                </div>

                            </div>

                            <hr class="my-3">

                            <div class="row g-2">
                                <div class="col-6">
                                    <button class="btn btn-custom-filled w-100 py-2">Reset</button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-light border w-100 py-2">Done</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Beds/Baths Dropdown -->
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="dropdown">
                    <button class="btn btn-outline w-100 border bg-white d-flex justify-content-between align-items-center"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Beds/Baths
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu p-3" style="min-width: 250px;">
                        <div class="row g-2">
                            <div class="col-6">
                                <label for="minPrice" class="form-label small text-muted mb-1">Bed Room(s)</label>
                                <input type="number" class="form-control" id="minPrice" value="0"
                                    placeholder="0">
                            </div>

                            <div class="col-6">
                                <label for="maxPrice" class="form-label small text-muted mb-1">Bath Room(s)</label>
                                <input type="text" class="form-control" id="maxPrice" value="0"
                                    placeholder="Any">
                            </div>
                        </div>

                        <hr class="dropdown-divider my-3">

                        <div class="row g-2">
                            <div class="col-6">
                                <button class="btn btn-custom-filled w-100 py-2">Reset</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-light border w-100 py-2">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Price Dropdown (existing) -->
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="dropdown">
                    <button class="btn btn-outline w-100 border bg-white d-flex justify-content-between align-items-center"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Price (AED)
                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <div class="dropdown-menu p-3" style="min-width: 250px;">
                        <div class="row g-2">
                            <div class="col-6">
                                <label for="minPrice" class="form-label small text-muted mb-1">Minimum</label>
                                <input type="number" class="form-control" id="minPrice" value="0"
                                    placeholder="0">
                            </div>

                            <div class="col-6">
                                <label for="maxPrice" class="form-label small text-muted mb-1">Maximum</label>
                                <input type="text" class="form-control" id="maxPrice" value="Any"
                                    placeholder="Any">
                            </div>
                        </div>

                        <hr class="dropdown-divider my-3">

                        <div class="row g-2">
                            <div class="col-6">
                                <button class="btn btn-custom-filled w-100 py-2">Reset</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-light border w-100 py-2">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-auto">

                <button class="btn filter-btn me-2 fw-semibold p-3">
                    Filters <i class="fas fa-sliders-h"></i>
                </button>

                <button class="btn search-btn p-3">
                    Search Now <i class="fas fa-search"></i>
                </button>

            </div>
        </div>


        <div class="row align-items-center mb-3">
            <div class="col-md-8 properties-header">
                <h1 class="properties-title">Properties for Buy in Dubai</h1>
                <p class="properties-count">
                    There are currently <span>{{ $total }}</span> properties.
                </p>
            </div>

            <div class="col-md-4 text-md-end">
                <form method="GET" action="{{ route('buy.properties') }}">
                    <label for="showProps" class="form-label small">Show Property(s) Per Page:</label>
                    <div class="col-12 d-flex justify-content-end">
                        <select name="perPage" id="showProps" class="form-select form-select-sm w-50"
                            onchange="this.form.submit()">
                            <option value="2" {{ $perPage == 2 ? 'selected' : '' }}>2</option>
                            <option value="4" {{ $perPage == 4 ? 'selected' : '' }}>4</option>
                            <option value="6" {{ $perPage == 6 ? 'selected' : '' }}>6</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Property Cards Container -->
        <div class="row">
            @forelse($properties as $p)
                <div class="col-md-12 mb-4">
                    <a href="{{ $p->link ?? '#' }}" class="text-decoration-none text-dark">
                        <div class="card p-3 shadow-sm border-0 h-100">
                            <div class="row g-0">
                                <div class="col-lg-4">
                                    <img src="{{ asset('storage/app/propertyImage/' . ($p->single_image->filename ?? 'devotion-trusted-real-estate.png')) }}"
                                        class="img-fluid rounded-start h-100" alt="Property Image">
                                </div>
                                <div class="col-lg-8">
                                    <div class="card-body">
                                        <div class="row align-items-start">

                                            <div class="col-8">
                                                <h5 class="fw-bold">{{ $p->name }}</h5>
                                                <p class="text-muted mb-1" style="font-size: 0.85rem;">
                                                  <i class="bi bi-map me-1"></i>
                                                    {{ $p->location->name ?? 'Unknown Location' }}
                                                </p>
                                                <h4 class="fw-bold mt-4 fs-20" style=" color:#aa8038;">
                                                   AED {{ number_format($p->price, 2) }}
                                                </h4>


                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="mb-2">
                                                       <i class="bi bi-door-closed me-1"></i>
                                                        <span class="small">Beds : {{ $p->beds }}</span>
                                                    </div>

                                                    <div class="mb-2">
                                                        <i class="bi bi-bucket me-1"></i>
                                                        <span class="small">Baths : {{ $p->baths }}</span>
                                                    </div>


                                                    <div class="mb-2">
                                                        <i class="bi bi-rulers me-1"></i>
                                                        <span class="small">Area : {{ $p->area }} Sq.Ft.</span>
                                                    </div>

                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-sm"
                                                            style="background-color: #aa8038; color: white;">
                                                            <i class="bi bi-compass"></i>
                                                        </button>
                                                        <button class="btn btn-sm"
                                                            style="background-color: #aa8038; color: white;">
                                                            <i class="bi bi-heart"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 text-end">
                                                <img src="{{ asset('public/frontend/assets/images/Devotion Real Estate.png') }}"
                                                    alt="Estate Agent Logo" class="img-fluid" style="max-width: 160px;">
                                                <p class="small text-muted text-end mt-2 mb-0">Devotion Estate Agent</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No properties found.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $properties->appends(['perPage' => $perPage])->links('pagination::bootstrap-5') }}
        </div>
        
    </div>
@endsection