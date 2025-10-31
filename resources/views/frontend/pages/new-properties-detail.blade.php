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
        <style>
            .badge-rent,
            .badge-sell {
                background-color: #aa8038 !important;
                color: #fff !important;
                padding: 6px 12px;
                border-radius: 4px;
                font-size: 0.9rem;
            }
        </style>
    </head>

    <div class="container my-5 pt-5">

        <div class="row justify-content-center">
            <div class="col-lg-12">

                <!-- 🔽 Image Gallery Section (Now Below) -->
                <div class="card p-4 shadow-sm  mb-3">
                    <h5 class="fw-semibold mb-3">Gallery</h5>

                    <div class="d-flex align-items-start flex-wrap">
                        <!-- Main Image -->
                        <div class="flex-grow-1 position-relative mb-3 me-3">
                            <img id="mainImage"
                                src="{{ asset('storage/app/propertyImage/' . ($property->single_image->filename ?? 'default.jpg')) }}"
                                class="img-fluid rounded shadow" alt="{{ $property->name }}">
                        </div>

                        <!-- Thumbnails -->
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($property->images as $image)
                                <img src="{{ asset('storage/app/propertyImage/' . ($image->filename ?? 'default.jpg')) }}"
                                    class="img-thumbnail small-thumb" onclick="changeMainImage(this)" alt="Property Image"
                                    style="width: 180px; height: 100px; object-fit: cover; cursor: pointer;">
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

                            <span class="badge {{ $property->purpose == 1 ? 'badge-rent' : 'badge-sell' }}">
                                {{ $property->purpose == 1 ? 'For Rent' : 'For Sell' }}
                            </span>
                        </div>
                        <div class="text-end">
                            <div class="gap-2 pb-3">
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
                                    <div class="col-md-3"><i class="bi bi-door-closed me-1"></i> Beds: {{ $property->beds }}
                                    </div>
                                    <div class="col-md-3"><i class="bi bi-bucket me-1"></i> Baths: {{ $property->baths }}
                                    </div>
                                    <div class="col-md-3"><i class="bi bi-rulers me-1"></i> Area: {{ $property->area }}
                                        Sq.Ft.
                                    </div>
                                    <div class="col-md-3"><i class="bi bi-house"></i>
                                        Type:{{ $property->type == 1 ? 'Commercial' : 'Residential' }}</div>

                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="card mb-5">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-3">Property Description</h5>
                                <p>{{ strip_tags($property->description ?? 'No description available.') }}</p>

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
                                        <span class="ms-2">{{ $property->purpose == 1 ? 'For Rent' : 'For Sell' }}</span>
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
                                    <div class="col-md-4"><strong>ID:</strong> <span
                                            class="ms-2">{{ $property->unique_id }}</span></div>
                                    <div class="col-md-4"><strong>Status:</strong>
                                        <span class="ms-2">{{ $property->purpose == 1 ? 'For Rent' : 'For Sell' }}</span>
                                    </div>
                                    <div class="col-md-4"><strong>Type:</strong>
                                        <span
                                            class="ms-2">{{ $property->type == 1 ? 'Commercial' : 'Residential' }}</span>
                                    </div>
                                    <div class="col-md-4"><strong>Sub Type:</strong> <span
                                            class="ms-2">{{ $property->feature->name ?? 'N/A' }}</span></div>

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
                                    <div class="col-md-4"><strong>Permit Number:</strong>
                                        <span class="ms-2">{{ $property->permit_number ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm border-1 rounded-4 p-4">
                            <h5 class="fw-semibold mb-2">Leave a review</h5>
                            <p class="text-muted small mb-4">
                                Your email address will not be published. Required fields are marked <span
                                    class="text-danger">*</span>
                            </p>

                            <form action="{{ route('review.store') }}" method="POST">
                                @csrf

                                <!-- Hidden Property ID -->
                                <input type="hidden" name="property_id" value="{{ $property->unique_id }}">

                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Your name <span
                                            class="text-danger">*</span></label>
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

                                <!-- Rating -->
                                <div class="mb-4">
                                    <label class="form-label">Rating <span class="text-danger">*</span></label>
                                    <div class="rating">
                                        <i class="bi bi-star" data-value="1"></i>
                                        <i class="bi bi-star" data-value="2"></i>
                                        <i class="bi bi-star" data-value="3"></i>
                                        <i class="bi bi-star" data-value="4"></i>
                                        <i class="bi bi-star" data-value="5"></i>
                                        <input type="hidden" name="rating" id="rating" required>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <button type="submit" class="btn w-100 py-2 fw-semibold text-white"
                                    style="background-color: #aa8038; border-radius: 30px;">
                                    Send review
                                </button>
                            </form>

                        </div>
                    </div>

                    <!-- Right: Contact Seller / Review Form -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 rounded-4 p-4">
                            <h5 class=" mb-3">Contact seller</h5>

                            <!-- Seller Info -->
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <img src="{{ asset('public/img/devotion-trusted-real-estate.png') }}" alt="Devotion Logo"
                                    class="me-3" style="width: 100px; height: 100; object-fit: contain;">
                                <div>
                                    <p class="mb-0 fw-semibold">Devotion Estate Agent</p>
                                    <p class="text-muted small mb-0">(+971) 44488538</p>
                                    <p class="text-muted small">support@devotionestate.com</p>
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
    </script>

@endsection
