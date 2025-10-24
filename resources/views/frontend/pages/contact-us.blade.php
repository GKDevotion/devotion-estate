@extends('layouts.app')

@section('title', 'Contact Us Page')

@section('content')
<style>
  body {
    background-color: #f8f9fa !important; /* light grey */
  }
</style>
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

    <div class="row justify-content-center g-5 pt-5"> <!-- Added gap with g-5 -->
      <!-- Contact Info Section -->
      <div class="col-lg-5">
        <div class="row g-4 pt-5">
          <div class="col-md-6 d-flex">
            <div class="card contact-card flex-fill p-4" style="min-height: 220px;">
              <div class="icon-box mb-3 d-flex justify-content-center align-items-center">
                <i class="bi bi-geo-alt fs-3"></i>
              </div>
              <h5 class="card-title text-center">Address</h5>
              <p class="card-text text-secondary">
                Aspect Tower, Bay Avenue - 2901, A Zone, Business Bay, Dubai, UAE.
              </p>
            </div>
          </div>

          <div class="col-md-6 d-flex">
            <div class="card contact-card flex-fill p-4" style="min-height: 220px;"> <!-- Increased height -->
              <div class="icon-box mb-3 d-flex justify-content-center align-items-center">
                <i class="bi bi-telephone fs-3"></i> <!-- Increased icon size -->
              </div>
              <h5 class="card-title text-center ">Call Us</h5> <!-- Center title -->
              <p class="card-text text-secondary text-center">
                (+971) 44488538
              </p>
            </div>

          </div>

          <div class="col-md-6 d-flex">
            <div class="card contact-card flex-fill p-4" style="min-height: 220px;">
              <div class="icon-box mb-3 d-flex justify-content-center align-items-center">
                <i class="bi bi-envelope fs-3"></i>
              </div>
              <h5 class="card-title text-center">Email Us</h5>
              <p class="card-text text-secondary">
                admin@devotionestate.com
              </p>
            </div>
          </div>

          <div class="col-md-6 d-flex">
            <div class="card contact-card flex-fill p-4" style="min-height: 220px;">
              <div class="icon-box mb-3 d-flex justify-content-center align-items-center">
                <i class="bi bi-alarm fs-3"></i>
              </div>
              <h5 class="card-title text-center">Open Hours</h5>
              <p class="card-text text-secondary">
                Monday - Friday<br>9:00AM - 5:00PM
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Form Section -->
      <div class="col-lg-5">
        <div class="card contact-card p-4 p-md-5">
          <h2 class="mb-4 fw-bold text-center" style="font-size: 1.5rem;">Devotion Estate - Contact-Us</h2>

          <form>
            <div class="mb-3">
              <label for="yourName" class="form-label text-muted">Your name</label>
              <input type="text" class="form-control" id="yourName" placeholder="Your name">
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="propertyType" class="form-label text-muted">Property type</label>
                <select class="form-select" id="propertyType" style="font-size: 0.9rem;">
                  <option selected>Select Property Type</option>
                  <option value="1">Residential</option>
                  <option value="2">Commercial</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="subType" class="form-label text-muted">Sub type</label>
                <select class="form-select" id="subType" style="font-size: 0.9rem;">
                  <option selected>Select Property Sub Type</option>
                  <option value="1">...</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label for="yourEmail" class="form-label text-muted">Your Email</label>
              <input type="email" class="form-control" id="yourEmail" placeholder="Your Email">
            </div>

            <div class="mb-4">
              <label for="yourMessage" class="form-label text-muted">Your Message</label>
              <textarea class="form-control" id="yourMessage" rows="5" placeholder="Your message"></textarea>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-custom">
                <i class="fas fa-paper-plane me-2"></i>Send request
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>



@endsection
