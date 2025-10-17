<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



  <title>{{ config('app.name', 'Devotion') }} / @yield('title', 'Page')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
      <link rel="icon" href="public\frontend\assets\images\Devotion Real Estate.png" type="image/x-icon">
    <!-- Styles -->
    <link href="{{ asset('public\frontend\css\custom.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>



<body>
    <div id="app">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 fixed-top">
            <div class="container-fluid px-5">
                <!-- Left: Logo -->
                <a class="navbar-brand" href="index.html">
                    <img src="public\frontend\assets\images\Devotion Real Estate.png" alt="Devotion Logo">
                </a>

                <!-- Toggler for mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Center: Nav Links -->
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="home">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="buy-properties">Buy</a></li>
                        <li class="nav-item"><a class="nav-link" href="rent-properties">Rent</a></li>
                        <li class="nav-item"><a class="nav-link" href="off-plan">Off Plan</a></li>
                        <li class="nav-item"><a class="nav-link" href="luxury-properties">Luxury Properties</a>
                        </li>

                        <!-- Our Services Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#"
                                id="ourServicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Our Services
                                <span class="caret-icon transition">&#9662;</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="ourServicesDropdown" style="min-width: 200px;">
                                <li>
                                    <a class="dropdown-item" href="investment-advisory">Investment
                                        And Advisory</a>
                                    <a class="dropdown-item" href="mortage-advisory">Mortgage
                                        Advisory</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item"><a class="nav-link" href="blog">Blog</a></li>

                        <!-- Explore More Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#"
                                id="exploreMoreDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Explore More
                                <span class="caret-icon transition">&#9662;</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="exploreMoreDropdown">
                                <li class="dropend">
                                    <a class="dropdown-item" href="about-us">About Guide</a>
                                    <a class="dropdown-item" href="buyer-guide">Buyer's Guide</a>
                                    <a class="dropdown-item" href="seller-guide">Seller's Guide</a>
                                    <a class="dropdown-item" href="tenant-guide">Tenant's Guide</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item"><a class="nav-link" href="contact-us">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Right: Icons + Buttons -->
                <div class="d-flex flex-column align-items-start gap-2 top-icons">
                    <!-- Top row -->
                    <div class="d-flex align-items-center gap-3">
                        <span><i class="bi bi-heart-fill"></i> Favourite</span>

                        <div class="dropdown currency-dropdown custom-hover-dropdown">
                            <span>INR ▾</span>
                            <div class="dropdown-menu p-2 currency-menu">
                                <div class="container-fluid p-0">
                                    <div class="row gx-2 mb-2">
                                        <div class="col-4"><button
                                                class="btn btn-outline-secondary btn-currency w-100">د.إ AED</button>
                                        </div>
                                        <div class="col-4"><button
                                                class="btn btn-outline-secondary btn-currency w-100">$ USD</button>
                                        </div>
                                        <div class="col-4"><button class="btn btn-currency w-100">₹ INR</button></div>
                                    </div>
                                    <div class="row gx-2 justify-content-start">
                                        <div class="col-4"><button
                                                class="btn btn-outline-secondary btn-currency w-100">£ GBP</button>
                                        </div>
                                        <div class="col-4"><button class="btn btn-currency w-100">€ EUR</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown currency-dropdown-sq custom-hover-dropdown">
                            <span>Sq.Ft. ▾</span>
                            <div class="dropdown-menu p-2 currency-menu">
                                <div class="container-fluid p-0">
                                    <div class="row gx-2 mb-2">
                                        <div class="col-4"><button
                                                class="btn btn-outline-secondary btn-currency w-100">Sq.Ft.</button>
                                        </div>
                                        <div class="col-4"><button
                                                class="btn btn-outline-secondary btn-currency w-100">Sq.YD.</button>
                                        </div>
                                        <div class="col-4"><button class="btn btn-currency w-100">M.</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="login" class="text-decoration-none text-dark">
                            <span><i class="bi bi-person-circle"></i> Sign In</span>
                        </a>
                    </div>

                    <!-- Bottom row -->
                    <div class="d-flex align-items-center gap-2">
                        <a href="hot-offer" class="btn btn-hot-offer">
                            Hot Offer <i class="bi bi-gift-fill"></i>
                        </a>
                        <a href="login" class="btn btn-list-property">
                            List Your Property <i class="bi bi-house-door"></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="pt-5" >
            @yield('content')
        </main>


        <footer class="text-start py-5" style="background-color: #faf9f6">
            <div class="container">
                <div class="row p-5">

                    <div class="col-lg-3 col-md-6 mb-4 office-address-section">
                        <h5 class="office-heading mb-3">Office Address</h5>
                        <p class="office-subtitle mb-1">Head office:</p>
                        <p class="office-text">
                            Aspect Tower, Bay Avenue - 2801, A Zone, Business Bay, Dubai, UAE
                        </p>

                        <div class="social-icons d-flex mt-3">
                            <a href="https://www.facebook.com/profile.php?id=61560753095894" class="btn-social me-2">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://x.com/devotionestate" class="btn-social me-2">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="https://www.pinterest.com/devotionestate/" class="btn-social me-2">
                                <i class="bi bi-pinterest"></i>
                            </a>
                            <a href="https://www.instagram.com/devotionestate" class="btn-social">
                                <i class="bi bi-instagram"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4 contact-section">
                        <h5 class="contact-heading mb-3">Contact Us</h5>
                        <ul class="list-unstyled contact-list">
                            <li class="d-flex align-items-start mb-2">
                                <i class="bi bi-telephone contact-icon me-2"></i>
                                <div class="contact-info">
                                    <p class="mb-0">Hotline:</p>
                                    <p class="mb-0 contact-text">(+971) 44488538</p>
                                </div>
                            </li>
                            <li class="d-flex align-items-start mt-4">
                                <i class="bi bi-envelope-at contact-icon me-2"></i>
                                <div class="contact-info">
                                    <p class="mb-0">Email:</p>
                                    <a href="mailto:admin@devotionestate.com"
                                        class="contact-link">admin@devotionestate.com</a>
                                </div>
                            </li>
                        </ul>
                    </div>


                    <div class="col-lg-3 col-md-6 mb-4 footer-links">
                        <h5 class="mb-3" style="color: #333;">Our Company</h5>
                        <ul class="list-unstyled">
                            <li><a href="about-us" class="text-decoration-none d-block py-1"><i
                                        class="bi bi-chevron-right me-2" style="font-size: 0.75rem;"></i>About Us</a>
                            </li>
                            <li><a href="contact-us" class="text-decoration-none d-block py-1"><i
                                        class="bi bi-chevron-right me-2" style="font-size: 0.75rem;"></i>Contact
                                    Us</a></li>
                            <li><a href="privacy-policy" class="text-decoration-none d-block py-1"><i
                                        class="bi bi-chevron-right me-2" style="font-size: 0.75rem;"></i>Privacy
                                    Policy</a></li>
                            <li><a href="terms-condition" class="text-decoration-none d-block py-1"><i
                                        class="bi bi-chevron-right me-2" style="font-size: 0.75rem;"></i>Terms
                                    Condition</a></li>
                            <li><a href="login" class="text-decoration-none d-block py-1"><i
                                        class="bi bi-chevron-right me-2" style="font-size: 0.75rem;"></i>Login</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class=" mb-3" style="color: #333;">Newsletter</h5>
                        <p class="mb-3" style="color: #333;">Receive the latest articles</p>
                        <form>
                            <div class="mb-3">
                                <div class="newsletter-form mb-3">
                                    <input type="email" class="form-control newsletter-input"
                                        placeholder="Your email address">
                                </div>

                                <button type="submit" class="btn fw-semibold newsletter-button w-100"
                                    style=" background-color: #a47a46;
                                        color: white;
                                        padding: 12px 15px;
                                        border: none;
                                        border-radius: 4px;
                                        transition: background-color 0.3s ease, transform 0.2s ease;">
                                    Send <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr class="mt-0 mb-3" style="border-color: rgba(0,0,0,0.1);">
                <div class="container text-center">
                    <p class="mb-0" style="color: #333; font-size: 0.9rem;">All rights reserved by Devotion Estate
                        &copy; 2025.
                    </p>

                </div>
        </footer>




    </div>
</body>

</html>
