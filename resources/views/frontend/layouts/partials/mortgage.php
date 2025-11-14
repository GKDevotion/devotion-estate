
    <div class="mx-auto p-4 p-md-5 bg-white shadow rounded-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <h2 class="fw-bold">Mortgage Calculator</h2>
            <p class="text-muted">Unlock your home purchasing potential.</p>
        </div>

        <div class="row g-4">
            <!-- Left -->
            <div class="col-md-6">

                <!-- Property Price -->
                <div>
                    <label class="form-label fw-semibold mt-3">Property Price</label>

                    <input type="number" id="price" value="1675000" step="1000" min="100000"
                        oninput="calculateMortgage()"
                        class="form-control form-control-lg text-muted">
                </div>

                <!-- Down Payment -->
                <div>
                    <label class="form-label fw-semibold mt-3">Down Payment</label>
                    <div class="d-flex gap-2">
                        <input type="number" id="downPayment" value="251250" step="100" min="0"
                            oninput="updatePercentageAndCalculate()"
                            class="form-control form-control-lg fw-semibold">

                        <div class="position-relative" style="width: 35%;">
                            <input type="number" id="downPaymentPercent" value="15" step="1" min="0" max="100"
                                oninput="updateDownPaymentValueAndCalculate()"
                                class="form-control form-control-lg fw-semibold text-end">
                            <span class="position-absolute top-50 translate-middle-y end-0 me-3 text-muted">%</span>
                        </div>
                    </div>
                </div>

                <!-- Loan Term -->
                <div>
                    <label class="form-label fw-semibold mt-3">Loan Term</label>
                    <div class="position-relative">
                        <input type="number" id="loanTerm" value="25" min="5" max="30"
                            oninput="calculateMortgage()"
                            class="form-control form-control-lg fw-semibold text-start">
                        <span class="position-absolute top-50 translate-middle-y end-0 me-3 text-muted">Years</span>
                    </div>
                </div>

                <!-- Interest Rate -->
                <div>
                    <label class="form-label fw-semibold mt-3">Interest Rate</label>
                    <div class="position-relative">
                        <input type="number" id="interestRate" value="3.75" step="0.01" min="0"
                            oninput="calculateMortgage()"
                            class="form-control form-control-lg fw-semibold text-start">
                        <span class="position-absolute top-50 translate-middle-y end-0 me-3 text-muted">%</span>
                    </div>
                </div>

            </div>

            <!-- Right -->
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-4 shadow-sm h-100 d-flex flex-column">

                    <!-- Monthly Payment -->
                    <div class="text-center mb-4">
                        <p class="text-uppercase small text-muted mb-1">Monthly Payment</p>
                        <h2 id="monthlyPaymentDisplay" class="fw-bold">AED 7,320</h2>
                    </div>

                    <!-- Breakdown -->
                    <div class="mb-4 small">
                        <div class="d-flex justify-content-between mb-2">
                            <span><span class="badge me-2" style=" background-color: #e2b465ff;">&nbsp;</span> Principal</span>
                            <strong id="principalDisplay">AED 1,423,750</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span><span class="badge me-2" style=" background-color: #aa8038;">&nbsp;</span> Interest</span>
                            <strong id="interestDisplay">AED 772,233</strong>
                        </div>

                        <div class="border-top pt-2 d-flex justify-content-between">
                            <strong>Total Loan Amount</strong>
                            <strong id="totalLoanAmountDisplay">AED 2,195,983</strong>
                        </div>
                    </div>

                    <!-- Visualization Bar -->
                    <div class="mb-3">
                        <div class="d-flex rounded overflow-hidden" style="height: 14px;">
                            <div id="principalBar" class="" style="width: 65%; background-color: #e2b465ff;"></div>
                            <div id="interestBar" class="" style="width: 35%; background-color: #aa8038;"></div>
                        </div>

                        <div class="d-flex justify-content-between small text-muted mt-1">
                            <span id="principalPercent">65%</span>
                            <span id="interestPercent">35%</span>
                        </div>
                    </div>

                    <p class="text-center small text-muted mt-2">
                        Powered by <span class="fw-bold">Devotion</span>
                    </p>
                </div>
            </div>
        </div>
    </div>



