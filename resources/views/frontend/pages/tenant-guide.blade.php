@extends('layouts.app')

@section('title', 'Tenant Guide')

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


    <div class="container" style="padding-top: 10px">

        <div class="main-heading">
            <h1 class="text-center mb-5 pt-5 guide-heading">
                How to Rent a Property in Dubai - Tenant Guide
            </h1>
        </div>

        <div class="container content-section">
            <div class="row justify-content-center">
                <div class="col-lg-10 content-container">

                    <p class="text-muted mb-4 description">
                        If you want to rent a property in Dubai and work with competent, experienced agencies, look no
                        further!
                    </p>

                    <p class="text-muted  mb-4 description">
                        DevotionEstate takes delight in putting families into houses and has helped tens of thousands of
                        families throughout the years.
                    </p>

                    <div class="col-12 text-center">
                        <h5 class="highlight-heading mb-3">Guide for Renting Property</h5>
                        <p class="text-muted mb-4 description text-start">
                            Rent property in Dubai with the assistance and supervision of a team that has helped tens of
                            thousands of families find homes since 2008! Follow our step-by-step guide to renting an
                            apartment or villa in Dubai for the first time.
                        </p>
                        <h5 class="sub-heading fw-semibold mb-3">
                            This is a basic step-by-step approach to renting an apartment or villa in Dubai.
                        </h5>
                    </div>

                </div>
            </div>
        </div>


    </div>
    </div>
    <div class="row col-12">
        <div class="col-12 col-lg-8 mx-auto">
            <div class="timeline-container">

                <div class="timeline-step">

                    <div class="timeline-dot"></div>

                    <div class="row">

                        <div class="col-6 d-none d-lg-block"></div>
                        <div class="col-12 col-lg-6 step-text-right ps-lg-4">
                            <h3 class="step-title-color fw-normal">Step 1</h3>
                            <h4 class="mb-3 step-title-color timeline-title">Consider a budget</h4>
                            <p class="desc">
                                The first and most significant stage in Dubai's renting process is to calculate a budget.
                                You can use this budget to start your search.
                            </p>
                            <p class="desc">
                                When determining a rental budget, keep in mind the expenses associated with the rental
                                procedure in Dubai: 5% of the entire rental value will be required for a deposit, and
                                another 5% will be required for agency fees, with a minimum price of AED 5000.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="timeline-step">
                    <div class="timeline-dot"></div>
                    <div class="row">
                        <div class="col-12 col-lg-6 step-text-left pe-lg-4">
                            <h3 class="step-title-color fw-normal">Step 2</h3>
                            <h4 class="mb-3 step-title-color timeline-title">What do you require?</h4>
                            <p class="desc">
                                Consider the necessities you require from your rental house. Are you searching for an
                                apartment or a villa in Dubai? Which area do you prefer? How many bedrooms do you require?
                                Consider the driving distance to the nearest schools or your business.
                            </p>
                            <p class="desc">
                                Prepare to compromise! It is quite rare for a house to tick all of the boxes, so prioritise
                                this list and focus your search to properties that meet your criteria.
                            </p>
                        </div>
                        <div class="col-6 d-none d-lg-block"></div>
                    </div>
                </div>

                <div class="timeline-step">
                    <div class="timeline-dot"></div>
                    <div class="row">
                        <div class="col-6 d-none d-lg-block"></div>
                        <div class="col-12 col-lg-6 step-text-right ps-lg-4">
                            <h3 class="step-title-color fw-normal">Step 3</h3>
                            <h4 class="mb-3 step-title-color timeline-title">Find a trusted broker</h4>
                            <p class="desc">
                                It is critical that you choose a real estate broker in Dubai with whom you can trust and
                                develop both a professional and pleasant relationship. It is critical that you believe you
                                can have an open and honest communication with your broker.
                            </p>
                            <p class="desc">
                                Our brokers are educated to provide exceptional service to our clients, and they genuinely
                                love getting to know you all. At DevotionEstate, we specialise in listening to your
                                requirements and wants and matching you to the correct neighbourhood and property.
                            </p>
                            <p class="desc">
                                Because we handle thousands of leases each year, we have refined our moving procedure into a
                                well-oiled machine that is arranged and planned for you.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="timeline-step">
                    <div class="timeline-dot"></div>
                    <div class="row">
                        <div class="col-12 col-lg-6 step-text-left pe-lg-4">
                            <h3 class="step-title-color fw-normal">Step 4</h3>
                            <h4 class="mb-3 step-title-color timeline-title">Viewings</h4>
                            <p class="desc">
                                The viewing process may often be overwhelming, and it is easy to become overly excited about
                                a house and forget to ask the questions you had in mind before walking through the front
                                door. DevotionEstate recommend that you make a list of potential questions to ask your
                                broker regarding the home you're viewing.
                            </p>
                            <p class="desc">
                                Alternatively, you may detest a property for one or two reasons, but do not rule it out
                                entirely. Express your worries to your broker; they may be able to find a solution, as I am
                                sure they have encountered something similar in the past.
                            </p>
                        </div>
                        <div class="col-6 d-none d-lg-block"></div>
                    </div>
                </div>


                <div class="timeline-step">
                    <div class="timeline-dot"></div>
                    <div class="row">
                        <div class="col-6 d-none d-lg-block"></div>
                        <div class="col-12 col-lg-6 step-text-right ps-lg-4">
                            <h3 class="step-title-color fw-normal">Step 5</h3>
                            <h4 class="mb-3 step-title-color timeline-title">Make an Offer</h4>
                            <p class="desc">
                                Once you've located a property to rent in Dubai, decide what you want to offer. Submit the
                                offer to your broker, who will begin the bargaining process with the landlord. This is the
                                most nerve-racking time, but your DevotionEstate broker has it under control and will keep
                                you up to date on every step.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="timeline-step">
                    <div class="timeline-dot"></div>
                    <div class="row">
                        <div class="col-12 col-lg-6 step-text-left pe-lg-4">
                            <h3 class="step-title-color fw-normal">Step 6</h3>
                            <h4 class="mb-3 step-title-color timeline-title">Administration</h4>
                            <p class="desc">
                                To close the sale, your agent will walk you through the necessary documentation. Make sure
                                to have an Emirates ID, passport, and visa. Take the time to thoroughly review the contract
                                before signing; if you have any questions or concerns, our brokers can help.
                            </p>
                        </div>
                        <div class="col-6 d-none d-lg-block"></div>
                    </div>
                </div>

                <div class="timeline-step">
                    <div class="timeline-dot"></div>
                    <div class="row">
                        <div class="col-6 d-none d-lg-block"></div>
                        <div class="col-12 col-lg-6 step-text-right ps-lg-4">
                            <h3 class="step-title-color fw-normal">Step 7</h3>
                            <h4 class="mb-3 step-title-color timeline-title">Register with Ejari</h4>
                            <p class="desc">
                                It is now time to register your rental agreement in Dubai using EJARI, which translates to
                                'your rent' in Arabic.Your broker will walk you through the procedure and help you with the
                                documentation.DevotionEstate also offers a house relocation service, which will contact you
                                after the contract is signed and inform you of the permits required to proceed.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="timeline-step">
                    <div class="timeline-dot"></div>
                    <div class="row">
                        <div class="col-12 col-lg-6 step-text-left pe-lg-4">
                            <h3 class="step-title-color fw-normal">Step 8</h3>
                            <h4 class="mb-3 step-title-color timeline-title">Connect</h4>
                            <p class="desc">
                                Dubai Electricity and Water Authority (Dewa) will need to be registered in your name, and
                                you should connect your internet before moving in. Our home relocation staff can handle this
                                for you for a modest cost.
                            </p>
                        </div>
                        <div class="col-6 d-none d-lg-block"></div>
                    </div>
                </div>

                <div class="timeline-step">
                    <div class="timeline-dot"></div>
                    <div class="row">
                        <div class="col-6 d-none d-lg-block"></div>
                        <div class="col-12 col-lg-6 step-text-right ps-lg-4">
                            <h3 class="step-title-color fw-normal">Step 9</h3>
                            <h4 class="mb-3 step-title-color timeline-title">Move in day!</h4>
                            <p class="desc">
                                Congratulations! You have successfully rented a house in Dubai! Be aware of changes in
                                policies implemented by the community or building security. Once inside, put your feet up
                                and enjoy your new home!!
                            </p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    </div>
    </div>


@endsection
