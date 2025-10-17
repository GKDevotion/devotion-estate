@extends('layouts.app')

@section('title', 'Rent Properties')

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
        <div class="row g-2 justify-content-center mb-4" style="padding-top: 60px">

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



        <!-- Header -->
        <div class="row align-items-center mb-3">
            <div class="col-md-8">
                <h1 class="h3 fw-normal fw-semibold" style="font-size: 2rem;">Residential Properties for Rent in Dhabi
                </h1>
                <p class="medium" style="color: #a47a46;">
                    There are currently <span id="totalProperties"></span> properties.
                </p>

            </div>
            <div class="col-md-4 text-md-end">
                <div class="col-12 ">
                    <label for="showProps" class="form-label small">Show Property(s) Per Page:</label>
                    <div class="col-12  d-flex justify-content-end">
                        <select id="showProps" class="form-select form-select-sm w-50">
                            <option value="3" selected>3</option>
                            <option value="4">4</option>
                        </select>
                    </div>

                </div>

            </div>
        </div>

        <!-- Property Cards Container -->
        <div id="propertyList"></div>

        <!-- Pagination -->
        <nav>
            <ul id="pagination" class="pagination justify-content-center mt-4"></ul>
        </nav>

    </div>

    <script>
        // Sample property data
        const properties = [{
                title: "Fully Furnished | Vacant | Luxury Living | Bills Inclusive",
                location: "Downtown, Dubai, UAE",
                price: "AED 175,000.00",
                beds: "Studio",
                baths: 2,
                area: "474 Sq.Ft.",
                image: "https://admin.devotionestate.com/images/PID125_1151768812_.webp",
                link: "signup.html"
            },
            {
                title: "Fully Furnished 1 BHK | Bills included | Prime Location",
                location: "Downtown, Dubai, UAE",
                price: "AED 199,000.00",
                beds: 1,
                baths: 2,
                area: "839 Sq.Ft.",
                image: "https://admin.devotionestate.com/images/PID119_12101886615_.webp",
                link: "signup.html"
            },
            {
                title: "Best Price | Fully Furnished 1 BHK | Prime Location | Spacious Balcony",
                location: "Elite Business Bay Residence, Business Bay, Dubai",
                price: "AED 2,200,000.00",
                beds: 1,
                baths: 2,
                area: "853 Sq.Ft.",
                image: "https://admin.devotionestate.com/images/PID118_1775375364_.webp"
            },

        ];

        const propertyList = document.getElementById("propertyList");
        const pagination = document.getElementById("pagination");
        const totalProperties = document.getElementById("totalProperties");
        const showProps = document.getElementById("showProps");

        let currentPage = 1;
        let perPage = parseInt(showProps.value);

        totalProperties.textContent = properties.length;

        function renderProperties() {
            propertyList.innerHTML = "";

            const start = (currentPage - 1) * perPage;
            const end = start + perPage;
            const visible = properties.slice(start, end);

            visible.forEach(p => {
                propertyList.innerHTML += `
       <a href="${p.link}" class="text-decoration-none text-dark">
  <div class="card mb-4 p-3 shadow-sm border-0">
    <div class="row g-0">
      <div class="col-lg-4">
        <img src="${p.image || 'https://via.placeholder.com/350x200?text=Property'}" 
             class="img-fluid rounded-start h-100 object-fit-cover" 
             alt="Property Image">
      </div>
      <div class="col-lg-8">
   <div class="card-body">
    <div class="row align-items-start">
        
        <div class="col-8"> 
            <h5 class="fw-bold w-100">${p.title}</h5>
        <p class="text-muted mb-1" style="font-size: 0.85rem;">
        <i class="fas fa-map-marker-alt me-1"></i> ${p.location}
        </p>

            <h4 class=" fw-bold mt-4" style="font-size: 1.5rem; color:#a47a46;">${p.price}</h4>

           <div class="d-flex flex-column align-items-start">
            <div class="mb-2">
                <i class="fas fa-bed me-1 text-muted"></i>
                <span class="small ">${p.beds}</span>
            </div>

            <div class="mb-2">
                <i class="fas fa-bath me-1 text-muted"></i>
                <span class="small ">Baths: ${p.baths}</span>
            </div>

            <div class="mb-2">
                <i class="fas fa-ruler-combined me-1 text-muted"></i>
                <span class="small ">Area: ${p.area}</span>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-sm" style="background-color: #aa8038; color: white;">
                <i class="bi bi-compass"></i>
                </button>
                <button class="btn btn-sm" style="background-color: #aa8038; color: white;">
                <i class="bi bi-heart"></i>
                </button>
            </div>
            </div>

        </div>
        
        <div class="col-4 text-end"> 
            <img src="public/frontend/assets/images/Devotion Real Estate.png" alt="Estate Agent Logo" class="img-fluid" style="max-width: 160px;">
            <p class="small text-muted text-end mt-2 mb-0">Devotion Estate Agent</p>
        </div>
    </div>
    
    </div>
      </div>
    </div>
  </div>
</a>
`;
            });

            renderPagination();
        }

        function renderPagination() {
            pagination.innerHTML = "";
            const totalPages = Math.ceil(properties.length / perPage);

            const prevDisabled = currentPage === 1 ? "disabled" : "";
            const nextDisabled = currentPage === totalPages ? "disabled" : "";

            pagination.innerHTML += `
      <li class="page-item ${prevDisabled}">
        <a class="page-link" href="#" onclick="changePage(${currentPage - 1})"><</a>
      </li>`;

            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `
        <li class="page-item ${i === currentPage ? 'active' : ''}">
          <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
        </li>`;
            }

            pagination.innerHTML += `
      <li class="page-item ${nextDisabled}">
        <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">></a>
      </li>`;
        }

        function changePage(page) {
            const totalPages = Math.ceil(properties.length / perPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderProperties();
        }

        showProps.addEventListener("change", () => {
            perPage = parseInt(showProps.value);
            currentPage = 1;
            renderProperties();
        });

        renderProperties();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

@endsection
