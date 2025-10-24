@extends('layouts.app')

@section('title', 'Seller Guide')

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
      Best Guide to Sell Your Property in Dubai
    </h1>
  </div>

  <div class="container content-section">
    <div class="row justify-content-center">
      <div class="col-lg-10 content-container">

        <p class="text-muted mb-4 description">
          We have area-specific agents, register hundreds of buyers per week, make industry leading investments in
          property portal exposure, run extensive SEO and PPC campaigns, target audiences on social media, have a
          professional marketing team for photos and videos, and use automated email and WhatsApp messaging to send your
          property to interested parties.
        </p>

        <p class="text-muted  mb-4 description">
          DevotionEstate take delight in relocating families into houses, having found homes for tens of thousands of
          families over the years and receiving numerous honours each year.
        </p>

        <div class="col-12 text-center">
          <h5 class="highlight-heading mb-3">Guide to sell your property in Dubai</h5>
          <p class="text-muted mb-4 description text-start">
            We've put up a straightforward step-by-step guide to selling an apartment or villa in Dubai for the first
            time to make the process easier and put your mind at ease.
          </p>
          <h5 class="sub-heading fw-semibold mb-3">
            This is a basic step-by-step approach to sell an apartment or villa in Dubai.
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
              <h4 class="mb-3 step-title-color timeline-title">Find a trusted broker</h4>
              <p class="desc">
                It is critical that you pick an agent you can trust and develop a professional but friendly relationship
                with. It is critical that you believe you can have an open and honest communication with your agent.
              </p>
              <p class="desc">
                They will provide advice and insight into the Dubai real estate market and the area you are selling
                in.They will supply you with market appraisals and show you pricing of recently sold houses.
              </p>
            </div>
          </div>
        </div>

        <div class="timeline-step">
          <div class="timeline-dot"></div>
          <div class="row">
            <div class="col-12 col-lg-6 step-text-left pe-lg-4">
              <h3 class="step-title-color fw-normal">Step 2</h3>
              <h4 class="mb-3 step-title-color timeline-title">Do your own due diligence</h4>
              <p class="desc">
                You already have a price in mind for selling, but is it possible and realistic in the Dubai property
                market? Jump on property websites and have a good look around to compare your property to others that
                have sold in your neighbourhood. Perhaps it would be beneficial to look at similar properties in other
                locations and see what purchasers can receive for the sale price you have set for your own property.
                Market price indexes will be given to you on a monthly basis, so you know what's selling in your region
                and at what price.
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
              <h4 class="mb-3 step-title-color timeline-title">Consider becoming exclusive</h4>
              <p class="desc">
                Exclusivity with one Dubai real estate broker means that your property is advertised with a consistent
                message and in a specified manner. This will avoid the possibility of a slew of various advertisements
                for your house, some of which may even show a different asking price than you agreed on with your
                broker.
              </p>
            </div>
          </div>
        </div>

        <div class="timeline-step">
          <div class="timeline-dot"></div>
          <div class="row">
            <div class="col-12 col-lg-6 step-text-left pe-lg-4">
              <h3 class="step-title-color fw-normal">Step 4</h3>
              <h4 class="mb-3 step-title-color timeline-title">Marketing</h4>
              <p class="desc">
                It is critical to tidy your home before the selling process starts.Your property will be professionally
                shot, and you want it to look as clean and appealing as possible.If there are any snagging jobs that
                need to be completed, we recommend that you do them before promoting your property.
              </p>
              <p class="desc">
                In spent a significant amount of time and money marketing your home. We can take professional photos, 3D
                tours, and video tours of selected properties, which will be promoted on our social media networks. We
                will have dedicated team call-out sessions and communicate with our buyers via email and SMS.
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
              <h4 class="mb-3 step-title-color timeline-title">Viewings</h4>
              <p class="desc">
                Again, make sure your property is in excellent shape before a potential buyer visits. We recommend that
                you share property highlights with your broker. Tell them what you love about your home! Perhaps it's
                the sunset view from the balcony or the sunrise over your garden while you sip your morning coffee. Our
                agents can convey this message to potential buyers and highlight details that may not be evident to the
                naked eye but could be deciding factors for a buyer.
              </p>
            </div>
          </div>
        </div>

        <div class="timeline-step">
          <div class="timeline-dot"></div>
          <div class="row">
            <div class="col-12 col-lg-6 step-text-left pe-lg-4">
              <h3 class="step-title-color fw-normal">Step 6</h3>
              <h4 class="mb-3 step-title-color timeline-title">Negotiation and contract signing</h4>
              <p class="desc">
                Your broker will begin to bring offers from potential buyers to you. This is another instance where
                having a strong relationship with your broker is critical. To help you make a selection, consider
                historical viewing feedback, comparable property sales, and a variety of data points provided by a good
                broker. Once a verbal agreement is reached, both you and the buyer will enter the contract stage, which
                will be managed by your broker.
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
              <h4 class="mb-3 step-title-color timeline-title">Sale Progression</h4>
              <p class="desc">
                The in-house sales progression team will be with you every step of the way to help you navigate the sale
                process and make it as smooth as possible, from the developer's No Objections Certificate (NOC) to the
                transfer.They coordinate between you as a buyer, the seller, the developer, and the banks involved, and
                with their years of experience, they are incredibly proactive and know the process thoroughly and out.
                To avoid delays, your sales progressor will ensure that all of your documentation are in order before
                proceeding with the procedure.
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
