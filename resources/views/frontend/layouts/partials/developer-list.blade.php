   {{--  Developers List --}}
   <section class="py-5 bg-light">
       <div class="container">
           <div class="row g-4">

               @forelse($developers as $dev)
                   <div class="col-lg-6">
                       <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                           <div class="row g-0 align-items-center">

                               <!-- Logo -->
                               <div class="col-md-4 text-center p-4 bg-white">
                                   <a href="{{ route('developer.properties', $dev->id) }}" class="text-center dev-logo">
                                       <img src="{{ asset('storage/app/developer/' . ($dev->image ?? 'default.png')) }}"
                                           class="img-fluid" alt="{{ $dev->name }}" style="max-height:150px;">
                                   </a>
                               </div>

                               <!-- Content -->
                               <div class="col-md-8">
                                   <div class="card-body px-4">
                                       <a href="{{ route('developer.properties', $dev->id) }}"
                                           class="  text-start text-decoration-none text-dark developer-name">
                                           <div class="d-flex justify-content-between align-items-center">
                                               <h5 class="fw-bold mb-0 developer-name">
                                                   {{ $dev->name }}
                                               </h5>

                                               <span class="badge rounded-3 p-2" style="background-color: #fff; font-size: 0.9rem; border: 1px solid lightgray; color: #aa8038;">
                                                   {{ $dev->properties_count }} Properties
                                               </span>
                                           </div>
                                           {{-- <h5 class="fw-bold mb-2">{{ $dev->name }}</h5> --}}
                                       </a>
                                       <p class="text-muted mt-3">
                                           {{ $dev->sub_title }}
                                       </p>
                                   </div>
                               </div>

                           </div>
                       </div>
                   </div>
               @empty
                   <div class="col-12 text-center text-muted">
                       No developers found
                   </div>
               @endforelse

           </div>



       </div>
   </section>

   <style>
       .pagination .page-link {
           border-radius: 50px !important;
           margin: 0 4px;
       }

       .developer-name h5:hover {
           color: #aa8038;
       }

       .dev-logo img {
           transition: all 0.4s ease;
       }

       .dev-logo:hover img {
           transform: scale(1.1);
           filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.15));
       }
   </style>
