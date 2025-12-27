<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<style>
    .btn-outline-custom.active {
        background-color: #aa8038;
        color: white;
        border-color: #aa8038;
    }
</style>
<form action="{{ route('properties.search') }}" method="GET" id="propertySearchForm" autocomplete="off">

    <!-- Hidden input for property type -->
    <input type="hidden" name="purpose" id="property_purpose" value="{{ $data['purpose'] ?? 0 }}">
    <input type="hidden" name="type" id="propertyMainTypeInput" value="{{ $data['type'] ?? 0 }}">
    <input type="hidden" name="sub_type_id" id="propertySubTypeInput" value="0">

    <input type="hidden" name="redirect_page" value="{{ $type ?? 'buy' }}">


    <!-- Filters and Search Section -->
    <div class="row g-2 justify-content-center mb-4" style="padding-top: 100px">

        <!-- Location Dropdown -->
        <div class="col-lg-2 col-md-4 col-sm-6 position-relative">
            <div class="input-group">

                <select id="locationInput" name="location" class="form-select border-start-0 select-location">
                    <option value="">All Location</option>

                    @forelse($locationObj->sortBy('name') as $p)
                        <option value="{{ $p->id }}" {{ request('location') == $p->id ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                    @empty
                        <option disabled>No Locations Found</option>
                    @endforelse
                </select>
            </div>
        </div>


        <!-- Property Type Dropdown -->
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="dropdown property-type-dropdown">
                <button class="btn btn-outline w-100 border bg-white d-flex justify-content-between align-items-center"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside"
                    id="propertyTypeButton">
                    <span id="propertyTypeLabel">Property Type</span>
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
                                    @forelse($residentialTypes as $p)
                                        <div class="col-6">
                                            <button type="button"
                                                class="btn btn-outline-custom w-100 py-2 property-type-btn"
                                                name="sub_type" data-type="{{ $p->main_type }}"
                                                data-id="{{ $p->id }}" data-name="{{ $p->name }}">
                                                {{ $p->name }}
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
                                    @forelse($commercialTypes as $p)
                                        <div class="col-6">
                                            <button type="button"
                                                class="btn btn-outline-custom w-100 py-2 property-type-btn"
                                                name="sub_type" data-type="{{ $p->main_type }}"
                                                data-id="{{ $p->id }}" data-name="{{ $p->name }}">
                                                {{ $p->name }}
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

        <!-- Bed -->
        <div class="col-lg-2 col-md-4 col-sm-6">
            <input type="number" class="form-control rounded-2" name="bed" placeholder="Bed"
                value="{{ request('bed') ?? '' }}" min="1">
        </div>

        <!-- Bath -->
        <div class="col-lg-2 col-md-4 col-sm-6">
            <input type="number" class="form-control rounded-2" name="bath" placeholder="Bath"
                value="{{ request('bath') ?? '' }}" min="1">
        </div>


        <!-- Keyword -->
        <div class="col-lg-2 col-md-4 col-sm-6 d-none">
            <input type="text" class="form-control" name="keyword" value="{{ request('keyword') ?? '' }}"
                placeholder="Search Keyword here">
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

            <button type="submit" class="btn search-btn p-3">
                Search Now <i class="fas fa-search"></i>
            </button>

        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
                selectedPropertyMainType = this.dataset.type;
                selectedPropertySubType = this.dataset.id;
                selectedPropertyName = this.dataset.name;

                console.log(selectedPropertyMainType, selectedPropertySubType,
                    selectedPropertyName, this);
                // Update hidden input
                document.getElementById('propertyMainTypeInput').value =
                    selectedPropertyMainType;
                document.getElementById('propertySubTypeInput').value = selectedPropertySubType;
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

        // Reset button for price
        document.getElementById('resetPrice').addEventListener('click', function() {
            document.getElementById('minPrice').value = '';
            document.getElementById('maxPrice').value = '';
        });

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

    $(document).ready(function() {
        $('.select-location').select2({
            placeholder: "Search location",
            allowClear: true,
            width: '100%'
        });
    });
</script>
