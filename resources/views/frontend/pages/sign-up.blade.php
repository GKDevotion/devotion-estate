@extends('layouts.app')

@section('title', 'Sign Up')

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

   
<div class="container my-5" style="padding-top: 80px; ">

        <div class="signup-card mx-auto row g-0" style="max-width: 700px;">
            <!-- Form Column -->
            <div class="col-lg-6 col-md-12 form-column">
                <div class="p-4 text-center">
                    <!-- Logo -->
                    <a href="#">
                        <img src="public\frontend\assets\images\Devotion Real Estate.png" alt="Devotion Logo" class="img-fluid mb-3"
                            style="max-height: 80px;">
                    </a>
                    <h3 class="mb-4 fs-5">Sign In</h3>

                    <!-- Form -->
                    <form>
                        <div class="mb-3">
                            <label for="emailInput" class="form-label fw-bold">Email Address</label>
                            <input type="email" class="form-control" id="emailInput"
                                placeholder="Enter Your Email Address" required>
                        </div>
                        <div class="mb-4">
                            <label for="passwordInput" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control" id="passwordInput"
                                placeholder="Enter Your Password" required>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-sign-in">Sign In</button>
                        </div>
                    </form>

                    <p>Don't have an account yet? <a href="#" class="fw-bold" style="color: #d4a761;">Sign Up</a></p>
                </div>
            </div>

            <!-- Image Column -->
            <div class="col-lg-6 d-none d-lg-block image-column"></div>
        </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</div>


@endsection
