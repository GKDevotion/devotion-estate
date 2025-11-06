@extends('layouts.app')

@section('title', 'Rent Properties')

@section('content')

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

        <link href="{{ asset('public\frontend\css\custom.css') }}" rel="stylesheet">
    </head>


    <div class="container my-5">
        {{-- <!-- Filters and Search Section -->
        <form action="{{ route('properties.search') }}" method="GET" id="propertySearchForm">

            <!-- Hidden input for property type -->
            <input type="hidden" name="type" id="propertyTypeInput" value="rent">

            <!-- Filters and Search Section -->
            <div class="row g-2 justify-content-center mb-4" style="padding-top: 100px">

                <!-- Location Dropdown -->
                <div class="col-lg-2 col-md-4 col-sm-6 position-relative">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-geo-alt"></i>
                        </span>
                        <select id="locationInput" name="location_id" class="form-select border-start-1">
                            <option value="">Select Location</option>
                            @forelse($locationObj as $p)
                                <option value="{{ $p->id ?? 'Unknown Location id' }}"
                                    {{ request('location_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->name ?? 'Unknown Location' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Property Type Dropdown -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="dropdown property-type-dropdown">
                        <button
                            class="btn btn-outline w-100 border bg-white d-flex justify-content-between align-items-center"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside"
                            id="propertyTypeButton">
                            <span id="propertyTypeLabel">Select Property Type</span>
                            <i class="bi bi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end p-3 shadow border-0" style="min-width: 300px;">
                            <div class="container-fluid p-0">

                                <!-- Tabs -->
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

                                <!-- Tab Content -->
                                <div class="tab-content" id="pills-tabContent">

                                    <!-- Residential -->
                                    <div class="tab-pane fade show active" id="pills-residential" role="tabpanel"
                                        aria-labelledby="pills-residential-tab">
                                        <div class="row g-2">
                                            @forelse($residentialTypes as $type)
                                                <div class="col-6">
                                                    <button type="button"
                                                        class="btn btn-outline-custom w-100 py-2 property-type-btn"
                                                        name="main_type" name="main_type" data-type="{{ $type->main_type }}"
                                                        data-name="{{ $type->name }}">
                                                        {{ $type->name }}
                                                    </button>
                                                </div>
                                            @empty
                                                <p class="text-muted text-center">No residential types found</p>
                                            @endforelse
                                        </div>
                                    </div>

                                    <!-- Commercial -->
                                    <div class="tab-pane fade" id="pills-commercial" role="tabpanel"
                                        aria-labelledby="pills-commercial-tab">
                                        <div class="row g-2">
                                            @forelse($commercialTypes as $type)
                                                <div class="col-6">
                                                    <button type="button"
                                                        class="btn btn-outline-custom w-100 py-2 property-type-btn"
                                                        name="main_type" name="main_type" data-type="{{ $type->main_type }}"
                                                        data-name="{{ $type->name }}">
                                                        {{ $type->name }}
                                                    </button>
                                                </div>
                                            @empty
                                                <p class="text-muted text-center">No commercial types found</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-3">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-light border w-100 py-2"
                                            id="resetType">Reset</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-light border w-100 py-2"
                                            id="doneType">Done</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Beds/Baths Dropdown -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="dropdown">
                        <button
                            class="btn btn-outline w-100 border bg-white d-flex justify-content-between align-items-center"
                            type="button" id="bedsBathsBtn" data-bs-toggle="dropdown" aria-expanded="false">
                            Beds/Baths
                            <i class="bi bi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu p-3" style="min-width: 250px;">
                            <div class="row g-2">
                                <div class="col-6">
                                    <label for="beds" class="form-label small text-muted mb-1">Bed Room(s)</label>
                                    <input type="number" name="beds" class="form-control" id="beds"
                                        value="0" placeholder="0" min="0">
                                </div>

                                <div class="col-6">
                                    <label for="baths" class="form-label small text-muted mb-1">Bath Room(s)</label>
                                    <input type="number" name="baths" class="form-control" id="baths"
                                        value="0" placeholder="0" min="0">
                                </div>
                            </div>

                            <hr class="dropdown-divider my-3">

                            <div class="row g-2">
                                <div class="col-6">
                                    <button type="button" class="btn btn-light border w-100 py-2"
                                        id="resetBedsBaths">Reset</button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-light border w-100 py-2"
                                        id="doneBedsBaths">Done</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Price Dropdown -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="dropdown">
                        <button
                            class="btn btn-outline w-100 border bg-white d-flex justify-content-between align-items-center"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside"
                            id="priceDropdownBtn">
                            Price (AED)
                            <i class="bi bi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu p-3" style="min-width: 250px;">
                            <div class="row g-2">
                                <div class="col-6">
                                    <label for="minPrice" class="form-label small text-muted mb-1">Minimum</label>
                                    <input type="number" name="min_price" class="form-control" id="minPrice"
                                        value="{{ request('min_price') }}" placeholder="0" min="0">
                                </div>

                                <div class="col-6">
                                    <label for="maxPrice" class="form-label small text-muted mb-1">Maximum</label>
                                    <input type="number" name="max_price" class="form-control" id="maxPrice"
                                        value="{{ request('max_price') }}" placeholder="Any" min="0">
                                </div>
                            </div>

                            <hr class="dropdown-divider my-3">

                            <div class="row g-2">
                                <div class="col-6">
                                    <button type="button" class="btn btn-light border w-100 py-2"
                                        id="resetPrice">Reset</button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-light border w-100 py-2"
                                        id="donePrice">Done</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-auto">
                    <button type="button" class="btn filter-btn me-2 fw-semibold p-3" id="resetAllFilters">
                        Reset Filters <i class="bi bi-x-circle"></i>
                    </button>

                    <button type="submit" class="btn search-btn p-3">
                        Search Now <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

        </form> --}}

   @include('frontend.layouts.partials.property-search', ['type' => 'rent'])

        <!-- Header -->
        <div class="row align-items-center mb-3">
            <div class="col-md-8 properties-header">
                <h1 class="properties-title">Residential Properties for Rent in Dhabi</h1>
                <p class="properties-count">
                    There are currently <span>{{ $total }}</span> properties.
                </p>
            </div>

            <div class="col-md-4 text-md-end">
                <form method="GET" action="{{ route('rent.properties') }}">
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
                    <a href="{{ route('property.detail', ['type' => $p->purpose == 1 ? 'rent' : 'sale', 'slug' => $p->slug]) }}"
                        class="text-decoration-none text-dark">

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
                                                <h5 class="">{{ $p->name }}</h5>
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

        {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedPropertyType = '';
            let selectedPropertyName = '';

            // Property type button click handler
            document.querySelectorAll('.property-type-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all buttons
                    document.querySelectorAll('.property-type-btn').forEach(b => b.classList.remove(
                        'active'));

                    // Add active class to clicked button
                    this.classList.add('active');

                    // Store selected values
                    selectedPropertyType = this.dataset.type;
                    selectedPropertyName = this.dataset.name;

                    // Update hidden input
                    document.getElementById('propertyTypeInput').value = selectedPropertyType;
                });
            });

            // Done button for property type
            document.getElementById('doneType').addEventListener('click', function() {
                if (selectedPropertyName) {
                    document.getElementById('propertyTypeLabel').textContent = selectedPropertyName;
                }
                // Close dropdown
                const dropdown = bootstrap.Dropdown.getInstance(document.querySelector(
                    '.property-type-dropdown button'));
                if (dropdown) dropdown.hide();
            });

            // Reset button for property type
            document.getElementById('resetType').addEventListener('click', function() {
                document.querySelectorAll('.property-type-btn').forEach(b => b.classList.remove('active'));
                document.getElementById('propertyTypeInput').value = '';
                document.getElementById('propertyTypeLabel').textContent = 'Select Property Type';
                selectedPropertyType = '';
                selectedPropertyName = '';
            });

            // Reset button for beds/baths
            document.getElementById('resetBedsBaths').addEventListener('click', function() {
                document.getElementById('beds').value = '0';
                document.getElementById('baths').value = '0';
            });

            // Done button for beds/baths
            document.getElementById('doneBedsBaths').addEventListener('click', function() {
                const dropdown = bootstrap.Dropdown.getInstance(this.closest('.dropdown').querySelector(
                    'button'));
                if (dropdown) dropdown.hide();
            });

            // Reset button for price
            document.getElementById('resetPrice').addEventListener('click', function() {
                document.getElementById('minPrice').value = '';
                document.getElementById('maxPrice').value = '';
            });

            // Done button for price
            document.getElementById('donePrice').addEventListener('click', function() {
                const dropdown = bootstrap.Dropdown.getInstance(this.closest('.dropdown').querySelector(
                    'button'));
                if (dropdown) dropdown.hide();
            });

            // Reset all filters
            document.getElementById('resetAllFilters').addEventListener('click', function() {
                // Reset property type
                document.querySelectorAll('.property-type-btn').forEach(b => b.classList.remove('active'));
                document.getElementById('propertyTypeInput').value = '';
                document.getElementById('propertyTypeLabel').textContent = 'Select Property Type';

                // Reset location
                document.getElementById('locationInput').value = '';

                // Reset beds/baths
                document.getElementById('beds').value = '0';
                document.getElementById('baths').value = '0';

                // Reset price
                document.getElementById('minPrice').value = '';
                document.getElementById('maxPrice').value = '';

                // Reset stored values
                selectedPropertyType = '';
                selectedPropertyName = '';
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            let selectedType = '';
            let selectedName = '';

            // Property type button click
            document.querySelectorAll('.property-type-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Highlight selected
                    document.querySelectorAll('.property-type-btn').forEach(b => b.classList.remove(
                        'active'));
                    this.classList.add('active');

                    // Store selected
                    selectedType = this.dataset.type;
                    selectedName = this.dataset.name;
                });
            });

            // Done button click
            document.getElementById('doneType').addEventListener('click', function() {
                if (selectedName) {
                    document.getElementById('propertyTypeLabel').innerText = selectedName;
                    // Close dropdown manually
                    let dropdown = bootstrap.Dropdown.getInstance(document.getElementById(
                        'propertyTypeButton'));
                    dropdown.hide();
                }
            });

            // Reset button click
            document.getElementById('resetType').addEventListener('click', function() {
                selectedType = '';
                selectedName = '';
                document.getElementById('propertyTypeLabel').innerText = 'Select Property Type';
                document.querySelectorAll('.property-type-btn').forEach(b => b.classList.remove('active'));
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const bedsInput = document.getElementById('beds');
            const bathsInput = document.getElementById('baths');
            const doneBtn = document.getElementById('doneBedsBaths');
            const resetBtn = document.getElementById('resetBedsBaths');
            const dropdownBtn = document.getElementById('bedsBathsBtn');

            // Done button click: update button text
            doneBtn.addEventListener('click', function() {
                const beds = parseInt(bedsInput.value) || 0;
                const baths = parseInt(bathsInput.value) || 0;
                let text = '';
                if (beds > 0 || baths > 0) {
                    text = `${beds} Bed${beds !== 1 ? 's' : ''} / ${baths} Bath${baths !== 1 ? 's' : ''}`;
                } else {
                    text = 'Beds/Baths';
                }
                dropdownBtn.innerHTML = `${text} <i class="bi bi-chevron-down"></i>`;
                // close dropdown manually
                const dropdown = bootstrap.Dropdown.getInstance(dropdownBtn);
                dropdown.hide();
            });

            // Reset button click: reset inputs and button text
            resetBtn.addEventListener('click', function() {
                bedsInput.value = 0;
                bathsInput.value = 0;
                dropdownBtn.innerHTML = `Beds/Baths <i class="bi bi-chevron-down"></i>`;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const priceBtn = document.getElementById('priceDropdownBtn');
            const minPriceInput = document.getElementById('minPrice');
            const maxPriceInput = document.getElementById('maxPrice');
            const doneBtn = document.getElementById('donePrice');
            const resetBtn = document.getElementById('resetPrice');

            // Done button click
            doneBtn.addEventListener('click', function() {
                const min = minPriceInput.value;
                const max = maxPriceInput.value;

                let displayText = 'Price (AED)';
                if (min && max) {
                    displayText = `AED ${min} - AED ${max}`;
                } else if (min) {
                    displayText = `From AED ${min}`;
                } else if (max) {
                    displayText = `Up to AED ${max}`;
                }

                priceBtn.innerHTML = `${displayText} <i class="bi bi-chevron-down"></i>`;
            });

            // Reset button click
            resetBtn.addEventListener('click', function() {
                minPriceInput.value = '';
                maxPriceInput.value = '';
                priceBtn.innerHTML = 'Price (AED) <i class="bi bi-chevron-down"></i>';
            });
        });
    </script> --}}
@endsection
