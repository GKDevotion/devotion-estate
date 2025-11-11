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

        <div class="row justify-content-center">
            <div class="col-lg-12">

                <!-- 🔽 Image Gallery Section with Slider -->
                <div class="card p-4 shadow-sm mb-3">
                    <h5 class="fw-semibold mb-3">Gallery</h5>

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
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>


                        <!-- Thumbnails -->
                        <div class="d-flex flex-wrap gap-2 mt-3 justify-content-center">
                            @foreach ($property->images as $key => $image)
                                <img src="{{ asset('storage/app/propertyImage/' . $image->filename) }}"
                                    class="img-thumbnail"
                                    style="width: 150px; height: 100px; object-fit: cover; cursor: pointer;"
                                    onclick="goToSlide({{ $key }})">
                            @endforeach
                        </div>
                    </div>
                </div>



                <!-- Property Info Card -->
                <div class="property-info-card shadow-lg rounded-4 p-3 bg-white mb-4">
                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <div>
                            <h3 class="fw-bold">{{ $property->name }}</h3>
                            <p class="text-muted mb-2">
                                <i class="bi bi-geo-alt"></i> {{ $property->location->name ?? 'N/A' }}
                            </p>

                            <span class="badge badge-rent {{ $property->purpose == 1 ? 'badge-rent' : 'badge-Sale' }}">
                                {{ $property->purpose == 1 ? 'For Sale' : 'For Rent' }}
                            </span>
                        </div>
                        <div class="text-end">
                            <div class="gap-2 pb-3 d-none">
                                <button class="btn btn-sm" style="background-color: #aa8038; color: white;">
                                    <i class="bi bi-compass"></i>
                                </button>
                                <button class="btn btn-sm" style="background-color: #aa8038; color: white;">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                            <h5 class="fw-bold" style="color: #aa8038">AED</h5>
                            <h3 class="fw-bold mb-0" style="color: #aa8038">{{ number_format($property->price, 2) }}</h3>
                        </div>
                    </div>
                </div>
                

                <div class="row g-4">

                    <div class="col-lg-8">

                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-3">Overview</h5>
                                <div class="row text-muted">
                                    <div class="col-md-3"><i class="bi bi-door-closed me-1"></i> Beds:
                                        {{ $property->beds }}
                                    </div>
                                    <div class="col-md-3"><i class="bi bi-bucket me-1"></i> Baths: {{ $property->baths }}
                                    </div>
                                    <div class="col-md-3"><i class="bi bi-rulers me-1"></i> Area: {{ $property->area }}
                                        Sq.Ft.
                                    </div>
                                    <div class="col-md-3"><i class="bi bi-house"></i>
                                        Type:{{ $property->type == 1 ? 'Residential' : 'Commercial' }}</div>

                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-3">Property Description</h5>
                                <p>{!!$property->description ?? 'No description available.' !!}</p>

                            </div>
                        </div>

                        
                        <!-- Pricing Details -->
                        <div class="card shadow-sm border-1 mb-4 rounded-4">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-3">Additional Features</h5>
                                <hr>
                                <div class="row g-3 text-muted">
                                    <div class="col-md-4">
                                        <span>{!! $property->additional_features ?? 'No Additional Feature available.'!!}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Details -->
                        <div class="card shadow-sm border-1 mb-4 rounded-4">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-3">Pricing Details</h5>
                                <hr>
                                <div class="row g-3 text-muted">
                                    <div class="col-md-4">
                                        <strong>Purpose:</strong>
                                        <span class="ms-2">{{ $property->purpose == 1 ? 'For Sale' : 'For Rent' }}</span>
                                    </div>


                                    <div class="col-md-4">
                                        <strong>Financing Available:</strong>
                                        <span class="ms-2">{{ $property->financing_available ? 'Yes' : 'No' }}</span>
                                    </div>

                                    <div class="col-md-4">
                                        <strong>Price :</strong>
                                        <span class="ms-2 text-dark fw-semibold">AED
                                            {{ number_format($property->price, 2) }}</span>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <!-- Property Details -->
                        <div class="card shadow-sm border-1 mb-4 rounded-4">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-3">Property Details</h5>
                                <hr>
                                <div class="row g-3 text-muted">

                                    <div class="col-md-4"><strong>Type:</strong>
                                        <span
                                            class="ms-2">{{ $property->type == 1 ? 'Residential' : 'Commercial' }}</span>
                                    </div>
                                    <div class="col-md-4"><strong>Sub Type:</strong> <span
                                            class="ms-2">{{ $property->subtype->name ?? 'N/A' }}</span></div>

                                    <div class="col-md-4"><strong>Completion:</strong>
                                        <span class="ms-2">{{ $property->is_complete == 1 ? 'Yes' : 'No' }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Furnished Status:</strong>
                                        <span class="ms-2">{{ $property->is_furnish == 1 ? 'Yes' : 'No' }}</span>
                                    </div>

                                    <div class="col-md-4"><strong>RERA Number:</strong>
                                        <span class="ms-2">{{ $property->rera_number ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-md-6"><strong>Permit Number :</strong>
                                        <span class="ms-2">{{ $property->permit_number ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <style>
                        .seller-review-form i {
                            font-size: 15px;
                            margin-left: -3px;

                        }
                    </style>
                    <!-- Right: Contact Seller / Review Form -->
                    <div class="col-lg-4 seller-review-form">
                        <div class="card shadow-sm border-0 rounded-4 p-4">
                            <h5 class=" mb-3">Contact seller</h5>

                            <!-- Seller Info -->
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <img src="{{ asset('public/img/devotion-trusted-real-estate.png') }}" alt="Devotion Logo"
                                    class="me-3" style="width: 100px; height: 100; object-fit: contain;">
                                <div>

                                    <div>
                                        {{-- <p class="mb-0 fw-semibold">Devotion Estate Agent</p> --}}
                                        <p class="mb-0 fw-semibold">{{ $property->agent->first_name }}</p>
                                        <p class="text-muted small mb-0">
                                            <a href="tel:{{ $property->agent->mobile_no ?? '' }}"
                                                class="text-muted text-decoration-none">
                                                <i class="bi bi-phone" aria-hidden="true"></i>
                                                {{ $property->agent->mobile_no }}
                                            </a>
                                        </p>
                                        <p class="text-muted small">
                                            @if (isset($property->agent))
                                                <a href="mailto:{{ $property->agent->email_id }}"
                                                    class="text-muted text-decoration-none">
                                                    <i class="bi bi-envelope" aria-hidden="true"></i>
                                                    {{ $property->agent->email_id }}
                                                </a>
                                            @else
                                                <span class="text-muted">Agent info not available</span>
                                            @endif

                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Form -->
                            <form action="{{ route('property-contact.store') }}" method="POST">
                                @csrf

                                <input type="hidden" name="property_id" value="{{ $property->unique_id }}">
                                <div class="mb-3">
                                    <input type="text" name="name" class="form-control rounded-3"
                                        placeholder="Full name *" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="mobile_number" class="form-control rounded-3"
                                        placeholder="Phone number *" required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control rounded-3"
                                        placeholder="Email address">
                                </div>
                                <div class="mb-4">
                                    <textarea name="message" rows="4" class="form-control rounded-3" placeholder="Your message *" required></textarea>
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn flex-fill text-white fw-semibold"
                                        style="background-color: #aa8038; border-radius: 30px;">
                                        <i class="bi bi-envelope-fill me-2"></i> Send message
                                    </button>
                                    <a href="tel:+97144488538" class="btn flex-fill fw-semibold"
                                        style="background-color: #fff8ee; border: 1px solid #aa8038; border-radius: 30px; color: #aa8038;">
                                        <i class="bi bi-telephone-fill me-1"></i> Call
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

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
    </script>

@endsection
