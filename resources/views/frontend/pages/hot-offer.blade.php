@extends('layouts.app')

@section('title', 'Hot Offer')

@section('content')

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

        <link href="{{ asset('public\frontend\css\custom.css') }}" rel="stylesheet">
    </head>


    <div class="container my-5">

        @include('frontend.layouts.partials.property-search', ['type' => 'hot'])

        <!-- Header -->

        <div class="row align-items-center mb-3">
            <div class="col-md-8 properties-header">
                <h1 class="properties-title">Hot Offer Properties in Dubai</h1>
                <p class="properties-count">
                    There are currently <span>{{ $total }}</span> properties.
                </p>
            </div>

            <div class="col-md-4 text-md-end">
                <form method="GET" action="{{ route('hot-offer') }}">
                    <label for="showProps" class="form-label small">Show Property(s) Per Page:</label>
                    <div class="col-12 d-flex justify-content-end">
                        <select name="perPage" id="showProps" class="form-select form-select-sm w-50"
                            onchange="this.form.submit()">
                            <option value="2" {{ $perPage == 2 ? 'selected' : '' }}>2</option>
                            <option value="4" {{ $perPage == 4 ? 'selected' : '' }}>4</option>
                            <option value="6" {{ $perPage == 6 ? 'selected' : '' }}>6</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Property Cards Container -->
        <div class="row">
            @forelse($properties as $p)
                <div class="col-md-12 mb-4">
                    <a href="{{ route('property.detail', $p->slug) }}" class="text-decoration-none text-dark">
                        <div class="card p-3 shadow-sm border-0 h-100">
                            <div class="row g-0">

                                <div class="col-lg-4 d-flex">
                                    <img src="{{ asset('storage/app/propertyImage/' . ($p->single_image->filename ?? 'devotion-trusted-real-estate.png')) }}"
                                        class="img-fluid rounded-start property-img flex-grow-1" alt="Property Image">
                                </div>
                                <style>
                                    .property-img {
                                        width: 100%;
                                        height: 270px;
                                        object-fit: fill;
                                        object-position: center;
                                        border-radius: 8px;
                                    }
                                </style>
                                <div class="col-lg-8">
                                    <div class="card-body">
                                        <div class="row align-items-start">

                                            <div class="col-8">
                                                <h5 class="fw-bold">{!! $p->name !!}</h5>
                                                <p class="text-muted mb-1" style="font-size: 0.85rem;">
                                                    <i class="bi bi-map me-1"></i>
                                                    {{ $p->location->name ?? 'Unknown Location' }}
                                                </p>
                                                <h4 class="fw-bold mt-4 fs-20" style=" color:#aa8038;">
                                                    AED {{ number_format($p->price, 2) }}
                                                </h4>


                                                <div class="d-flex flex-column align-items-start">

                                                    @if ($p->type != 2)
                                                        <div class="mb-2">
                                                            <i class="bi bi-door-closed me-1"></i>
                                                            <span class="small">Beds : {{ $p->beds }}</span>
                                                        </div>
                                                    @endif

                                                    @if ($p->type != 2)
                                                        <div class="mb-2">
                                                            <i class="bi bi-bucket me-1"></i>
                                                            <span class="small">Baths : {{ $p->baths }}</span>
                                                        </div>
                                                    @endif

                                                    @if ($p->type == 2)
                                                        <div class="mb-2">
                                                            <i class="bi bi-bookmark me-1"></i>
                                                            <span class="small">Sub Type : {{ $p->subType->name }}</span>
                                                        </div>
                                                    @endif

                                                    <div class="mb-2">
                                                        <i class="bi bi-rulers me-1"></i>
                                                        <span class="small">Area : {{ $p->area }} Sq.Ft.</span>
                                                    </div>

                                                    <div class="d-flex gap-2 d-none">
                                                        <button class="btn btn-sm"
                                                            style="background-color: #aa8038; color: white;">
                                                            <i class="bi bi-compass"></i>
                                                        </button>
                                                        <button class="btn btn-sm"
                                                            style="background-color: #aa8038; color: white;">
                                                            <i class="bi bi-heart"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 text-end">
                                                <img src="{{ url('public\img\devotion-group-favicon-64X64.png') }}"
                                                    alt="Estate Agent Logo" class="img-fluid" style="max-width: 160px;">
                                                <p class="small text-muted text-end mt-2 mb-0">Devotion Estate </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No properties found.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $properties->appends(['perPage' => $perPage])->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection
