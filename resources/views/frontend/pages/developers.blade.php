@extends('layouts.app')

@section('title', 'Developers Page')


@section('content')

    {{--  Banner Section --}}
    <section class="developer-section postion-relative ">
        <div class="container">
            <h2 class="display-5 fw-bold text-uppercase">Developers We Work With</h2>
        </div>
    </section>

    <div class="container my-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <h5 class="fw-semibold mb-3">
                    <i class="bi bi-search me-2"></i> Explore Top Developers
                </h5>

                <hr>

                <div class="position-relative">
                    <input type="text" id="developerSearch" class="form-control form-control-lg ps-5"
                        placeholder="Search developers by name">

                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                </div>

            </div>
        </div>
    </div>

    <section class="py-2 bg-light" id="developerListSection">
        <div class="container">
            <div id="developerResults" class="row g-4">

                @include('frontend.layouts.partials.developer-list', ['developers' => $developers])

            </div>

            <div id="paginationWrapper">
                @if ($developers->hasPages())
                    <div class="mt-2 d-flex justify-content-center">
                        {{ $developers->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </section>




    <style>
        .developer-section {
            background: url("public/frontend/assets/developer/banner") no-repeat center center;
            background-size: cover;
            color: white;
            /* Set text color to white for better contrast on a dark image */
            padding: 200px 0;
            justify-content: center;
            /* Adjust padding as needed */
            text-align: center;
            position: relative;

        }

        /* Optional: Add an overlay to make the text more readable */
        .developer-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0) 0%, rgba(0 0 0 / 66%) 90%);
        }

        .developer-section .container {
            position: relative;
            /* Ensure container content is above the overlay */
            z-index: 1;
        }

        .developer-section h3 {
            font-family: "Merienda", cursive;
            font-size: 3rem;
        }

        @media (max-width: 991px) {
            .developer-section {
                padding-top: 30vh;
            }
        }
    </style>
    <script>
        const searchInput = document.getElementById('developerSearch');
        const resultsDiv = document.getElementById('developerResults');
        const pagination = document.getElementById('paginationWrapper');

        let debounceTimer;

        searchInput.addEventListener('keyup', function() {
            clearTimeout(debounceTimer);

            debounceTimer = setTimeout(() => {
                let query = this.value.trim();

                fetch(`{{ route('developers.search') }}?q=${query}`)
                    .then(res => res.text())
                    .then(html => {
                        resultsDiv.innerHTML = html;

                        // Hide pagination only while searching
                        pagination.style.display = query.length ? 'none' : 'block';
                    });
            }, 300);
        });
    </script>


@endsection
