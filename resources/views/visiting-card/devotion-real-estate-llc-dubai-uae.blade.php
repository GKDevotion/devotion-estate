<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$details->name.' - '.$details->position}}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        /* Basic Styling */
        body {
            background-color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #000000;
        }

        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }

        .profile-img {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            background-color: #ffffff;
            margin-top: -50px;
        }

        .section-heading {
            color: #aa8038 ;
        }

        .card-custom {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            background-color: #ffffff;
        }

        .social-link {
            background: #ffffff;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            border-radius: 10px;
            margin-bottom: 10px;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #000000;
            transition: background 0.3s;
        }

        .social-link:hover {
            background: #f8f9fa;
        }

        .social-icon {
            width: 30px;
            height: 30px;
            margin-right: 15px;
        }

        /* Floating Buttons */
        .floating-btn {
            position: fixed;
            bottom: 20px;
            z-index: 999;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            background-color: #aa8038 ;
            color: white;
            font-size: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .floating-btn-left {
            left: 20px;
        }

        .floating-btn-right {
            right: 20px;
            width: auto;
            border-radius: 25px;
            padding: 0 15px;
            font-size: 16px;
            height: 50px;
        }

        /* Fullscreen Modal */
        .modal-fullscreen-custom {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .modal-content {
            background-color: #ffffff;
            height: 100%;
            border: none;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
        }

        .text-decoration-none{
            text-decoration: none !important;
        }
    </style>
</head>

<body>

    <!-- QR Code Modal -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-custom">
            <div class="modal-content">

                <!-- Modal Close Button -->
                <button type="button" class="top-0 m-3 btn btn-danger rounded-circle position-absolute start-0"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>

                <!-- Modal Logo and Profile Info -->
                <img src="{{url( 'storage/'.$companyObj->logo )}}" class="logo" alt="{{$companyObj->name}} {{$details->name}}">
                <img src="{{url('storage/'.$details->avtar)}}" class="mt-2 mb-2 profile-img" alt="{{$details->name}}">

                <!-- Name and Title -->
                <h4 class="mt-3 fw-bold">{{$details->name}}</h4>
                <p class="mb-0 text-muted"><em>{{$details->position}}</em></p>
                <p class="text-muted small">{{$companyObj->name}}</p>

                <!-- QR Code -->
                <img src="{{url('storage/app/QR/'.$details->email.'.png')}}"
                    class="my-4 img-fluid" style="max-width:250px;" alt="QR Code">

                <!-- Wallet Buttons -->
                <h6 class="fw-bold">Add your Digital Business Card to Wallet</h6>
                <div class="mb-3 d-flex justify-content-center">
                    <a href="#" class="mx-2 btn btn-dark d-flex align-items-center"
                        onclick="alert('Google Wallet integration coming soon!')">
                        <i class="fab fa-google-wallet me-2"></i> Google Wallet
                    </a>
                    <a href="#" class="mx-2 btn btn-dark d-flex align-items-center"
                        onclick="alert('Apple Wallet integration coming soon!')">
                        <i class="fab fa-apple me-2"></i> Apple Wallet
                    </a>
                </div>

                <!-- Modal Extra Options -->
                <div class="container mb-3">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-mobile-alt me-3"></i> Add to Home Screen
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-images me-3"></i> Add to Gallery
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="container py-5 text-center">

        <!-- Main Logo -->
        <img src="{{url( 'storage/'.$companyObj->logo )}}" class="logo" alt="{{$companyObj->name}} {{$details->name}}">

        <!-- Profile Image -->
        <div class="d-flex justify-content-center">
            <img src="{{url('storage/'.$details->avtar)}}" class="mt-1 profile-img">
        </div>

        <!-- Profile Info -->
        <h4 class="mt-3 fw-bold section-heading">{{$details->name}}</h4>
        <p class="mb-1 text-muted">{{$details->position}}</p>
        <p class="text-muted small">{{$companyObj->name}}</p>

        <!-- Call and Email Buttons -->
        <div class="gap-3 mt-2 d-flex justify-content-center">
            <a href="tel:{{$details->mobile_number}}" class="btn btn-outline-dark rounded-circle"><i class="fas fa-phone"></i></a>
            <a href="mailto:{{$details->email}}" class="btn btn-outline-dark rounded-circle"><i class="fas fa-envelope"></i></a>
        </div>

    </div>

    <!-- About Section -->
    <div class="container mb-4">
        <div class="p-4 card-custom">
            <h5 class="mb-3 text-center fw-bold section-heading">About Company</h5>
            <p class="text-center small">
                At Devotion Estate, we are a team of experienced professionals who are passionate about real estate. Our expertise spans residential, commercial, and investment properties. Whether you are buying your first home, looking for a lucrative investment, or seeking the perfect commercial space, we are here to guide you every step of the way.
            </p>
            <p class="text-center small">
                With nearly a decade's experience in the UAE Real Estate market, This outstanding reputation is earned and attained through consistent hard work and positive outcome for clients via a network of exceptionally talented, professional, and multilingual real estate agents.
            </p>
            <p class="text-center small">
                Our mastery is to get the best rates for every one of the administrations like Document leeway, Business arrangement, Accounting and Bookkeeping, Composing and Interpretation administrations, Staff work, and Private migration purposes in Dubai and all through the UAE. We are generally cognizant of the nature of our administration by persistently updating ourselves with the most noteworthy expert principles. That is how we can convey top-notch proficient support to our clients at a reasonable expense.
            </p>
            <p class="text-center small">
                The fundamental focal point of our organisation is our clients. We fulfil our client requirements in accordance with their exact prerequisites. We would simply prefer not to find lasting success yet we wish to affect what we deal with our clients.
            </p>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="container mb-4">
        <div class="p-4 card-custom">
            <h5 class="mb-3 text-center fw-bold section-heading">Contact Us</h5>
            @if( $details->mobile_number != "")
                <p>
                    <i class="fa fa-mobile me-2"></i>
                    <a href="tel:{{$details->mobile_number}}" class="text-decoration-none text-dark">{{$details->mobile_number}}</a>
                </p>
            @endif

            @if( $details->office_number != "")
                <p>
                    <i class="fa fa-phone me-2"></i>
                    <a href="tel:{{$details->office_number}}" class="text-decoration-none text-dark">{{$details->office_number}}</a>
                </p>
            @endif

            @if( $details->email != "" )
                <p>
                    <i class="fas fa-envelope me-2"></i>
                    <a href="mailto:{{$details->email}}" class="text-decoration-none text-dark">{{$details->email}}</a>
                </p>
            @endif

            @if( $details->office_address_1 != "" )
                <p>
                    <i class="fas fa-map-marker-alt me-2"></i>
                    {{$details->office_address_1}}
                </p>
            @endif

            @if( $details->office_address_2 != "" )
                <p>
                    <i class="fas fa-map-marker-alt me-2"></i>
                    {{$details->office_address_2}}
                </p>
            @endif
        </div>
    </div>

    <!-- Social Links Section -->
    <div class="container mb-5">
        <div class="p-4 card-custom">
            <h5 class="mb-3 text-center fw-bold section-heading">Social Links</h5>

            <!-- Facebook -->
            @if( $details->facebook != "")
                <a href="{{$details->facebook}}" target="_blank" class="social-link">
                    <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" class="social-icon"> Facebook
                </a>
            @endif

            <!-- Instagram -->
            @if( $details->instagram != "")
                <a href="{{$details->instagram}}" target="_blank" class="social-link">
                    <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" class="social-icon"> Instagram
                </a>
            @endif

            <!-- Twitter -->
            @if( $details->twitter != "")
                <a href="{{$details->twitter}}" target="_blank" class="social-link">
                    <img src="https://cdn.simpleicons.org/x/000000" class="social-icon"> Twitter
                </a>
            @endif

            <!-- LinkedIn -->
            @if( $details->linkedin != "")
                <a href="{{$details->linkedin}}" target="_blank" class="social-link">
                    <img src="https://cdn-icons-png.flaticon.com/512/145/145807.png" class="social-icon"> LinkedIn
                </a>
            @endif

            <!-- Pinterest -->
            @if( $details->pinterest != "")
                <a href="{{$details->pinterest}}" target="_blank" class="social-link">
                    <img src="https://cdn-icons-png.flaticon.com/128/145/145808.png" class="social-icon"> Pinterest
                </a>
            @endif

            <!-- tiktok -->
            @if( $details->tiktok != "")
                <a href="{{$details->tiktok}}" target="_blank" class="social-link">
                    <img src="https://cdn-icons-png.flaticon.com/512/145/145807.png" class="social-icon"> Tiktok
                </a>
            @endif

            <!-- quora -->
            @if( $details->quora != "")
                <a href="{{$details->quora}}" target="_blank" class="social-link">
                    <img src="https://cdn-icons-png.flaticon.com/512/174/174865.png" class="social-icon"> Quora
                </a>
            @endif

            <!-- youtube -->
            @if( $details->youtube != "")
                <a href="{{$details->youtube}}" target="_blank" class="social-link">
                    <img src="https://cdn-icons-png.flaticon.com/512/145/145807.png" class="social-icon"> Youtube
                </a>
            @endif

            <!-- Whats App -->
            @if( $details->email == "ashish@zedcapital.mu")
                <a href="https://wa.me/message/RFMMGNOR7KZTK1" target="_blank" class="social-link">
                    <img src="https://cdn.simpleicons.org/whatsapp/25D366" class="social-icon"> Whats App
                </a>
            @endif

            <!-- Website -->
            <a href="{{$companyObj->website_link}}" target="_blank" class="social-link">
                <img src="https://icon-library.com/images/globe-icon-free/globe-icon-free-0.jpg" class="social-icon"> Our Website
            </a>

        </div>
    </div>

    <!-- Floating Buttons -->
    <button class="floating-btn floating-btn-left" data-bs-toggle="modal" data-bs-target="#qrModal">
        <i class="fas fa-qrcode"></i>
    </button>

    <a class="floating-btn floating-btn-right text-decoration-none" href="{{url('download-contact/'.$details->id)}}">
        <i class="fas fa-user-plus"></i> Add to Contact
    </a>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
