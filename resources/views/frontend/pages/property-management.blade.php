@extends('layouts.app')

@section('title', 'Propoerty Management')

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

    <section id="advertisers" class="service-sec about-us-prl-50  mtc-10 mbc-10">
        <div class="container">
            <div class="row mb-4" style="padding-top: 100px">
                <div class="col-12 text-center">
                    <h2 class="text-brown " style="color: #aa8038; font-weight: 700; ">
                        Explore the best property management companies in the UAE
                    </h2>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 investment-section">
                    <h5 class="investment-heading">
                        What is property management?
                    </h5>
                    <p class="investment-text">
                        Property management is a service that owners can use to alleviate the stress and hassles associated
                        with managing their property. A Property Management team acts as a go-between for an owner and a
                        tenant, looking
                        after the owner's investment and ensuring that all regulatory requirements are met, such as
                        scheduling condition reports, rental
                        cheques, maintenance management, and ensuring that tenants receive proper notices.
                    </p>

                    <p class="investment-text">
                        <a href="" style="color: #aa8038;">DevotionEstate</a> administers the UAE's largest portfolio
                        of residential and commercial properties, with over 8,500 units and 65 buildings under
                        administration.
                    </p>

                    <p class="investment-text">
                        We provide a full solution that includes property marketing, tenant screening, rent collecting, and
                        maintenance, as well as guaranteeing you receive the best market rate.
                    </p>
                </div>

            </div>

            <div class="row mt-5 mt-md-4 justify-content-lg-center justify-content-md-center">

                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="service-card ">

                        <div>
                            <img src="public\frontend\assets\images\img\accountant.jpg" class="card-image-top"
                                alt="Dedicated Account Manager">
                        </div>

                        <h3 class="text-center">Dedicated Account Manager</h3>

                        <div class="card-body-investment">

                            <p class="card-text text-secondary">
                                Our specialized account manager service offers a single point of contact for all of
                                your property requirements. Contact us now to simplify your property management
                                experience.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="service-card">

                        <div>
                            <img src="public\frontend\assets\images\img\Tenant-Management.jpg" class="card-image-top"
                                alt="Tenant Management">
                        </div>

                        <h3 class="text-center">Tenant Management</h3>

                        <div class="card-body-investment">

                            <p class="card-text text-secondary">
                                Allow us to take care of your tenant management needs. We will manage everything
                                from tenant communication to rent collection, ensuring that the renting process is
                                easy and effective.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="service-card">

                        <div>
                            <img src="public\frontend\assets\images\img\Legal-Guidance.jpg" class="card-image-top"
                                alt="Legal Guidance">
                        </div>

                        <h3 class="text-center">Legal Guidance</h3>

                        <div class="card-body-investment">

                            <p class="card-text text-secondary">
                                Navigating property laws can be challenging. Our legal assistance service offers you
                                competent counsel to ensure compliance and preserve your investments.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="service-card">
                        <div>
                            <img src="public\frontend\assets\images\img\Smart-Portal-Integration.jpg" class="card-image-top"
                                alt="Smart Portal Integration">
                        </div>

                        <h3 class="text-center">Smart Portal Integration</h3>

                        <div class="card-body-investment">

                            <p class="card-text text-secondary">
                                Our smart portal integration ensures a flawless property management experience. It
                                enables you to monitor rent payments, maintenance requests, and more from any
                                device.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="service-card">
                        <div>
                            <img src="public\frontend\assets\images\img\Maintenance-And-Complaints-Resolution.jpg" class="card-image-top"
                                alt="Maintenance and Complaints Resolution">
                        </div>

                        <h3 class="text-center">Maintenance and Complaints Resolution</h3>

                        <div class="card-body-investment">

                            <p class="card-text text-secondary">
                                We immediately address maintenance issues, resolve tenant concerns, and ensure your
                                tenants' satisfaction. Contact us for trustworthy property maintenance.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="service-card">
                        <div>
                            <img src="public\frontend\assets\images\img\Regular-Inspection.jpg"
                                class="card-image-top" alt="Regular Inspection">
                        </div>

                        <h3 class="text-center">Regular Inspection</h3>

                        <div class="card-body-investment">

                            <p class="card-text text-secondary">
                                Our inspection service contributes to the long-term value of your property by
                                identifying and addressing problems early. Schedule your inspection today to
                                guarantee everything remains in peak condition!
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="service-card">

                        <div>
                            <img src="public\frontend\assets\images\img\Facilities-Management-Supervision.jpg"
                                class="card-image-top" alt="Facilities Management Supervision">
                        </div>

                        <h3 class="text-center">Facilities Management Supervision</h3>

                        <div class="card-body-investment">

                            <p class="card-text text-secondary">
                                Facility supervision is the activity of overseeing facility management
                                responsibilities to ensure that a facility runs smoothly and efficiently. A facility
                                supervisor's responsibilities include assigning facility management chores,
                                monitoring progress, and evaluating quality results.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="service-card">
                        <div>
                            <img src="public\frontend\assets\images\img\soft-service-person.jpg"
                                class="card-image-top" alt="Soft Services Supervision">
                        </div>

                        <h3 class="text-center">Soft Services Supervision</h3>

                        <div class="card-body-investment">

                            <p class="card-text text-secondary">
                                Soft facilities in facility management are services that make a facility a pleasant
                                place to be for tenants. Soft services may include efforts you take to make the area
                                more secure, cleaner, and efficient
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="service-card">

                        <div>
                            <img src="public\frontend\assets\images\img\MEP-Services-Supervision.jpg"
                                class="card-image-top" alt="MEP Services Supervision">
                        </div>

                        <h3 class="text-center">MEP Services Supervision</h3>

                        <div class="card-body-investment">

                            <p class="card-text text-secondary">
                                Devotion estate employs a team of MEP specialists who understand the intricacies of
                                running an efficient MEP system. We use the knowledge and resources at our disposal
                                to expedite MEP supervisory tasks.
                            </p>
                        </div>
                    </div>
                </div>

                <style>
                    /* new style add */
                    .card-img-top-container {
                        width: 100%;
                        padding: 20px;
                        height: 320px;
                        /* ✅ Set a fixed height for all images */
                        overflow: hidden;
                        border-top-left-radius: 0.5rem;
                        border-top-right-radius: 0.5rem;
                    }

                    .card-img-top-container img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        /* ✅ Ensures consistent cropping and alignment */
                        object-position: center;
                    }

                    #ForDesktop {
                        display: block;
                    }

                    .imageover-text {
                        height: 80vh;
                        width: 100%;
                    }

                    .first-block {
                        position: absolute;
                        bottom: 8px;
                        left: 16px;
                        width: 500px;
                    }

                    .second-block {
                        position: absolute;
                        top: 25px;
                        right: 16px;
                        width: 500px;
                    }

                    .third-block {
                        position: absolute;
                        top: 25px;
                        left: 16px;
                        width: 500px;
                    }

                    .fourth-block {
                        position: absolute;
                        bottom: 8px;
                        right: 16px;
                        width: 500px;
                    }

                    .fifth-block {
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                    }
                </style>

                <h5 class="text-start mb-3" style="color: #aa8038; font-size: x-large;">What makes us different?</h5>

                <div id="ForDesktop" style="position: relative; text-align: center;">
                    <img src="public\frontend\assets\images\img\centerright.png" alt="Snow"
                        class="imageover-text">
                    <div class="first-block">
                        <h5 class="text-center">Energy Saving Solutions</h5>
                        <p>
                            We provide a comprehensive range of energy-efficient solutions that focus on the most
                            important aspects of a building, such as HVAC, controls and automation, lighting, pumps and
                            motors.
                            Our ultimate goal is to drive down costs, reduce environmental impact, and suit the unique
                            needs of our clients.
                        </p>
                    </div>
                    <div class="second-block">
                        <h5 class="text-center">CRM & Use of Technology</h5>
                        <p>
                            We employ cutting-edge Client Relationship administration software to manage all elements of
                            the asset,
                            whether for leasing, marketing, booking, documenting repair requests, or even financial
                            administration.
                        </p>
                    </div>
                    <div class="third-block">
                        <h5 class="text-center">Owners & Tenants Portal</h5>
                        <p>
                            We provide our clients with an online platform and mobile apps, which allow owners to view
                            reports on demand and renters to lodge maintenance requests through their own site.
                        </p>
                    </div>
                    <div class="fourth-block">
                        <h5 class="text-center">Monthly Reports</h5>
                        <p>
                            We provide monthly reports that highlight preventive maintenance efforts, corrective work
                            orders, and ongoing and finished tasks.
                            In addition, the report includes financial data on material and labor expenditures, as well
                            as monthly invoicing.
                        </p>
                    </div>
                    <div class="fifth-block">
                        <h5 class="text-center">FM Supervision</h5>
                        <p>
                            We manage facility operations, corrective and preventive maintenance for residential,
                            commercial, and industrial facilities.
                            Our facility management team has the knowledge, talent, processes, and technologies to
                            ensure facility management meets worldwide standards.
                        </p>
                    </div>
                </div>

            </div>


            <div class="row mt-5">

                <div class="col-12 text-center">
                    <h5 class="text-start mb-3" style="color: #aa8038; font-size: x-large; ">Benefits of
                        Using a Property Management Company</h5>
                </div>

                <div class="row mt-5 mt-md-4 justify-content-lg-center justify-content-md-center">

                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">
                        <div class="service-card">


                            <h5 class="text-center">Tenants Screening</h5>
                            <p class="text-justify">
                                Land Sterling provides tenant screening services to help you find the suitable tenants for
                                your property. Having tenants that are likely to cause problems for you in the future might
                                be highly detrimental. Land Sterling has a thorough screening process that every renter must
                                go through before they can receive your house to rent.
                            </p>
                        </div>

                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">
                        <div class="service-card">

                            <h5 class="text-center">Rentals Marketing</h5>
                            <p class="text-justify">
                                Our property managers are skilled at marketing the property. We develop excellent rental
                                marketing techniques to help fill the space much faster.
                                We employ local market research to establish a competitive price for rent while keeping
                                your profit margins in mind.
                            </p>
                        </div>

                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">

                        <div class="service-card">


                            <h5 class="card-title text-center">Increased Occupancy Rates</h5>
                            <p class="card-text text-secondary">
                                The purpose of our property consultation services is to increase the occupancy rates of
                                your property. We accomplish this through effective rental marketing and property
                                management. We supervise everything from tenant agreements to facilities and MEP systems in
                                a building to enhance efficiency.
                            </p>
                        </div>

                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">

                        <div class="service-card">

                            <h5 class="card-title text-center">Rent Collection</h5>
                            <p class="card-text text-secondary">
                                Rent collecting is a difficult endeavor that can frequently become very difficult. We
                                implemented procedures to assure consistent rent collections throughout time.
                                And if a renter can't seem to pay the rent on time, our managers handle the problem on
                                your behalf.
                            </p>
                        </div>

                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">

                        <div class="service-card">


                            <h5 class="card-title text-center">Peace of Mind</h5>
                            <p class="card-text text-secondary">
                                Our real estate management services are designed to provide you with a more convenient
                                approach to manage your property. We decrease your real estate management problems by taking
                                over the management and oversight activities on your behalf.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>

@endsection
