@extends('layouts.app')

@section('title', 'Contact Us Page')

@section('content')
    <style>
        body {
            background-color: #f8f9fa !important;
            /* light grey */
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

    <div class="container" style="padding-top: 80px;">
        <div class="row justify-content-center g-5 pt-5 align-items-stretch">

            <h1 class="contact-heading text-center">
                Contact Us
            </h1>

            <!-- Contact Info Section -->
            <div class="col-lg-5 d-flex">
                <div class="w-100">
                    <div class="row g-4 h-100">
                        <div class="col-md-6 d-flex">
                            <div class="card contact-card flex-fill p-4 text-center">
                                <div class="icon-box mb-3 d-flex justify-content-center align-items-center">
                                    <i class="bi bi-geo-alt fs-3"></i>
                                </div>
                                <h5 class="card-title">Address</h5>
                                <p class="card-text text-start text-secondary mb-0">
                                    {!! getConfigurationField('OFFICE_ADDRESS') ?? 'Not Available' !!}
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6 d-flex">
                            <div class="card contact-card flex-fill p-4 text-center">
                                <div class="icon-box mb-3 d-flex justify-content-center align-items-center">
                                    <i class="bi bi-telephone fs-3"></i>
                                </div>
                                <h5 class="card-title">Call Us</h5>
                                <p class="card-text text-secondary mb-0">
                                    <a href="tel:{!! getConfigurationField('CONTACT_PHONE') ?? '' !!}" class="text-decoration-none text-secondary">
                                        {!! getConfigurationField('CONTACT_PHONE') ?? 'Not Available' !!}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6 d-flex">
                            <div class="card contact-card flex-fill p-4 text-center">
                                <div class="icon-box mb-3 d-flex justify-content-center align-items-center">
                                    <i class="bi bi-envelope fs-3"></i>
                                </div>
                                <h5 class="card-title">Email Us</h5>
                                @if (getConfigurationField('CONTACT_EMAIL'))
                                    <p class="card-text text-secondary mb-0">
                                        <a href="mailto:{{ getConfigurationField('CONTACT_EMAIL') }}"
                                            class="text-decoration-none text-secondary">
                                            {!! getConfigurationField('CONTACT_EMAIL') !!}
                                        </a>
                                    </p>
                                @else
                                    <p class="card-text text-secondary mb-0">Not Available</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 d-flex">
                            <div class="card contact-card flex-fill p-4 text-center">
                                <div class="icon-box mb-3 d-flex justify-content-center align-items-center">
                                    <i class="bi bi-alarm fs-3"></i>
                                </div>
                                <h5 class="card-title">Open Hours</h5>
                                <p class="card-text text-secondary mb-0">
                                    {!! getConfigurationField('OFFICE_HOURS') ?? 'Not Available' !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <style>
                .custom-alert {
                    background-color: #aa8038 !important;
                    color: #fff !important;
                    border: none !important;
                    font-weight: 300;
                }
            </style> --}}

            <!-- Contact Form Section -->
            <div class="col-lg-5 d-flex">
                <div class="card contact-card p-4 p-md-5 flex-fill d-flex flex-column justify-content-between">
                    <div>
                        <h2 class="mb-4 fw-bold text-center" style="font-size: 1.5rem;">Devotion Estate - Contact Us</h2>

                        @if (session('success'))
                            <div class="alert custom-alert text-center mb-4">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('contact.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label text-muted">Your Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Your Name" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="type" class="form-label text-muted">Property Type</label>
                                    <select class="form-select" id="type" name="type" style="font-size: 0.9rem;"
                                        required>
                                        <option value="" selected>Select Property Type</option>
                                        <option value="1">Residential</option>
                                        <option value="2">Commercial</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="sub_type" class="form-label text-muted">Sub Type</label>
                                    <select class="form-select" id="sub_type" name="sub_type" style="font-size: 0.9rem;"
                                        required>
                                        <option value="">Select Sub Type</option>
                                        @foreach ($propertyTypeObj as $type)
                                            <option value="{{ $type->id }}" data-main="{{ $type->main_type }}"
                                                class="dynamic default-sub-type-hide d-none">
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label text-muted">Your Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Your Email" required>
                            </div>

                            <div class="mb-4">
                                <label for="comment" class="form-label text-muted">Your Message</label>
                                <textarea class="form-control" id="comment" name="comment" rows="5" placeholder="Your Comment" required></textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-custom">
                                    <i class="fas fa-paper-plane me-2"></i>Send Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <style>
        .contact-card {
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #fff;
        }

        .custom-alert {
            background-color: #aa8038 !important;
            color: #fff !important;
            border: none !important;
            font-weight: 300;
        }

        .btn-custom {
            background-color: #aa8038;
            color: #fff;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #8c692d;
        }
    </style>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </div>

    <script>
        $(function() {
            const $type = $('#type');
            const $sub = $('#sub_type');
            const $opts = $sub.find('option.dynamic, .default-sub-type-hide');

            $type.on('change', function() {
                const val = String($(this).val() ?? '').trim();
                $opts.addClass('d-none').prop('disabled', true)
                    .filter(`[data-main="${val}"], .show-${val}`)
                    .removeClass('d-none').prop('disabled', false);
                $sub.val('');
            });

            // Initial check (for edit pages)
            $type.trigger('change');
        });
    </script>
@endsection
