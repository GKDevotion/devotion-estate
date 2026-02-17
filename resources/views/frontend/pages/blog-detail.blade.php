@extends('layouts.app')

@section('content')

    <style>
        .blog-content h1,
        .blog-content h2,
        .blog-content h3,
        .blog-content h4,
        .blog-content h5,
        .blog-content h6 {
            color: #aa8038;
        }


        .tag-btn:hover {
            background-color: #aa8038;
            /* darker hover */
            border-color: #aa8038;
            color: #fff;
        }
    </style>
    <!-- BLOG CONTENT -->
    <section class="" style="padding-top: 7rem">
        <div class="container">
            <div class="row g-4">

                <!-- LEFT CONTENT -->
                <div class="col-lg-8">

                    <div class="small mb-2" style="font-size: large;">
                        <a href="{{ url('/') }}" class="text-decoration-none text-dark">Home</a>
                        <span class="mx-1 fs-4">›</span>
                        <a href="{{ route('blog.details', $blog->slug) }}" class="text-decoration-none  "
                            style="color: #aa8038;">
                            Blog
                        </a>
                    </div>

                    <h1 class="fw-bold display-6 mt-4">
                        {{ $blog->title }}
                    </h1>

                    <div class="d-flex gap-3 text-muted small mt-3 mb-3 fs-6">
                        <span>
                            <i class="bi bi-tag"></i>
                            {{ optional($blog->category->parent)->title }}
                            @if ($blog->category->parent)
                                › {{ $blog->category->title }}
                            @endif
                        </span>

                        <span>
                            <i class="bi bi-calendar"></i>
                            {{ $blog->created_at->format('d-m-Y') }}
                        </span>
                    </div>

                    <img src="{{ asset('storage/app/blog/' . $blog->image) }}" class="img-fluid rounded mb-4 blog-cover"
                        alt="{{ $blog->title }}">

                    <!-- Short Description -->
                    <p class="text-muted fst-italic mb-4">
                        {!! $blog->short_description !!}
                    </p>

                    <!-- HR Line -->
                    <hr class="blog-divider">

                    <div class="blog-content lh-lg fs-6 mb-3">
                        {!! $blog->description !!}
                    </div>

                    <div class="tag-section mb-5">

                        @foreach ($blog->tags as $tag)
                            <span class="btn btn-outline-secondary btn-sm rounded-pill">{{ $tag->name }}</span>
                        @endforeach
                    </div>

                    <style>
                        .blog-cover {
                            width: 100%;
                            height: 420px;
                            /* fixed height */
                            object-fit: fill;
                            /* keeps aspect ratio */
                            object-position: center;
                        }

                        .share-buttons .share-btn {
                            width: 42px;
                            height: 42px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            background-color: #aa8038;
                            color: #fff;
                            border-radius: 50%;
                            text-decoration: none;
                            font-size: 16px;
                            transition: all 0.3s ease;
                            box-shadow: 0 4px 10px rgba(170, 128, 56, 0.35);
                        }

                        .share-buttons .share-btn:hover {
                            background-color: #8f6a2e;
                            transform: translateY(-3px);
                            box-shadow: 0 6px 16px rgba(170, 128, 56, 0.55);
                            color: #fff;
                        }

                        .share-buttons .share-btn i {
                            line-height: 1;
                        }
                    </style>

                    <h6 class="fw-bold">Share On :</h6>
                    <div class="share-buttons d-flex gap-2 mt-3 mb-3">
                    
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank"
                            class="share-btn">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $shareUrl }}"
                            target="_blank" class="share-btn">
                            <i class="fab fa-whatsapp"></i>
                        </a>

                        <a href="https://twitter.com/intent/tweet?text={{ $shareTitle }}&url={{ $shareUrl }}"
                            target="_blank" class="share-btn">
                            <i class="fab fa-x-twitter"></i>
                        </a>

                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank"
                            class="share-btn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>

                        <a href="mailto:?subject={{ $shareTitle }}&body=Check this out:%0A{{ $shareUrl }}"
                            class="share-btn">
                            <i class="fas fa-envelope"></i>
                        </a>

                        <a href="https://pinterest.com/pin/create/button/?url={{ $shareUrl }}
                            &media={{ urlencode(asset('storage/blog/' . $blog->image)) }}
                            &description={{ $shareTitle }}"
                            target="_blank" class="share-btn">
                            <i class="fab fa-pinterest-p"></i>
                        </a>
                    </div>

                </div>

                <!-- SIDEBAR -->
                <div class="col-lg-4">

                    <!-- Categories -->
                    <div class="mb-5 mt-2">
                        <h5 class="fw-bold mb-3">Categories</h5>


                        <form action="{{ route('blog') }}" method="GET">
                            <div class="input-group mb-4 border">
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                    placeholder="Search categories...">
                                <button class="btn border-0" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>

                        <ul class="list-group list-group-flush">
                            @foreach ($categories as $parent)
                                @foreach ($parent->children as $child)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ route('blog', ['category' => $child->id]) }}"
                                            class="text-decoration-none
                                        {{ request('category') == $child->id ? 'fw-bold text-primary' : 'text-dark' }}">
                                            {{ $child->title }}
                                        </a>
                                        <i class="bi bi-arrow-right"></i>
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>


                    </div>

                    <!-- Popular Tags -->
                    <div>
                        <h5 class="fw-bold mb-3">Popular tags</h5>

                        <form method="GET" action="{{ route('blog') }}">
                            <input type="text" name="tag" class="form-control mb-3" placeholder="Search tags..."
                                value="{{ request('tag') }}">
                        </form>

                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($popularTags as $tag)
                                <a href="{{ route('blog', ['tag' => $tag->name]) }}"
                                    class="btn  btn-sm rounded-pill tag-btn" style="border: 1px solid #aa8038; ">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    @if ($relatedBlogs->count())
                        <section class="py-5 bg-white">
                            <div class="container">
                                <h4 class="fw-bold mb-4">Most Viewed</h4>

                                <div class="list-group list-group-flush">
                                    @foreach ($relatedBlogs as $item)
                                        <a href="{{ route('blog.details', $item->slug) }}"
                                            class="list-group-item list-group-item-action border-0 px-0">

                                            <div class="d-flex gap-3 align-items-center">
                                                <!-- Thumbnail -->
                                                <img src="{{ asset('storage/app/blog/' . $item->image) }}"
                                                    alt="{{ $item->title }}" class="rounded"
                                                    style="width: 100px; height: 70px; object-fit: fill;">

                                                <!-- Title -->
                                                <div>
                                                    <h6 class="mb-0   blog-title">
                                                        {{ Str::limit($item->title, 55) }}
                                                    </h6>
                                                </div>
                                            </div>

                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endif
                    
                </div>

            </div>
        </div>
    @endsection