<script>
    // Helper function for formatting numbers to UAE style (e.g., 1,234,567)
    const formatAED = (number) => {
        return `AED ${Math.round(number).toLocaleString('en-US')}`;
    };

    // --- Core Calculation Logic ---
    function calculateMortgage() {
        // 1. Get Input Values
        const price = parseFloat(document.getElementById('price').value) || 0;
        const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
        const termYears = parseFloat(document.getElementById('loanTerm').value) || 0;
        const ratePercent = parseFloat(document.getElementById('interestRate').value) || 0;

        // Prevent calculation if essential inputs are missing or invalid
        if (price <= 0 || termYears <= 0 || ratePercent <= 0) {
            // Reset displays to zero/default
            document.getElementById('monthlyPaymentDisplay').textContent = formatAED(0);
            document.getElementById('principalDisplay').textContent = formatAED(0);
            document.getElementById('interestDisplay').textContent = formatAED(0);
            document.getElementById('totalLoanAmountDisplay').textContent = formatAED(0);

            // Reset visualization bar
            updateVisualization(0, 0);
            return;
        }

        // 2. Prepare Variables for Formula
        const principalLoan = price - downPayment;
        const monthlyRate = (ratePercent / 100) / 12; // r (monthly interest rate)
        const totalPayments = termYears * 12; // n (total number of payments)

        let monthlyPayment = 0;
        let totalInterest = 0;
        let totalLoanAmount = 0;

        // Formula M = P [ r(1+r)^n / ((1+r)^n - 1) ]
        if (monthlyRate > 0) {
            const termFactor = Math.pow(1 + monthlyRate, totalPayments);
            monthlyPayment = principalLoan * (monthlyRate * termFactor) / (termFactor - 1);

            totalLoanAmount = monthlyPayment * totalPayments;
            totalInterest = totalLoanAmount - principalLoan;
        } else {
            // Zero interest case: Simple division of principal by total payments
            monthlyPayment = principalLoan / totalPayments;
            totalLoanAmount = principalLoan;
            totalInterest = 0;
        }

        // 3. Update Text Displays
        document.getElementById('monthlyPaymentDisplay').textContent = formatAED(monthlyPayment);
        document.getElementById('principalDisplay').textContent = formatAED(principalLoan);
        document.getElementById('interestDisplay').textContent = formatAED(totalInterest);
        document.getElementById('totalLoanAmountDisplay').textContent = formatAED(totalLoanAmount);

        // 4. Update Visualization Bar
        updateVisualization(principalLoan, totalLoanAmount);
    }

    // --- Visualization & Input Synchronization Logic ---

    /**
     * Updates the visual bar based on the ratio of Principal to Total Loan Amount.
     * @param {number} principalLoan - The initial principal amount (price - down payment).
     * @param {number} totalLoanAmount - The total amount paid over the loan term (principal + interest).
     */
    function updateVisualization(principalLoan, totalLoanAmount) {
        let principalShare = 0;
        let interestShare = 0;

        if (totalLoanAmount > 0) {
            principalShare = (principalLoan / totalLoanAmount) * 100;
            interestShare = 100 - principalShare;
        }

        // Set styles for the bar widths
        document.getElementById('principalBar').style.width = `${principalShare.toFixed(2)}%`;
        document.getElementById('interestBar').style.width = `${interestShare.toFixed(2)}%`;

        // Update percentage labels
        document.getElementById('principalPercent').textContent = `${principalShare.toFixed(0)}%`;
        document.getElementById('interestPercent').textContent = `${interestShare.toFixed(0)}%`;
    }

    /**
     * Triggered when the Down Payment VALUE changes.
     * Updates the percentage input and runs the mortgage calculation.
     */
    function updatePercentageAndCalculate() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;

        if (price > 0 && downPayment >= 0) {
            const percentage = (downPayment / price) * 100;
            document.getElementById('downPaymentPercent').value = percentage.toFixed(0);
        } else {
            document.getElementById('downPaymentPercent').value = 0;
        }

        calculateMortgage();
    }

    /**
     * Triggered when the Down Payment PERCENTAGE changes.
     * Updates the value input and runs the mortgage calculation.
     */
    function updateDownPaymentValueAndCalculate() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const percentage = parseFloat(document.getElementById('downPaymentPercent').value) || 0;

        if (price > 0 && percentage >= 0 && percentage <= 100) {
            const downPayment = (price * percentage) / 100;
            document.getElementById('downPayment').value = downPayment.toFixed(0);
        } else if (percentage > 100) {
            // Cap at 100%
            document.getElementById('downPaymentPercent').value = 100;
            document.getElementById('downPayment').value = price.toFixed(0);
        } else {
            document.getElementById('downPayment').value = 0;
        }

        calculateMortgage();
    }

    // Run the calculation once on load to populate initial values
    window.onload = function() {
        calculateMortgage();
    };
</script>