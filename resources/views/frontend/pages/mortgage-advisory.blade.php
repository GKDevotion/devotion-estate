@extends('layouts.app')

@section('title', 'Mortagage Advisory')

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


    <div class="container" style="padding-top: 30px">

        <div class="container content-section">

            <div class="row justify-content-center">
                <div class="col-lg-10 content-container">

                    <h2 class="text-center mb-5 main-heading pt-5">
                        How to Do Mortgage Advisory Services in Dubai?
                    </h2>

                    <p class="mb-4 text-muted lead-text text-start">
                        A real estate mortgage is a legal agreement where a borrower (typically a property owner) pledges
                        real
                        property to a lender as security for a loan. This arrangement allows the borrower to receive funds
                        upfront,
                        usually to purchase or refinance real estate, while the lender obtains the right to take possession
                        of the
                        property if the borrower fails to repay the loan according to the agreed terms.
                    </p>

                    <h5 class="mt-5 mb-3  sub-heading">
                        Key elements of a mortgage include:
                    </h5>

                    <ol class="list-unstyled mortgage-list">
                        <li><span class="fw-semibold">1. Mortgagee and Mortgagor:</span> The lender is called the mortgagee,
                            and the
                            borrower is the mortgagor.</li>
                        <li><span class="fw-semibold">2. Loan Principal:</span> The amount of money borrowed by the
                            mortgage, which is
                            typically paid back with interest over a specified period.</li>
                        <li><span class="fw-semibold">3. Interest Rate:</span> The cost of borrowing money, expressed as a
                            percentage,
                            that the borrower must pay on top of the principal amount.</li>
                        <li><span class="fw-semibold">4. Repayment Terms:</span> This includes the schedule (monthly,
                            bi-monthly,
                            etc.) and duration (e.g., 15, 20, or 30 years) over which the loan must be repaid.</li>
                        <li><span class="fw-semibold">5. Foreclosure:</span> If the borrower defaults on the loan, the
                            lender can
                            initiate foreclosure proceedings to sell the property and recover the outstanding loan amount.
                        </li>
                        <li><span class="fw-semibold">6. Types of Mortgages:</span> Various types exist, including
                            <strong>fixed-rate
                                mortgages</strong>, adjustable-rate mortgages, and government-backed mortgages.</li>
                        <li><span class="fw-semibold">7. Legal Documentation:</span> A mortgage is documented through a
                            legal contract
                            specifying the rights and responsibilities of both parties.</li>
                    </ol>

                    <p class="mt-5 text-muted text-start lead-text">
                        Real estate mortgages are fundamental in facilitating property ownership and investment by providing
                        a
                        mechanism for individuals and businesses to access large sums of capital while securing lenders
                        against the
                        risk of default through collateral.
                    </p>

                </div>
            </div>


            <div class="row justify-content-center">
                <div class="col-lg-10 content-container">

                    <h2 class="text-start mb-4 main-heading-2 pt-5">Mortgage Products & Services</h2>

                    <ol class="list-unstyled">
                        <li class="mb-2">
                            <span class="fw-semibold">1. Mortgage and Mortgagor:</span>
                            <p class="mb-3">Primary market deals are loans booked for homes purchased directly from a
                                developer and
                                mortgaged to a
                                bank to finance the transaction.</p>
                            <p class="mb-4">If the property’s development is complete and ready for occupancy, the loan is
                                fully
                                disbursed upon
                                receipt of the lien instrument from the lands department/developer. If the property is
                                purchased off-plan,
                                money are
                                disbursed in accordance with an agreed-upon payment schedule, which is typically connected
                                to building
                                milestones.
                            </p>
                        </li>

                        <li class="mb-2">
                            <span class="fw-semibold">2. Secondary Market Deals:</span>
                            <p class="mb-3">Secondary market deals are loans made to aid the purchase of a property from
                                an existing
                                individual or
                                business that owns it.</p>
                            <p class="mb-3">If the present owner has an existing mortgage on the property, the buyer's
                                bank pays off the
                                seller's
                                mortgage loan first, and then the title is transferred to the purchaser.</p>
                            <p class="mb-4">Any extra money after the seller's bank's dues have been settled is paid to
                                the seller at
                                the time of
                                title transfer.</p>

                        </li>
                        <li class="mb-2">
                            <span class="fw-semibold">3. Pre-Approval Process:</span>
                            <p class="mb-4">A lender's practice of approving a borrower for a certain loan amount,
                                allowing prospective
                                house purchasers to shop with the knowledge, which is likely to be shared with a seller and
                                broker to
                                demonstrate their financial capability, prior to identifying the property to be mortgaged.
                            </p>

                        </li>
                        <li class="mb-2">
                            <span class="fw-semibold">4. Residential Mortgages:</span>
                            <p class="mb-2 ms-3">- First time home buyers</p>
                            <ul class="list-unstyled ms-5">
                                <li>a. First-time home purchasers with a property worth of up to 5 million dirhams can
                                    borrow up to 80% if
                                    they are
                                    UAE citizens and 75% if they are expats or non-residents.</li>
                                <li>b. This criteria is identical for Islamic financing and conventional mortgages.</li>
                            </ul>

                            <p class="mb-2 ms-3">- Second time home buyers</p>
                            <ul class="list-unstyled ms-5">
                                <li>a. Second-time home buyers can borrow up to the property value of five million dirhams.
                                    If they are
                                    UAE nationals,
                                    they can borrow up to 65% of the property's worth, whereas expats or non-residents can
                                    borrow 60%.</li>
                            </ul>
                        </li>

                    </ol>


                </div>
            </div>



            <div class="row justify-content-center">
                <div class="col-lg-10 content-container">

                    <h2 class="text-start mb-4 main-heading-2 pt-5">Important Documents</h2>

                    <ol class="list-unstyled">

                        <li class="mb-2">
                            <span class="fw-semibold">1. Salaried Employee Customers:</span>
                            <p class="mb-2 ms-3">The following documents must be submitted by the consumer when applying for
                                a house
                                mortgage.</p>
                            <p class="mb-2 ms-3">The bank may demand additional papers, which will be disclosed to the
                                consumer as
                                needed.</p>
                            <ul class="list-unstyled ms-5">
                                <li>a. Salary certificate, addressed to the bank. </li>
                                <li>b. Copy of the passport, visa, Emirates ID, and Khulasat Al Qaid (if applicable). </li>
                                <li>c. 6 months' bank statements for all accounts in the UAE.</li>
                                <li>d. Last six months' pay stubs (if relevant).</li>
                                <li>e. Current credit card statement for all active cards.</li>
                                <li>f. Information on current loans, if any.</li>
                                <li>g. Signed Etihad Bureau authorization (given by the bank).</li>
                                <li>h. Application form.</li>
                            </ul>

                        <li class="mb-2">
                            <span class="fw-semibold">2. Self employed Customers:</span>
                            <p class="mb-2 ms-3">The following documents must be submitted by the consumer when applying for
                                a house
                                mortgage.</p>
                            <p class="mb-2 ms-3">The bank may demand additional papers, which will be disclosed to the
                                consumer as
                                needed.</p>
                            <ul class="list-unstyled ms-5">
                                <li>a. Copy of the passport, visa, Emirates ID, and Khulasat Al Qaid (if applicable). </li>
                                <li>b. A valid copy of the business's trade license. </li>
                                <li>c. A copy of the company's MOAs, including any amendments and share certificates.</li>
                                <li>d. Two years of audited financials.</li>
                                <li>e. Six months' bank statements for all company and personal accounts in the UAE.</li>
                                <li>f. Offer / facility letters, if any loans and facilities availed by the company.</li>
                                <li>g. Current credit card statement for all active cards.</li>
                                <li>h. Information on existing loans, if any.</li>
                                <li>i. Signed Etihad Bureau authorization (given by the bank).</li>
                                <li>j. Application form.</li>
                                <li>k. Company profile.</li>
                            </ul>

                        </li>

                    </ol>
                </div>
            </div>

            <div class="row justify-content-center pb-5">
                <div class="col-lg-10 content-container">

                    <h2 class="text-start mb-4 main-heading-2 pt-5">Important Details</h2>

                    <ol class="list-unstyled">
                        <li class="mb-2">
                            <span class="fw-semibold">1. Insurance / Takaful:</span>
                            <p class="mb-2 ms-3">Banks in the UAE demand that mortgage loans be insured. Most banks require
                                that the
                                insurance be obtained from the bank itself, while others allow clients to assign their
                                current insurance
                                to the bank for the duration of the loan as long as it fits specific criteria. The primary
                                types of
                                compulsory insurances are as follows:</p>
                            <ul class="list-disc ms-5">
                                <li class="fw-semibold">Life Insurance</li>
                                <p class="mb-2">This is a life insurance policy that covers the borrower's loan amount for
                                    the duration of
                                    the facility. This assures that in the event of the borrower's death, the insurer
                                    settles the borrower's
                                    liabilities to the bank and hands over the property title free of encumbrance to the
                                    client's inheritors
                                    after necessary legal proceedings.</p>
                                <li class="fw-semibold">Property Insurance</li>
                                <p class="mb-2">This is a property insurance policy that covers reinstatement costs up to
                                    the maximum
                                    amount of the property's worth if it is damaged by external sources or structural
                                    component failure.</p>
                            </ul>
                        </li>

                        <li class="mb-2">
                            <span class="fw-semibold">2. Property Insurance / Takaful:</span>
                            <p class="mb-2 ms-3">Banks in the UAE demand that mortgage loans be insured. Most banks require
                                that the
                                insurance be obtained from the bank itself, while others allow clients to assign their
                                current insurance
                                to the bank for the duration of the loan as long as it fits specific criteria. The primary
                                types of
                                compulsory insurances are as follows:</p>
                            <ul class="list-disc ms-5">
                                <li class="fw-semibold">Life Insurance</li>
                                <p class="mb-2">This is a life insurance policy that covers the borrower's loan amount for
                                    the duration of
                                    the facility. This assures that in the event of the borrower's death, the insurer
                                    settles the borrower's
                                    liabilities to the bank and hands over the property title free of encumbrance to the
                                    client's inheritors
                                    after necessary legal proceedings.</p>
                                <li class="fw-semibold">Property Insurance</li>
                                <p class="mb-2">This is a property insurance policy that covers reinstatement costs up to
                                    the maximum
                                    amount of the property's worth if it is damaged by external sources or structural
                                    component failure.</p>
                            </ul>
                        </li>

                        <li class="mb-2">
                            <span class="fw-semibold">3. Property Valuation:</span>
                            <p class="mb-2 ms-3">To estimate the value of the property, the valuation will take into account
                                its
                                location and
                                condition, as well as recent transactions of similar property.
                            </p>
                        </li>

                        <li class="mb-2">
                            <span class="fw-semibold">4. AECB - Al Etihad Credit Bureau:</span>
                            <p class=" ms-3">Al Etihad Credit Bureau is a Public Joint Stock Company owned entirely by the
                                UAE Federal
                                Government. According to UAE Federal Law No. (6) of 2010 Governing Credit Information, the
                                company is
                                required to collect credit information on a regular basis from financial and non-financial
                                organizations
                                throughout the UAE. Al Etihad Credit Bureau collects and analyzes this data to calculate
                                Credit Scores and
                                Credit Reports, which are then made available to UAE residents and businesses.
                            </p>
                            <p class=" ms-3">
                                The Credit Report enables banks and financial institutions to make more informed decisions
                                and process
                                mortgage
                                applications more quickly because it contains all financial information, including credit
                                card, personal
                                loan, check,
                                and utility bill repayment history. Before pulling a report from the AECB, banks must get
                                the customer's
                                authorization.
                            </p>
                        </li>

                        <li class="mb-2">
                            <span class="fw-semibold">5. Finance Amortization Details:</span>
                            <p class="mb-2 ms-3">All mortgage loans in the UAE follow a normal amortization scheme, with
                                interest/profit
                                charged on a monthly diminishing balance. Payments are equal and normally charged monthly;
                                however,
                                central bank regulations allow for a maximum repayment period of three months (quarterly
                                payments).


                            </p>
                            <p class=" ms-3">
                                The monthly installment payment for your home financing consists of two main components:
                                capital repayment
                                and interest/profit payback. Every installment payment reduces your outstanding capital, and
                                a portion of
                                the annual interest is recovered proportionally in that month.
                            </p>
                        </li>
                    </ol>
                </div>
            </div>

        </div>

    </div>



@endsection
