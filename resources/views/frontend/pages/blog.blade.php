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

            <div class="small mb-5" style="font-size: large;">
                <a href="{{ url('/') }}" class="text-decoration-none text-dark">Home</a>
                <span class="mx-1 fs-4">›</span>
                <a href="/" class="text-decoration-none" style="color:#aa8038;">
                    Blog
                </a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div id="blogContainer" class="row g-4 mb-5">

                        @forelse ($blogs as $blog)
                            <div class="col-md-6 blog-item">
                                <a href="{{ route('blog.details', $blog->slug) }}" class="text-decoration-none text-dark">
                                    <div class="card border-0 h-100">
                                        <img src="{{ asset('storage/app/blog/' . $blog->image) }}"
                                            class="card-img-top card-img-top-custom" alt="{{ $blog->title }}">

                                        <div class="card-body p-0 pt-3">
                                            <div class="d-flex align-items-center mb-2 text-muted small">
                                                <span class="me-3">
                                                    {{ \Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}
                                                </span>
                                                <span class="d-flex align-items-center">
                                                    <i class="bi bi-folder2-open me-1"></i>
                                                    {{ $blog->category->title ?? 'Uncategorized' }}
                                                </span>
                                            </div>

                                            <h5 class="fw-normal">{{ $blog->title }}</h5>
                                            <p class="text-center mt-2 text-primary">
                                                Read article <i class="bi bi-arrow-right"></i>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        @empty
                            <!-- EMPTY STATE -->
                            <div class="col-12">
                                <div class="d-flex flex-column align-items-center justify-content-center py-5">

                                    <div class="empty-icon mb-3">
                                        <i class="bi bi-journal-text"></i>
                                    </div>

                                    <h4 class="fw-semibold mb-2">No Articles Available</h4>

                                    <p class="text-muted text-center mb-3" style="max-width: 420px;">
                                        We couldn’t find any blog posts at the moment.
                                        New articles will be published soon.
                                    </p>

                                    <a href="{{ route('blog') }}" class="btn   border-0 px-4">
                                        View All Blogs
                                    </a>
                                </div>
                            </div>
                        @endforelse

                    </div>



                    <!-- PAGINATION -->
                    <div class="d-flex justify-content-center">
                        {{ $blogs->links('vendor.pagination.bootstrap-5') }}
                    </div>

                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <h5 class="mb-3 fw-bold">Categories</h5>

                    <form action="{{ route('blog') }}" method="GET">
                        <div class="input-group mb-4 border">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Search categories...">
                            <button class="btn border-0" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
 
                    <ul class="list-group list-group-flush">
                        @foreach ($categories as $parent)
                            @foreach ($parent->children as $child)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('blog', ['category' => $child->id]) }}"
                                        class="text-decoration-none
                                        {{ request('category') == $child->id ? 'fw-bold text-primary' : 'text-dark' }}">
                                        {{ $child->title }}
                                    </a>
                                    <i class="bi bi-arrow-right"></i>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
 
                    <!-- Popular Tags -->
                    <div>
                        <h5 class="fw-bold mb-3">Popular tags</h5>

                        <form method="GET" action="{{ route('blog') }}">
                            <input type="text" name="tag" class="form-control mb-3" placeholder="Search tags..."
                                value="{{ request('tag') }}">
                        </form>

                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($popularTags as $tag)
                                <a href="{{ route('blog', ['tag' => $tag->name]) }}"
                                    class="btn btn-outline-secondary btn-sm rounded-pill">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>


                    <!-- Most Viewed Section -->
                    <div class="mt-5">
                        <h5 class="mb-3 fw-bold">Most Viewed</h5>

                        <div class="list-group list-group-flush recent-blogs">
                            @foreach ($recentBlogs as $recent)
                                <a href="{{ route('blog.details', $recent->slug) }}"
                                    class="list-group-item d-flex align-items-center">

                                    <img src="{{ asset('storage/app/blog/' . $recent->image) }}"
                                        alt="{{ $recent->title }}" class="blog-thumb">

                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="blog-title mb-0">{{ $recent->title }}</h6>
                                    </div>
                                </a>
                            @endforeach
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
