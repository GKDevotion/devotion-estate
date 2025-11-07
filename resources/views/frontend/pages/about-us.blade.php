@extends('layouts.app')

@section('title', 'About Us Page')

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

    <div class="row about-us-section-mtb">
        <div class="main-heading">
            <h1 class="text-center py-3" style="font-weight: 700;">About Us</h1>
        </div>
    </div>

    <div class="container about-us-prl-50" style="max-width:1140px;">

        <div class="row" style="text-align: justify">

            <p class="col-md-12">
                At <strong>Devotion Estate,</strong> we are a team of experienced professionals who are passionate about
                real
                estate. Our expertise spans residential, commercial, and investment properties. Whether you are buying
                your
                first home, looking for a lucrative investment, or seeking the perfect commercial space, we are here to
                guide
                you every step of the way.
            </p>
            <p class="col-md-12 mtc-10">
                With nearly a decade’s experience in the UAE Real Estate market, This outstanding reputation is earned
                and
                attained through consistent hard work and positive outcome for clients via a network of exceptionally
                talented, professional, and multilingual real estate agents.
            </p>
            <p class="col-md-12 mtc-10">
                Our mastery is to get the best rates for every one of the administrations like Document leeway, Business
                arrangement, Accounting and Bookkeeping, Composing and Interpretation administrations, Staff work, and
                Private
                migration purposes in Dubai and all through the UAE. We are generally cognizant of the nature of our
                administration by persistently updating ourselves with the most noteworthy expert principles. That is
                how we
                can convey top-notch proficient support to our clients at a reasonable expense.
            </p>
            <p class="col-md-12 mtc-10">
                The fundamental focal point of our organisation is our clients. We fulfil our client requirements in
                accordance with their exact prerequisites. We would simply prefer not to find lasting success yet we
                wish to
                affect what we deal with our clients.
            </p>


        </div>

        <section class="advertisers-service-sec about-us-prl-50  mtc-10 mbc-10">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center text-color-3 fs-26" style="color: #aa8038 !important;">Why choose us?</h2>
                    </div>
                </div>

                <div class="row mt-5 mt-md-4 justify-content-lg-center justify-content-md-center">

                    <div class="col-12 col-sm-12 col-md-6">

                        <div class="service-card" style="height: 95%">

                            <div class="icon-container">
                                <img src="public\frontend\assets\images\img\goal.png" alt="Mission Target Icon">
                            </div>

                            <div class="text-center mb-3">
                                <h3 class="card-title-custom">Our Mission</h3>
                            </div>

                            <div class="card-body">
                                <p style="text-align: justify">Our objective is to provide innovative services to our
                                    clients by leveraging our
                                    trusted knowledge
                                    to help them find valuable solutions to their real estate needs.</p>
                                <p style="text-align: justify">We understand that consumers are looking for more than just
                                    property to buy; they
                                    want a house to
                                    make memories in, whether for residential or business purposes. Our aim is to find
                                    the ideal
                                    location and make the process as seamless and enjoyable for the customer as
                                    feasible.</p>
                            </div>

                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6">
                        <div class="service-card" style=" height: 95%;">


                            <div class="icon-container">
                                <img src="public\frontend\assets\images\img\insight.png" alt="Vision Eye Icon">
                            </div>

                            <div class="text-center mb-3">
                                <h3 class="card-title-custom">Our Vision</h3>
                            </div>

                            <div class="card-body">
                                <p style="text-align: justify">Our objective is to establish DevotionEstate Properties as
                                    the leading real estate
                                    firm in Dubai,
                                    known for our ethics, professionalism, and reputation.</p>
                                <p style="text-align: justify">Above all else, our team values and trusts connections. We
                                    intend to continue
                                    expanding the company
                                    into innovative sectors to fulfill our clients' needs.</p>
                            </div>
                        </div>
                    </div>

                </div>

        </section>

    </div>


@endsection
