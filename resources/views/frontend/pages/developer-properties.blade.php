@extends('layouts.app')

@section('title', 'Developer Properties')

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

    <section style="padding-top: 100px">
        <div class="container">
            <div class="card border-0 shadow-sm rounded-4">
                <!-- Header -->
                <div class="card-header bg-white border-bottom py-4 px-4">
                    <h4 class="mb-0 fw-semibold" style="color: #aa8038">
                        About {{ $developerObj['name'] }} Developer
                    </h4>
                </div>

                <!-- Body -->
                <div class="card-body px-4 py-4">
                    @if (!empty($developerObj['description']))
                        <div class="text-muted lh-lg">
                            {!! $developerObj['description'] !!}
                        </div>
                    @else
                        <div class="text-muted fst-italic">
                            Description will be updated soon.
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>


    <div class="container  my-5">
        <!-- Filters and Search Section -->
        {{-- @include('frontend.layouts.partials.property-search', ['type' => 'new']) --}}

        <!-- Header -->
        <div class="row align-items-center mb-3">
            <div class="col-md-8 properties-header">
                @if (isset($developerObj))
                    <h1 class="properties-title">
                        {{ $developerObj->name }} Properties in Dubai, UAE
                    </h1>
                @endif

                <p class="properties-count">
                    There are currently <span>{{ $total }}</span> properties.
                </p>
            </div>

            <div class="col-md-4 text-md-end">
                <form method="GET" action="{{ route('developer.properties', $developerId) }}">
                    <label for="showProps" class="form-label small">Show Property(s) Per Page:</label>
                    <div class="col-12 d-flex justify-content-end">
                        <select name="perPage" id="showProps" class="form-select form-select-sm w-50"
                            onchange="this.form.submit()">
                            <option value="6" {{ $perPage == 6 ? 'selected' : '' }}>6</option>
                            <option value="12" {{ $perPage == 12 ? 'selected' : '' }}>12</option>
                            <option value="24" {{ $perPage == 24 ? 'selected' : '' }}>24</option>
                            <option value="36" {{ $perPage == 36 ? 'selected' : '' }}>36</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Property Cards Container -->
        <div class="row">
            @forelse($properties as $p)
                <!-- ONE CARD COLUMN -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ route('property.detail', $p->slug) }}" class="text-decoration-none text-dark d-block h-100">

                        <div class="card property-card h-100 border-1 shadow-sm rounded-3">

                            <div class="position-relative">
                                <img src="{{ asset('storage/app/propertyImage/' . ($p->single_image->filename ?? 'devotion-trusted-real-estate.png')) }}"
                                    class="card-img-top rounded-top-3" alt="{{ $p->name }}">
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">

                                <div class="d-flex align-items-start mb-2">
                                    <h5 class="card-title mb-0 me-3" style="min-height: 50px">
                                        {!! $p->name !!}
                                    </h5>
                                </div>

                                <!-- Location -->
                                <p class="card-text small text-muted mb-1">
                                    <i class="bi bi-map me-2"></i>
                                    {{ ucfirst($p->location->name ?? 'N/A') }}
                                </p>

                                <!-- Property Details -->
                                <p class="card-text small mb-0">
                                    @if ($p->type != 2)
                                        <i class="bi bi-door-closed me-1"></i>
                                        Beds: {{ $p->beds == 0 ? 'Studio' : $p->beds }}
                                    @endif
                                    @if ($p->type != 2)
                                        <i class="bi bi-bucket me-1"></i>
                                        Baths: {{ $p->baths }}
                                    @endif
                                    @if ($p->type == 2) 
                                            <i class="bi bi-bookmark me-1"></i>
                                            <span class="small">{{ $p->subType->name }}</span> 
                                    @endif
                                    <i class="bi bi-rulers me-1 ms-2"></i>
                                    Area: {{ $p->area }} Sq.Ft.
                                </p>

                                <hr class="my-2">

                                <!-- Price & Logo -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="fs-5 mt-2 mb-0">
                                        AED {{ number_format($p->price, 2) }}
                                    </p>

                                    <img src="{{ url('public/frontend/assets/images/Devotion Real Estate.png') }}"
                                        alt="Logo" class="property-logo img-fluid">
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
