@extends('layouts.app')

@section('title', 'Investment & Advisory')

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

    <div class="container"  >
      <div class="row mb-4 " style="padding-top: 100px">
        <div class="col-12 text-center">
          <h2 class="text-brown " style="color: #aa8038; font-size: 1.7rem;">Investment Advisory Services Dubai |
            Financial Advisers UAE</h2>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-7 investment-section">
          <h5 class="investment-heading">
            Venture into the World of Investments
          </h5>
          <p class="investment-text">
            Investments & Advisory is an integrated branch of DevotionEstate Properties that provides investors and
            high-net-worth individuals (HNWIs) in Dubai with the opportunity to enter new markets with confidence while
            also connecting them to the most lucrative investment funds and business stakes. Using cutting-edge research
            and data analysis, RERA-licensed specialists guide investors through the process of making informed
            decisions based on current real estate performance trends.
          </p>

          <p class="investment-text">
            DevotionEstate Investments & Advisory is the top choice for real estate and business investments in Dubai,
            backed by a team of senior-level industry specialists and a commitment to quality. We provide our clients
            distinctive real estate and commercial initiatives, invaluable industry knowledge, and a commitment to
            maximise financial profitability on all investments.
          </p>
        </div>


        <div class="col-lg-5 investment-list-section">
          <h5 class="investment-list-heading">
            Booming sectors and investment projects
          </h5>
          <ul class="investment-list list-unstyled">
            <li class="mb-2">- Residential and Commercial Bulk Units</li>
            <li class="mb-2">- Industries and factories</li>
            <li class="mb-2">- Businesses & Equities For Sale</li>
            <li class="mb-2">- Joint ventures</li>
            <li class="mb-2">- Hospitality and healthcare Education</li>
          </ul>
        </div>

      </div>

      <div class="row mt-3">

        <div class="col-md-4 d-flex">
          <div class="card custom-card w-100 ">
            <div class="card-img-top-container">
              <img src="public\frontend\assets\images\img\fundraising-debt-equity.jpg" class="card-img-top" alt="Savings Jar and Coins">
            </div>
            <div class="card-body">

              <p class="card-text text-secondary pt-3">
                Debt financing is when a company raises funds for working capital by selling debt instruments to
                individual or institutional investors. The alternative approach to raise funds in debt markets is to
                issue shares of stock in a public offering, which is known as equity financing.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">
          <div class="card custom-card w-100">
            <div class="card-img-top-container">
              <img src="public\frontend\assets\images\img\financial-due-diligence.jpg" class="card-img-top" alt="Financial Documents Review">
            </div>
            <div class="card-body">

              <p class="card-text text-secondary pt-3">
                Devotion Estate, a well-known name in the UAE, takes pleasure in providing accurate real estate
                financial due diligence (FDD) services through a team of experienced specialists. Land Sterling
                recognizes the importance of FDD in the process of real estate investment decision-making and allows its
                clients to handle complex transactions with precision and confidence.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">
          <div class="card custom-card w-100">
            <div class="card-img-top-container">
              <img src="public\frontend\assets\images\img\investment-due-diligence.jpg" class="card-img-top" alt="Team Reviewing Investment">
            </div>
            <div class="card-body">

              <p class="card-text text-secondary pt-3">
                Investment due diligence is what distinguishes professionals from amateurs. Before handing over your
                money, thoroughly investigate each investment, broker, and money manager to protect yourself from
                catastrophic loss and help you make more profitable, well-informed investing selections.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">
          <div class="card custom-card w-100">
            <div class="card-img-top-container">
              <img src="public\frontend\assets\images\img\sales-acquisition.jpg" class="card-img-top" alt="Team Reviewing Investment">
            </div>
            <div class="card-body">

              <p class="card-text text-secondary pt-3">
                Our staff has extensive knowledge in the most significant parts of sales and acquisition, which will
                assist in identifying the appropriate consideration factors for transactions. Acquisitions are a
                particular procedure in which one firm "buys" another company by acquiring its assets, with the
                intention of keeping both businesses operational in some manner. Because of this, it is also known as a
                takeover.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">
          <div class="card custom-card w-100">
            <div class="card-img-top-container">
              <img src="public\frontend\assets\images\img\investment-optimization.jpg" class="card-img-top" alt="Team Reviewing Investment">
            </div>
            <div class="card-body">

              <p class="card-text text-secondary pt-3">
                At Devotion Estate, we specialize in educating clients about various investing alternatives, such as
                equities, bonds, mutual funds, and the lucrative world of real estate. While various paths offer
                distinct advantages, we highlight the long-term benefits and stability that real estate investment can
                bring to a diversified portfolio.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">
          <div class="card custom-card w-100">
            <div class="card-img-top-container">
              <img src="public\frontend\assets\images\img\Built-To-Suit-Structuring.jpg" class="card-img-top" alt="Team Reviewing Investment">
            </div>
            <div class="card-body">

              <p class="card-text text-secondary pt-3">
                A built-to-suit structure is a commercial building constructed according to the design parameters
                provided by the client. It is a tailored structure that is intended to fit the operational requirements
                of a firm, including its specialized operations and management demands.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">
          <div class="card custom-card w-100">
            <div class="card-img-top-container">
              <img src="public\frontend\assets\images\img\Portfolio-Assessment-And-Review.jpg" class="card-img-top"
                alt="Team Reviewing Investment">
            </div>
            <div class="card-body">

              <p class="card-text text-secondary pt-3">
                Devotion Estate is well-known for its competence and comprehensive real estate consultancy services. The
                Property Portfolio Assessment and Review service, one of our core solutions, serves as a keystone for
                investors and property owners in the UAE, allowing them to make the correct decisions and maximize the
                potential of their real estate assets.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">
          <div class="card custom-card w-100">
            <div class="card-img-top-container">
              <img src="public\frontend\assets\images\img\Portfolio-Assessment-And-Review(1).jpg" class="card-img-top"
                alt="Team Reviewing Investment">
            </div>
            <div class="card-body">

              <p class="card-text text-secondary pt-3">
                A Real Estate Investment Trust (REIT) is a firm that owns, manages, or finances income-producing assets.
                REITs allow investors to generate passive income by investing in real estate without having to own the
                property.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">
          <div class="card custom-card w-100">
            <div class="card-img-top-container">
              <img src="public\frontend\assets\images\img\Debt-Advisory-Development-Finance.jpg" class="card-img-top"
                alt="Team Reviewing Investment">
            </div>
            <div class="card-body">

              <p class="card-text text-secondary pt-3">
                is a top-rated Dubai property debt consulting firm having access to a large network of debt financing
                sources across Europe, the Middle East, and Africa. We help property investors make informed decisions
                about acquiring financing for property development.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">
          <div class="card custom-card w-100">
            <div class="card-img-top-container">
              <img src="public\frontend\assets\images\img\Technical-Due-Diligence.jpg" class="card-img-top" alt="Team Reviewing Investment">
            </div>
            <div class="card-body">

              <p class="card-text text-secondary pt-3">
                Dubai's real estate sector has developed as a magnet for international investors looking for attractive
                opportunities. In today's lively landscape, wise real estate investors must ensure extensive technical
                due diligence. The procedure entails a thorough study of a property's physical and legal features,
                including its construction quality, regulatory compliance, and potential dangers. This rigorous analysis
                serves as a critical risk mitigation approach, shielding investors from unforeseen dangers.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">
          <div class="card custom-card w-100">
            <div class="card-img-top-container">
              <img src="public\frontend\assets\images\img\Assistance-In-Portfolio-Diversification.jpg" class="card-img-top"
                alt="Team Reviewing Investment">
            </div>
            <div class="card-body">

              <p class="card-text text-secondary pt-3">
                Having a diverse portfolio is the most effective way to reduce risk in investment decisions. A diverse
                real estate portfolio allows you to balance high-risk and low-risk properties.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">
          <div class="card custom-card w-100">
            <div class="card-img-top-container">
              <img src="public\frontend\assets\images\img\Sale-Leaseback.jpg" class="card-img-top" alt="Team Reviewing Investment">
            </div>
            <div class="card-body">

              <p class="card-text text-secondary pt-3">
                Sale & Leaseback is a novel technique to obtain funding without the requirement for bank loans or monies
                from independent lenders. Sale and leaseback allow the seller of a property to continue to utilize it
                even after it has been sold.
              </p>
            </div>
          </div>
        </div>
      </div>


      <div class="row mt-5">

        <div class="col-12 text-center">
          <h5 class="text-start mb-3" style="color: #aa8038; font-size: x-large; ">Benefits of Using a Property
            Management
            Company</h5>
        </div>


        <div class="col-md-4 d-flex">
          <div class="card custom-card w-100">
            <div class="card-body">
              <h5 class="card-title text-center">Expert Research & Analysis</h5>
              <p class="card-text text-secondary pt-3">
                Our real estate investment experts excel at performing research and analysis on current real estate
                market trends. They provide you with suggestions and recommendations for investing decisions based on
                in-depth market study.
              </p>
            </div>
          </div>
        </div>


        <div class="col-md-4 d-flex">
          <div class="card custom-card w-100">
            <div class="card-body">
              <h5 class="card-title text-center">Connections in the Industry</h5>
              <p class="card-text text-secondary pt-3">
                To ensure that your real estate investment decisions are profitable, you must have the necessary
                industry relationships. Land Sterling is deeply interwoven into Dubai's real estate industry, so we can
                assist our clients get the outcomes they seek in record time.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">

          <div class="card custom-card w-100">

            <div class="card-body">
              <h5 class="card-title text-center">Professional Negotiation</h5>
              <p class="card-text text-secondary pt-3">
                Our real estate investment experts will negotiate on your behalf to ensure that your real estate
                investment remains lucrative. They bargain on your behalf so you can get a fantastic deal.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">

          <div class="card custom-card w-100">

            <div class="card-body">
              <h5 class="card-title text-center">Location Expertise</h5>
              <p class="card-text text-secondary pt-3">
                Our real estate investment advisors have extensive knowledge of European, Middle Eastern, and African
                countries. You can use our real estate investment knowledge in these areas to determine the feasibility
                of your real estate investment.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">

          <div class="card custom-card w-100">

            <div class="card-body">
              <h5 class="card-title text-center">Legal Documentation</h5>
              <p class="card-text text-secondary pt-3">
                Our property consultants in Dubai are skilled at dealing with complex legal papers related to property
                investments. We will draft the documents and submit them to the appropriate authorities on your behalf.
                We provide total assistance in managing paperwork to facilitate your property investing endeavor.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 d-flex">

          <div class="card custom-card w-100">

            <div class="card-body">
              <h5 class="card-title text-center">Handling Post-sale Concerns</h5>
              <p class="card-text text-secondary pt-3">
                Our real estate investment advisors stay with you even after the investment has been made to help you
                navigate complications associated with the investment. Our experts offer assistance with any questions
                or queries that you might have post-sale.
              </p>
            </div>
          </div>
        </div>

      </div>


    </div>
    

    <div class="container custom-section pt-5">
      <div class="mb-4">
        <h3 class="fw-bold" style="color: #aa8038; font-size:1.3rem">
          <i class="bi bi-check-circle-fill"></i> What Is Real Estate Investing, And Why Is Dubai An Attractive Place
          For Real Estate Investors?
        </h3>
        <p class="text-secondary" style="text-align: justify;">
          Real estate investment entails purchasing, owning, managing, and selling real estate holdings for a profit.
          Dubai is a popular real estate investment destination because to its fast expanding economy, strategic
          location, and investor-friendly rules.
          Dubai has a variety of real estate investment opportunities, including residential and commercial properties,
          as well as short- and long-term investments.
        </p>
      </div>

      <div class="mb-4">
        <h3 class="fw-bold" style="color: #aa8038; font-size:1.3rem;">
          <i class="bi bi-check-circle-fill"></i> What Services Do Investment And Advising Businesses In Dubai Provide
          To Real Estate Investors?
        </h3>
        <p class="text-secondary" style="text-align: justify;">
          Investment and advice firms in Dubai provide a variety of services to real estate investors, including market
          research, investment analysis, risk assessment, and portfolio management.
          These organisations may also advise and guide you on the greatest investment options in Dubai's real estate
          market, as well as tactics for increasing profits and lowering risks.
        </p>
      </div>

      <div class="mb-4">
        <h3 class="fw-bold" style="color: #aa8038; font-size:1.3rem;">
          <i class="bi bi-check-circle-fill"></i> How Can I Discover A Reputable Investment And Advice Firm In Dubai
          That Offers Real Estate Investing Services?
        </h3>
        <p class="text-secondary" style="text-align: justify;">
          Properties is a reliable investment and consultancy organisation in Dubai that provides real estate investment
          services.
          We offer a full range of real estate asset management services, including consultancy.
        </p>
      </div>
    </div>


@endsection
