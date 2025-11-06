<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link href="{{ asset('public/frontend/css/custom.css') }}" rel="stylesheet">
    <style>
        .btn-outline-custom.active {
            background-color: #aa8038;
            /* Example: gold highlight */
            color: white;
            border-color: #aa8038;
        }
    </style>
</head>

<form action="{{ route('properties.search') }}" method="GET" id="propertySearchForm">

    <!-- Hidden input for property type -->
    <input type="hidden" name="type" id="propertyTypeInput" value="sale">

    @if (isset($type) && $type === 'rent')
        <input type="hidden" name="type" id="propertyTypeInput" value="rent">
    @endif

    @if (isset($type) && $type === 'off')
        <input type="hidden" name="type" id="propertyTypeInput" value="off">
    @endif

    @if (isset($type) && $type === 'luxury')
        <input type="hidden" name="type" id="propertyTypeInput" value="luxury">
    @endif


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
                <button class="btn btn-outline w-100 border bg-white d-flex justify-content-between align-items-center"
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
                                                name="main_type" data-type="{{ $type->main_type }}"
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
                                                name="main_type" data-type="{{ $type->main_type }}"
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
                <button class="btn btn-outline w-100 border bg-white d-flex justify-content-between align-items-center"
                    type="button" id="bedsBathsBtn" data-bs-toggle="dropdown" aria-expanded="false">
                    Beds/Baths
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="dropdown-menu p-3" style="min-width: 250px;">
                    <div class="row g-2">
                        <div class="col-6">
                            <label for="beds" class="form-label small text-muted mb-1">Bed Room(s)</label>
                            <input type="number" name="beds" class="form-control" id="beds" value="0"
                                placeholder="0" min="0">
                        </div>

                        <div class="col-6">
                            <label for="baths" class="form-label small text-muted mb-1">Bath Room(s)</label>
                            <input type="number" name="baths" class="form-control" id="baths" value="0"
                                placeholder="0" min="0">
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
                <button class="btn btn-outline w-100 border bg-white d-flex justify-content-between align-items-center"
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

            {{-- <button type="button" class="btn filter-btn me-2 fw-semibold p-3" id="toggleFilters">
                <i class="bi bi-funnel"></i> Filters
            </button> --}}

            <button type="submit" class="btn search-btn p-3">
                Search Now <i class="fas fa-search"></i>
            </button>

        </div>

        <!-- Advanced Filter Section (Hidden by Default) -->
        <div id="advancedFilters" class="container mt-4 d-none" style="display: none; ">
            <div class="row align-items-end g-3">

                <!-- Area -->
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="dropdown">
                         <label for="area" class="form-label fw-semibold">Area(s)</label>
                        <button
                            class="btn btn-outline w-100 border bg-white d-flex justify-content-between align-items-center"
                            type="button" id="areaBtn" data-bs-toggle="dropdown" aria-expanded="false">
                            Area (Sq.Ft.)
                            <i class="bi bi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu p-3" style="min-width: 250px;">
                            <div class="row g-2">
                                <div class="col-6">
                                    <label for="min-area" class="form-label small text-muted mb-1">Minimum Sq.Ft.(s)</label>
                                    <input type="number" name="min-area" class="form-control" id="min-area"
                                        value="0" placeholder="0" min="0">
                                </div>

                                <div class="col-6">
                                    <label for="max-area" class="form-label small text-muted mb-1">Maximum Sq.Ft.(s)</label>
                                    <input type="number" name="max-area" class="form-control" id="max-area"
                                        value="0" placeholder="0" min="0">
                                </div>
                            </div>

                            <hr class="dropdown-divider my-3">

                            <div class="row g-2">
                                <div class="col-6">
                                    <button type="button" class="btn btn-light border w-100 py-2"
                                        id="resetarea">Reset</button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-light border w-100 py-2"
                                        id="donearea">Done</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             
                <!-- Furnishing -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <label class="form-label fw-semibold d-block">Furnishing</label>
                    <div class="custom-radio-box d-flex flex-wrap gap-2">
                        <input type="radio" class="btn-check" name="furnish-type" id="furnish-all"
                            autocomplete="off" checked>
                        <label class="btn btn-outline-custom px-3" for="furnish-all">All</label>

                        <input type="radio" class="btn-check" name="furnish-type" id="furnish-furnished"
                            autocomplete="off">
                        <label class="btn btn-outline-custom px-3" for="furnish-furnished">Furnished</label>

                        <input type="radio" class="btn-check" name="furnish-type" id="furnish-unfurnished"
                            autocomplete="off">
                        <label class="btn btn-outline-custom px-3" for="furnish-unfurnished">Unfurnished</label>
                    </div>
                </div>

                <!-- Project Status -->
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <label class="form-label fw-semibold d-block">Project Status</label>
                    <div class="custom-radio-box d-flex flex-wrap gap-2">
                        <input type="radio" class="btn-check" name="project-status" id="status-all"
                            autocomplete="off" checked>
                        <label class="btn btn-outline-custom px-3 " for="status-all">All</label>

                        <input type="radio" class="btn-check" name="project-status" id="status-ready"
                            autocomplete="off">
                        <label class="btn btn-outline-custom px-3 " for="status-ready">Move</label>

                        <input type="radio" class="btn-check" name="project-status" id="status-offplan"
                            autocomplete="off">
                        <label class="btn btn-outline-custom px-3 " for="status-offplan">Off Plan</label>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Additional Features -->
                <div class="row py-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Additional Feature(s)</label>
                    </div>

                    <div class="col-12">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2">
                            <div class="col">
                                <div class="form-check feature-check"><input class="form-check-input" type="checkbox"
                                        id="balcony"><label class="form-check-label" for="balcony">Balcony</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check feature-check"><input class="form-check-input" type="checkbox"
                                        id="emergency"><label class="form-check-label" for="emergency">Emergency
                                        Exit</label></div>
                            </div>
                            <div class="col">
                                <div class="form-check feature-check"><input class="form-check-input" type="checkbox"
                                        id="cctv"><label class="form-check-label" for="cctv">CCTV</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check feature-check"><input class="form-check-input" type="checkbox"
                                        id="wifi"><label class="form-check-label" for="wifi">Free
                                        Wi-Fi</label></div>
                            </div>
                            <div class="col">
                                <div class="form-check feature-check"><input class="form-check-input" type="checkbox"
                                        id="parking"><label class="form-check-label" for="parking">Free Parking In
                                        The Area</label></div>
                            </div>
                            <div class="col">
                                <div class="form-check feature-check"><input class="form-check-input" type="checkbox"
                                        id="air"><label class="form-check-label" for="air">Air
                                        Conditioning</label></div>
                            </div>
                            <div class="col">
                                <div class="form-check feature-check"><input class="form-check-input" type="checkbox"
                                        id="guard"><label class="form-check-label" for="guard">Security
                                        Guard</label></div>
                            </div>
                            <div class="col">
                                <div class="form-check feature-check"><input class="form-check-input" type="checkbox"
                                        id="terrace"><label class="form-check-label" for="terrace">Terrace</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check feature-check"><input class="form-check-input" type="checkbox"
                                        id="laundry"><label class="form-check-label" for="laundry">Laundry
                                        Service</label></div>
                            </div>
                            <div class="col">
                                <div class="form-check feature-check"><input class="form-check-input" type="checkbox"
                                        id="lift"><label class="form-check-label" for="lift">Elevator
                                        Lift</label></div>
                            </div>
                            <div class="col">
                                <div class="form-check feature-check"><input class="form-check-input" type="checkbox"
                                        id="pool"><label class="form-check-label" for="pool">Swimming
                                        Pool</label></div>
                            </div>
                            <div class="col">
                                <div class="form-check feature-check"><input class="form-check-input" type="checkbox"
                                        id="gym"><label class="form-check-label" for="gym">Gym</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

</form>

<script>
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

    if (window.location.search.length > 0) {
        const newUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }


    document.addEventListener('DOMContentLoaded', function() {
        const filterBtn = document.getElementById('toggleFilters');
        const advancedFilters = document.getElementById('advancedFilters');

        filterBtn.addEventListener('click', function() {
            if (advancedFilters.style.display === 'none' || advancedFilters.style.display === '') {
                advancedFilters.style.display = 'block';
                filterBtn.innerHTML = '<i class="bi bi-x-circle"></i> Hide Filters';
            } else {
                advancedFilters.style.display = 'none';
                filterBtn.innerHTML = '<i class="bi bi-funnel"></i> Filters';
            }
        });
    });
</script>
