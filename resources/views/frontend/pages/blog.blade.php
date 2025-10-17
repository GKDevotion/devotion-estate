@extends('layouts.app')

@section('title', 'Contact Us Page')

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


    <div class="container" style="padding-top: 80px; ">


        <div class="container my-5">
            <div class="d-flex align-items-center mb-4">
                <a href="index.html" class="text-secondary text-decoration-none me-2">Home</a>
                <span class="text-secondary me-2"> > </span>
                <span class="fw-bold" href="blogs.html">Blog</span>
            </div>
            <h3 class="mb-4">Blog</h3>

            <div class="row">
                <div class="col-lg-8">
                    <div id="blogContainer" class="row g-4 mb-5">
                        <!-- All blog cards here -->
                        <div class="col-md-6 blog-item">
                            <a href="blog-detail.html?slug=rental-property-management-in-uae"
                                class="text-decoration-none text-dark">
                                <div class="card border-0">
                                    <img src="public\frontend\assets\images\img\blog1.png"
                                        class="card-img-top card-img-top-custom" alt="Rental Property Management in UAE">
                                    <div class="card-body p-0 pt-3">
                                        <div class="d-flex align-items-center mb-2 text-date-category">
                                            <span class="me-3">21-12-2024</span>
                                            <span class="d-flex align-items-center">
                                                <i class="bi bi-file-text-fill me-1"></i> Real Estate
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-normal">Rental Property Management in UAE</h5>
                                        <p class="card-text text-center mt-3">
                                            Read more <i class="bi bi-arrow-right"></i>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-md-6 blog-item">
                            <a href="blog-detail.html?slug=the-indispensable-role-of-a-real-estate-broker"
                                class="text-decoration-none text-dark">
                                <div class="card border-0">
                                    <img src="public\frontend\assets\images\img\blog2.png"
                                        class="card-img-top card-img-top-custom" alt="Real Estate Broker">
                                    <div class="card-body p-0 pt-3">
                                        <div class="d-flex align-items-center mb-2 text-date-category">
                                            <span class="me-3">18-12-2024</span>
                                            <span class="d-flex align-items-center">
                                                <i class="bi bi-file-text-fill me-1"></i> Real Estate
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-normal">The Indispensable Role of a Real Estate Broker</h5>
                                        <p class="card-text text-center mt-3">
                                            Read more <i class="bi bi-arrow-right"></i>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>



                        <div class="col-md-6 blog-item">
                            <a href="blog-detail.html?slug=marbella-property" class="text-decoration-none text-dark">
                                <div class="card border-0">
                                    <img src="public\frontend\assets\images\img\blog3.png"
                                        class="card-img-top card-img-top-custom" alt="Marbella">
                                    <div class="card-body p-0 pt-3">
                                        <div class="d-flex align-items-center mb-2 text-date-category">
                                            <span class="me-3">17-12-2024</span>
                                            <span class="d-flex align-items-center">
                                                <i class="bi bi-file-text-fill me-1"></i> Real Estate
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-normal">Marbella Property Title Example</h5>
                                        <p class="card-text text-center mt-3">
                                            Read more <i class="bi bi-arrow-right"></i>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>



                        <div class="col-md-6 blog-item">
                            <a href="blog-detail.html?slug=brokers-in-dubai" class="text-decoration-none text-dark">
                                <div class="card border-0">
                                    <img src="public\frontend\assets\images\img\blog4.png"
                                        class="card-img-top card-img-top-custom" alt="Brokers in Dubai">
                                    <div class="card-body p-0 pt-3">
                                        <div class="d-flex align-items-center mb-2 text-date-category">
                                            <span class="me-3">12-12-2024</span>
                                            <span class="d-flex align-items-center">
                                                <i class="bi bi-file-text-fill me-1"></i> Real Estate
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-normal">Title corresponding to Brokers in Dubai</h5>
                                        <p class="card-text text-center mt-3">
                                            Read more <i class="bi bi-arrow-right"></i>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-md-6 blog-item">
                            <a href="blog-detail.html?slug=dubai-real-estate-statistical-overview"
                                class="text-decoration-none text-dark">
                                <div class="card border-0">
                                    <img src="public\frontend\assets\images\img\blog5.png"
                                        class="card-img-top card-img-top-custom" alt="Dubai Real Estate">
                                    <div class="card-body p-0 pt-3">
                                        <div class="d-flex align-items-center mb-2 text-date-category">
                                            <span class="me-3">02-12-2024</span>
                                            <span class="d-flex align-items-center">
                                                <i class="bi bi-file-text-fill me-1"></i> Real Estate
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-normal">Dubai Real Estate: A Statistical Overview and
                                            Future Trends</h5>
                                        <p class="card-text text-center mt-3">
                                            Read more <i class="bi bi-arrow-right"></i>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>



                        <div class="col-md-6 blog-item">
                            <a href="blog-detail.html?slug=invest-in-dubai-lucrative-opportunity"
                                class="text-decoration-none text-dark">
                                <div class="card border-0">
                                    <img src="public\frontend\assets\images\img\blog6.png"
                                        class="card-img-top card-img-top-custom" alt="Dubai Real Estate">
                                    <div class="card-body p-0 pt-3">
                                        <div class="d-flex align-items-center mb-2 text-date-category">
                                            <span class="me-3">27-11-2024</span>
                                            <span class="d-flex align-items-center">
                                                <i class="bi bi-file-text-fill me-1"></i> Real Estate
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-normal">Invest in Dubai: A Lucrative Real Estate
                                            Opportunity</h5>
                                        <p class="card-text text-center mt-3">
                                            Read more <i class="bi bi-arrow-right"></i>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>



                        <div class="col-md-6 blog-item">
                            <a href="blog-detail.html?slug=real-estate-broker-company-dubai"
                                class="text-decoration-none text-dark">
                                <div class="card border-0">
                                    <img src="public\frontend\assets\images\img\blog7.png"
                                        class="card-img-top card-img-top-custom" alt="Dubai Real Estate">
                                    <div class="card-body p-0 pt-3">
                                        <div class="d-flex align-items-center mb-2 text-date-category">
                                            <span class="me-3">23-11-2024</span>
                                            <span class="d-flex align-items-center">
                                                <i class="bi bi-file-text-fill me-1"></i> Real Estate
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-normal">Real Estate Broker Company in Dubai</h5>
                                        <p class="card-text text-center mt-3">
                                            Read more <i class="bi bi-arrow-right"></i>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>



                        <div class="col-md-6 blog-item">
                            <a href="blog-detail.html?slug=top-real-estate-companies-dubai-2025"
                                class="text-decoration-none text-dark">
                                <div class="card border-0">
                                    <img src="public\frontend\assets\images\img\blog8.png"
                                        class="card-img-top card-img-top-custom" alt="Dubai Real Estate">
                                    <div class="card-body p-0 pt-3">
                                        <div class="d-flex align-items-center mb-2 text-date-category">
                                            <span class="me-3">06-12-2024</span>
                                            <span class="d-flex align-items-center">
                                                <i class="bi bi-file-text-fill me-1"></i> Real Estate
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-normal">Top Real Estate Companies in Dubai - 2025</h5>
                                        <p class="card-text text-center mt-3">
                                            Read more <i class="bi bi-arrow-right"></i>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>




                        <div class="col-md-6 blog-item">
                            <a href="blog-detail.html?slug=lack-of-home-listings-mortgage-demand"
                                class="text-decoration-none text-dark">
                                <div class="card border-0">
                                    <img src="public\frontend\assets\images\img\blog9.png"
                                        class="card-img-top card-img-top-custom" alt="Dubai Real Estate">
                                    <div class="card-body p-0 pt-3">
                                        <div class="d-flex align-items-center mb-2 text-date-category">
                                            <span class="me-3">01-08-2024</span>
                                            <span class="d-flex align-items-center">
                                                <i class="bi bi-file-text-fill me-1"></i> Housing
                                            </span>
                                        </div>
                                        <h5 class="card-title fw-normal">Lack of home listings is taking a toll on mortgage
                                            demand</h5>
                                        <p class="card-text text-center mt-3">
                                            Read more <i class="bi bi-arrow-right"></i>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>



                    </div>

                    <!-- PAGINATION -->
                    <nav aria-label="Blog pagination" class="d-flex justify-content-center">
                        <ul class="pagination" id="pagination"></ul>
                    </nav>
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <h5 class="mb-3 fw-bold">Categories</h5>
                    <div class="input-group mb-4 border rounded">
                        <input type="text" class="form-control border-0" placeholder="Search..." aria-label="Search">
                        <button class="btn border-0" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.088.117l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.01 1.01 0 0 0-.117-.088M12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg>
                        </button>
                    </div>

                    <ul class="list-group list-group-flush mb-5">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <a href="#" class="text-decoration-none fw-semibold text-dark">Real Estate</a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <a href="#" class="text-decoration-none fw-semibold text-dark">Housing</a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <a href="#" class="text-decoration-none fw-semibold text-dark">Real Estate Broker</a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <a href="#" class="text-decoration-none fw-semibold text-dark">Dubai Luxury
                                Properties</a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-bottom">
                            <a href="#" class="text-decoration-none fw-semibold text-dark fw-bold">All</a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg>
                        </li>
                    </ul>

                    <h5 class="mb-3 fw-bold">Popular tags</h5>
                    <div class="input-group mb-4 border rounded">
                        <input type="text" class="form-control border-0" placeholder="Search..." aria-label="Search">
                        <button class="btn border-0" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.088.117l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.01 1.01 0 0 0-.117-.088M12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg>
                        </button>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge text-dark border p-2">Dubai real estate</span>
                        <span class="badge  text-dark border p-2">Dubai Property Market</span>
                        <span class="badge  text-dark border p-2">Dubai real estate market</span>
                        <span class="badge  text-dark border p-2">Real Estate Brokers in Dubai</span>
                        <span class="badge  text-dark border p-2">Luxury Properties</span>
                        <span class="badge  text-dark border p-2">Dubai luxury properties</span>
                        <span class="badge  text-dark border p-2">Dubai real estate regulations</span>
                    </div>

                    <!-- Most Viewed Section -->
                    <div class="mt-5">
                        <h5 class="mb-3 fw-bold">Most Viewed</h5>

                        <div class="list-group list-group-flush recent-blogs">
                            <!-- Blog 1 -->
                            <a href="#" class="list-group-item blog-item d-flex align-items-center gap-3">
                                <img src="public\frontend\assets\images\img\blog1.png"
                                    alt="Rental Property Management in UAE" class="blog-thumb">
                                <div class="flex-grow-1">
                                    <h6 class="blog-title">Rental Property Management in UAE</h6>
                                </div>
                            </a>

                            <!-- Blog 2 -->
                            <a href="#" class="list-group-item blog-item d-flex align-items-center gap-3">
                                <img src="public\frontend\assets\images\img\blog2.png"
                                    alt="Why Hiring a Broker in Dubai Is Essential" class="blog-thumb">
                                <div class="flex-grow-1">
                                    <h6 class="blog-title">Why Hiring a Broker in Dubai Is Essential for Your Property and
                                        Business Needs
                                    </h6>
                                </div>
                            </a>

                            <!-- Blog 3 -->
                            <a href="#" class="list-group-item blog-item d-flex align-items-center gap-3">
                                <img src="public\frontend\assets\images\img\blog3.png" alt="Top Real Estate Companies"
                                    class="blog-thumb">
                                <div class="flex-grow-1">
                                    <h6 class="blog-title">Top Real Estate Companies in Dubai - 2025</h6>
                                </div>
                            </a>

                            <!-- Blog 4 -->
                            <a href="#" class="list-group-item blog-item d-flex align-items-center gap-3">
                                <img src="public\frontend\assets\images\img\blog4.png" alt="Invest in Dubai"
                                    class="blog-thumb">
                                <div class="flex-grow-1">
                                    <h6 class="blog-title">Invest in Dubai: A Lucrative Real Estate Opportunity</h6>
                                </div>
                            </a>

                            <!-- Blog 5 -->
                            <a href="#" class="list-group-item blog-item d-flex align-items-center gap-3">
                                <img src="public\frontend\assets\images\img\blog5.png" alt="Dubai Real Estate Stats"
                                    class="blog-thumb">
                                <div class="flex-grow-1">
                                    <h6 class="blog-title">Dubai Real Estate: A Statistical Overview and Future Outlook
                                    </h6>
                                </div>
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const itemsPerPage = 8; // show 2 blogs per page
            const blogItems = document.querySelectorAll(".blog-item");
            const totalPages = Math.ceil(blogItems.length / itemsPerPage);
            const pagination = document.getElementById("pagination");

            function showPage(page) {
                blogItems.forEach((item, index) => {
                    item.style.display =
                        index >= (page - 1) * itemsPerPage && index < page * itemsPerPage ?
                        "block" :
                        "none";
                });
            }

            function renderPagination() {
                pagination.innerHTML = "";

                // Prev Button
                const prev = document.createElement("li");
                prev.classList.add("page-item");
                prev.innerHTML = `<a class="page-link" href="#" aria-label="Previous"><span>&laquo;</span></a>`;
                pagination.appendChild(prev);

                // Page numbers
                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement("li");
                    li.classList.add("page-item");
                    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                    pagination.appendChild(li);
                }

                // Next Button
                const next = document.createElement("li");
                next.classList.add("page-item");
                next.innerHTML = `<a class="page-link" href="#" aria-label="Next"><span>&raquo;</span></a>`;
                pagination.appendChild(next);

                // Add event listeners
                const pageLinks = pagination.querySelectorAll(".page-link");
                let currentPage = 1;

                function updateActivePage(page) {
                    currentPage = page;
                    showPage(page);
                    pagination.querySelectorAll(".page-item").forEach((li, idx) => {
                        li.classList.remove("active", "disabled");
                        if (idx === page) li.classList.add("active");
                    });
                    if (page === 1) prev.classList.add("disabled");
                    if (page === totalPages) next.classList.add("disabled");
                }

                prev.addEventListener("click", (e) => {
                    e.preventDefault();
                    if (currentPage > 1) updateActivePage(currentPage - 1);
                });
                next.addEventListener("click", (e) => {
                    e.preventDefault();
                    if (currentPage < totalPages) updateActivePage(currentPage + 1);
                });
                pageLinks.forEach((link, idx) => {
                    link.addEventListener("click", (e) => {
                        e.preventDefault();
                        if (idx === 0) return; // prev
                        if (idx === totalPages + 1) return; // next
                        updateActivePage(idx);
                    });
                });

                updateActivePage(1);
            }

            renderPagination();
        });
    </script>


@endsection
