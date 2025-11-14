@extends('layouts.app')

@section('title', 'Buy Properties')
@section('content')


    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

        <link href="{{ asset('public\frontend\css\custom.css') }}" rel="stylesheet">

        <!-- LightGallery CSS -->
        <link href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css" rel="stylesheet">

        <!-- LightGallery JS -->
        <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/thumbnail/lg-thumbnail.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/zoom/lg-zoom.umd.min.js"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
            rel="stylesheet">


        <style>
            .badge-rent,
            .badge-sell {
                background-color: #aa8038 !important;
                color: #fff !important;
                padding: 6px 12px;
                border-radius: 4px;
                font-size: 0.9rem;
            }

            .lg-outer .lg-thumb-item.active,
            .lg-outer .lg-thumb-item:hover {
                border-color: #aa8038;
            }

            /* 🔽 Vertical Right-Side Feedback Button (Slightly Below Center) */
            .btn-feedback {
                position: fixed;
                top: 70%;
                /* 👈 moves button a bit below center (adjust 55–65% as needed) */
                right: 0;
                transform: translateY(-50%);
                background-color: #aa8038;
                color: #fff;
                border: none;
                border-radius: 8px 0 0 8px;
                font-family: "Inter", sans-serif;
                padding: 3px 5px;
                font-weight: 500;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                z-index: 1055;
                writing-mode: vertical-rl;
                /* vertical text */
                text-orientation: mixed;

                transition: all 0.3s ease;
            }

            .btn-feedback i {
                transform: rotate(90deg);
                margin-bottom: 5px;
            }

            .btn-feedback:hover {
                background-color: #8c682c;
                color: #fff;
                transform: translateY(-50%) scale(1.05);
            }
        </style>
    </head>

    <div class="container my-5 pt-5">

        <!-- =======================
                            IMAGE GALLERY
                            ======================== -->
        <div class="row justify-content-center">
            <div class="col-lg-12">

                <div class="card p-4 shadow-sm mb-4">
                    <h5 class="fw-semibold mb-3">Gallery</h5>

                    <!-- Main Slider -->
                    <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" id="lightgallery">

                            @foreach ($property->images as $index => $image)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <a href="{{ asset('storage/app/propertyImage/' . ($image->filename ?? 'default.jpg')) }}"
                                        data-sub-html="<h6>Devotion Property {{ $index + 1 }}</h6>">

                                        <img src="{{ asset('storage/app/propertyImage/' . ($image->filename ?? 'default.jpg')) }}"
                                            class="d-block w-100 rounded shadow" style="height: 580px; ">
                                    </a>
                                </div>
                            @endforeach

                        </div>

                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>

                        <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>

                    <!-- Thumbnails -->
                    <div class="d-flex flex-wrap gap-2 mt-3 justify-content-center">
                        @foreach ($property->images as $key => $image)
                            <img src="{{ asset('storage/app/propertyImage/' . $image->filename) }}" class="img-thumbnail"
                                style="width:150px; height:100px; object-fit:cover; cursor:pointer;"
                                onclick="goToSlide({{ $key }})">
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <!-- =======================
                            CONTENT ROW (DETAILS + CONTACT)
                            ======================== -->
        <div class="row g-4">

            <!-- LEFT SIDE: Property Details -->
            <div class="col-lg-8">

                <!-- Price + Buttons -->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">

                    <div>
                        <h2 class="fw-bold pb-3">{{ $property->name ?? 'N/A' }}</h2>
                        <h3>AED {{ number_format($property->price) }}</h3>
                        <p class="text-muted mb-1">{{ $property->finance_name }}</p>

                        <div class="d-flex align-items-center">
                            <span class="me-3">
                                <i class="bi bi-door-closed me-1"></i>
                                {{ $property->beds == 0 ? 'Studio' : $property->beds }} beds
                            </span>

                            @if ($property->baths > 0)
                                <span class="me-3">
                                    <i class="bi bi-bucket me-1"></i> {{ $property->baths }} baths
                                </span>
                            @endif
                            <span class="me-3"><i class="bi bi-rulers me-1"></i> {{ $property->area }} Sq.Ft.</span>
                        </div>

                        <p class="mt-2 mb-0">
                            <i class="bi bi-geo-alt"></i>
                            {{ $property->location->name ?? 'N/A' }}
                        </p>
                    </div>
                    <style>
                        .share-btn {
                            background-color: white;
                            color: #000;
                            border: 1px solid lightgray;
                            transition: 0.3s;
                        }

                        .share-btn:hover {
                            background-color: #aa8038 !important;
                            color: white !important;
                        }
                    </style>
                    <!-- Favorite + Share -->
                    <div class="d-flex mt-3 mt-md-0">
                        <button class="btn share-btn" onclick="shareProperty()">
                            <i class="bi bi-share"></i> Share
                        </button>
                    </div>
                </div>

                <hr>


                {{-- <div class="d-flex justify-content-between mb-3">
                    <h5 class="fw-semibold mb-3">Project Name</h5>
                    <span class="text-end text-wrap" style="max-width: 60%;">
                        {{ $property->name ?? 'N/A' }}
                    </span>
                </div> --}}


                <div class="card mt-4 mb-4">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-4">Property Description</h5>

                        <p class="mb-0">
                            {!! $property->description ?? 'No description available.' !!}
                        </p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-2">Property Features</h5>
                        <p class="pb-2">
                            {!! $property->additional_features ?? 'No Features available.' !!}
                        </p>
                    </div>
                </div>

                <!-- Two Column Property Info -->
                <div class="card">
                    <div class="card-body">
                        <div class="row g-4">

                            <h5 class="fw-semibold mb-4">Property Information</h5>

                            <div class="row">

                                <!-- Column 1 -->
                                <div class="col-md-6 border-end pe-4">

                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="fw-semibold">Type</span>
                                        <span>{{ $property->type == 1 ? 'Residential' : 'Commercial' }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="fw-semibold">Sub Type</span>
                                        <span>{{ $property->subtype->name ?? 'N/A' }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="fw-semibold">Furnishing</span>
                                        <span>{{ $property->is_furnish == 1 ? 'Furnished' : 'UnFurnished' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="fw-semibold">Completion Status</span>

                                        <span>
                                            @switch($property->is_complete)
                                                @case(1)
                                                    Ready
                                                @break

                                                @case(2)
                                                    Secondary
                                                @break

                                                @case(3)
                                                    Off-Plan
                                                @break

                                                @default
                                                    N/A
                                            @endswitch
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="fw-semibold">Handover</span>
                                        <span>{{ $property->quarter ?? 'N/A' }}</span>
                                    </div>



                                </div>

                                <!-- Column 2 -->
                                <div class="col-md-6 ps-4">

                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="fw-semibold">Purpose</span>
                                        <span>{{ $property->purpose == 1 ? 'For Sale' : 'For Rent' }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="fw-semibold">Payment Plan</span>
                                        <span>{{ $property->plan_detail ?? 'N/A' }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="fw-semibold">Developer</span>
                                        <span>{{ $property->develop_by ?? 'N/A' }}</span>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Property Details -->
                    <div class="card shadow-sm border-1 mb-4 rounded-4 d-none">
                        <div class="p-3">
                            <h5 class="fw-semibold mb-3">Details</h5>
                            <hr>
                            <div class="row g-3 text-muted">

                                <div class="col-md-4"><strong>RERA Number:</strong>
                                    <span class="ms-2">{{ $property->rera_number ?? 'N/A' }}</span>
                                </div>
                                <div class="col-md-6"><strong>Permit Number :</strong>
                                    <span class="ms-2">{{ $property->permit_number ?? 'N/A' }}</span>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- @include('frontend.layouts.partials.mortgage') --}}

                </div>
            </div>

            <!-- RIGHT SIDE: Contact Seller -->
            <div class="col-lg-4 seller-review-form">

                <div class="card shadow-sm border-1 rounded-4 p-4">
                    <h5 class="mb-3">Contact seller</h5>

                    <!-- Seller Info -->
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <img src="{{ asset('public/img/devotion-trusted-real-estate.png') }}"
                            style="width:100px; object-fit:contain;">

                        <div>
                            <p class="fw-semibold mb-1">{{ $property->agent->first_name }}</p>

                            <p class="text-muted small mb-1">
                                <a href="tel:{{ $property->agent->mobile_no }}" class="text-muted text-decoration-none">
                                    <i class="bi bi-phone"></i> {{ $property->agent->mobile_no }}
                                </a>
                            </p>

                            <p class="text-muted small mb-0">
                                <a href="mailto:{{ $property->agent->email_id }}"
                                    class="text-muted text-decoration-none">
                                    <i class="bi bi-envelope"></i> {{ $property->agent->email_id }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <form action="{{ route('property-contact.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="property_id" value="{{ $property->unique_id }}">

                        <div class="mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Full name *"
                                required>
                        </div>

                        <div class="mb-3">
                            <input type="text" name="mobile_number" class="form-control" placeholder="Phone number *"
                                required>
                        </div>

                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email address">
                        </div>

                        <div class="mb-4">
                            <textarea name="message" rows="4" class="form-control" placeholder="Your message *" required></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn flex-fill text-white fw-semibold"
                                style="background:#aa8038; border-radius:30px;">
                                <i class="bi bi-envelope-fill me-2"></i> Send message
                            </button>

                            <a href="tel:+97144488538" class="btn flex-fill fw-semibold"
                                style="background:#fff8ee; border:1px solid #aa8038; color:#aa8038; border-radius:30px;">
                                <i class="bi bi-telephone-fill me-1"></i> Call
                            </a>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>





    <!-- 🔽 Fixed Vertical Feedback Button -->
    <button type="button" class="btn btn-feedback" data-bs-toggle="modal" data-bs-target="#feedbackModal">
        <i class="bi bi-chat-left-text me-1"></i> Send Feedback
    </button>

    <!-- 🔽 Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-semibold" id="feedbackModalLabel">Leave a review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('review.store') }}" method="POST">
                        @csrf

                        <!-- Hidden Property ID -->
                        <input type="hidden" name="property_id" value="{{ $property->unique_id }}">

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Your name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Your name" required>
                        </div>

                        <!-- Email & Phone -->
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Your email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contact_no" class="form-label">Phone number</label>
                                <input type="text" name="contact_no" id="contact_no" class="form-control"
                                    placeholder="Your phone">
                            </div>
                        </div>

                        <!-- Review -->
                        <div class="mb-3">
                            <label for="review" class="form-label">Your review <span
                                    class="text-danger">*</span></label>
                            <textarea name="review" id="review" class="form-control" rows="4" placeholder="Your message" required></textarea>
                        </div>



                        <!-- Submit -->
                        <button type="submit" class="btn w-100 py-2 fw-semibold text-white"
                            style="background-color: #aa8038; border-radius: 30px;">
                            Send review
                        </button>

                        <!-- ✅ Success / Error Messages -->
                        @if (session('success'))
                            <div class="alert alert-success mt-3 mb-0 rounded-3">
                                {{ session('success') }}
                            </div>
                        @endif


                    </form>

                </div>
            </div>
        </div>
    </div>


    <script>
        function changeMainImage(element) {
            document.getElementById('mainImage').src = element.src;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.rating i');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    ratingInput.value = value; // ✅ set rating value in hidden input

                    // ✅ highlight stars
                    stars.forEach(s => s.classList.remove('text-warning'));
                    for (let i = 0; i < value; i++) {
                        stars[i].classList.add('text-warning');
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const gallery = document.getElementById("lightgallery");
            const feedbackBtn = document.querySelector(".btn-feedback");

            if (gallery) {
                const lgInstance = lightGallery(gallery, {
                    selector: 'a',
                    plugins: [lgZoom, lgThumbnail],
                    thumbnail: true,
                    zoom: true,
                    fullScreen: true,
                    animateThumb: true,
                    showThumbByDefault: true,
                    download: false
                });

                // 🔽 Hide Feedback Button When Gallery Opens
                gallery.addEventListener('lgAfterOpen', () => {
                    feedbackBtn.style.display = 'none';
                });

                // 🔽 Show Feedback Button When Gallery Closes
                gallery.addEventListener('lgAfterClose', () => {
                    feedbackBtn.style.display = 'block';
                });
            }
        });

        // Function to go to clicked slide
        function goToSlide(index) {
            var carousel = bootstrap.Carousel.getInstance(document.getElementById('propertyCarousel'));
            carousel.to(index);
        }

        // Sync main carousel with modal carousel
        const modalElement = document.getElementById('imageModal');
        modalElement.addEventListener('show.bs.modal', function(event) {
            const triggerImage = event.relatedTarget;
            const index = triggerImage.getAttribute('data-index');
            const modalCarousel = bootstrap.Carousel.getInstance(document.getElementById('modalCarousel')) ||
                new bootstrap.Carousel('#modalCarousel');
            modalCarousel.to(index);
        });


        //share button logic
        function shareProperty() {
            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    text: "Check out this property!",
                    url: window.location.href
                }).catch((error) => console.log("Sharing failed:", error));
            } else {
                // Fallback for browsers that do not support native share
                alert("Share feature is not supported in this browser.");
            }
        }
    </script>

@endsection
