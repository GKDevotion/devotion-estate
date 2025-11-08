var currentTab = 0; // Current tab is set to be the first tab (0)
var checkValidation = false;

$(document).on( "ready", function() {

    const dropifyClass = ["property_image"];
    $( dropifyClass ).each(function( index, className ) {

        if( $('.'+className).length > 0){
            $('.'+className).dropify();
        }
    });

    if( $(".textarea").length > 0 ){
        document.querySelectorAll('textarea').forEach(textarea => {
            ClassicEditor
                .create(textarea)
                .catch(error => {
                    console.error(error);
                });
        });
    }

    /**
     * get departtment list
     */
    $(document).on('change', '#employee_type_id', function(){
        $(".contractual").addClass( 'd-none' );
        if( $("#employee_type_id option:selected").text().toLowerCase() == "contractual" ){
            $(".contractual").removeClass( 'd-none' );
        }
    } );

    if( $("#PropertyRegistrationForm").length > 0){
        showTab(currentTab); // Display the current tab
    }

    /**
     *
     */
    $(document).on('change', '#purpose', function(){

        var selected = $("#purpose option:selected").val();
        if( selected == 0 ){
            $(".purpose-for-sale").removeClass("d-none");
            $(".purpose-for-rent").addClass("d-none");
            $(".purpose-type-txt").text("Sale");
            $(".purpose-type-sale").removeClass("d-none");
            $(".purpose-type-rent").addClass("d-none");
        } else {
            $(".purpose-for-sale").addClass("d-none");
            $(".purpose-for-rent").removeClass("d-none");
            $(".purpose-type-txt").text("Rent");
            $(".purpose-type-sale").addClass("d-none");
            $(".purpose-type-rent").removeClass("d-none");
        }

        showOffPlanContent();
    });

        $(document).on('change', '#type', function(){

        var selected = $("#type option:selected").val();
        if( selected == 1 ){
            $(".type-for-residential").removeClass("d-none");
            $(".type-for-commercial").addClass("d-none");
            $(".type-type-txt").text("Sale");
            $(".type-type-residential").removeClass("d-none");
            $(".type-type-commercial").addClass("d-none");
        } else {
            $(".type-for-residential").addClass("d-none");
            $(".type-for-commercial").removeClass("d-none");
            $(".type-type-txt").text("Rent");
            $(".type-type-residential").addClass("d-none");
            $(".type-type-commercial").removeClass("d-none");
        }

     
    });

    /**
     *
     */
    $(document).on('change', '#is_complete', function(){
        showOffPlanContent();
    });

    /**
     *
     */
    $(document).on('change', '#type', function(){

        $(".default-sub-type-hide").addClass("d-none");
        var selected = $("#type option:selected").val();
        $(".show-"+selected).removeClass("d-none");
    });
    /**
     *
     */


});

function showOffPlanContent(){

    var selectPurpose = $("#purpose option:selected").val();
    var completionStatus = $("#is_complete option:selected").val();
    if( completionStatus == 3 && selectPurpose == 1 ){
        $(".is-complete-offplan").removeClass("d-none");
    } else {
        $(".is-complete-offplan").addClass("d-none");
    }
}

function showTab(n) {
    // This function will display the specified tab of the form...
    var x = document.getElementsByClassName("step");
    $(".step").hide();
    x[n].style.display = "block";

    //... and fix the Previous/Next buttons:
    if (n == 0) {
        // document.getElementById("prevBtn").style.display = "none";
        $("#prevBtn").attr("disabled", true);
    } else {
        // document.getElementById("prevBtn").style.display = "inline";
        $("#prevBtn").attr("disabled", false);
    }

    if (n == (x.length - 1)) {
        $("#nextBtn").addClass("d-none");
        $("#submitBtn").removeClass("d-none");
    } else {
        $("#nextBtn").removeClass("d-none");
        $("#submitBtn").addClass("d-none");
        // document.getElementById("nextBtn").innerHTML = "Next";
    }

    //... and run a function that will display the correct step indicator:
    fixStepIndicator(n)
}

function nextPrev( n, formID ) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("step");

    if( formID != "" ){

        let formData = new FormData( document.getElementById( formID ) );

        // 🔹 Get data from CKEditor
        formData.set('description', editorInstance.getData() );

        $.ajax({
            url: $(".property-submit-url").text(),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {

                if (response.type == "success") {
                    $('.property-id').val(response.id);

                    showToast(response.message);

                    if( response.isRedirectThankYou ){
                        // window.location.href = url+'/thank-you';
                        $("#PropertyStepForm3, .reference-tag").addClass("d-none");
                        $(".thank-you-page").removeClass("d-none");
                        $(".property-unique-id").text(response.unique_id);
                    } else {
                        currentTab = currentTab + n; // Increase or decrease the current tab by 1:
                        showTab(currentTab);// Otherwise, display the correct tab:
                    }
                } else {
                    showToast(response.message);
                }
            },
            error: function (xhr) {

                showToast("Check validation errors");
                displayErrors(xhr.responseJSON.errors);
            }
        });
    } else {
        // currentTab = currentTab + n; // Increase or decrease the current tab by 1:
        // showTab(currentTab);// Otherwise, display the correct tab:

        showToast("Something wrong happen!, Contact Developer to update issues.");
    }
}

function validateForm() {

    if( !checkValidation ){
        return true;
    }

    var x, y, i, textarea, select, valid = true; // This function deals with validation of the form fields
    x = document.getElementsByClassName("step");
    y = x[currentTab].getElementsByTagName("input");

    for (i = 0; i < y.length; i++) {// A loop that checks every input field in the current tab:
        if (y[i].value == "" && $(y[i]).attr("data-required") == 'yes'  && !$(y[i]).is( ":disabled" ) ) {// If a field is empty...
            y[i].className += " invalid";// add an "invalid" class to the field:
            valid = false;// and set the current valid status to false
        }
    }

    textarea = x[currentTab].getElementsByTagName("textarea");
    for (i = 0; i < textarea.length; i++) {// A loop that checks every input field in the current tab:
        if (textarea[i].value == "" && $(textarea[i]).attr("data-required") == 'yes'  && !$(textarea[i]).is( ":disabled" ) ) {// If a field is empty...
            textarea[i].className += " invalid";// add an "invalid" class to the field:
            valid = false;// and set the current valid status to false
        }
    }

    select = x[currentTab].getElementsByTagName("select");
    for (i = 0; i < select.length; i++) {// A loop that checks every input field in the current tab:
        console.log( select[i] );
        if ( ( select[i].value == "" || select[i].value == "0" || select[i].value == null ) && $(select[i]).attr("data-required") == 'yes' && !$(select[i]).is( ":disabled" ) ) {// If a field is empty...
            select[i].className += " invalid";// add an "invalid" class to the field:
            valid = false;// and set the current valid status to false
        }
    }

    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
        document.getElementsByClassName("stepIndicator")[currentTab].className += " finish";
    }

    return valid; // return the valid status
}

function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("stepIndicator");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }

    //... and adds the "active" class on the current step:
    x[n].className += " active";
}

/**
 * employee KYC information disable input tag
 */
$(document).on( "click", '.dropify-clear', function() {
    // Finds the sibling input field within the same parent and gets its ID
    let inputId = $(this).siblings('input').attr('id');
    $("#"+inputId+"_input").attr( "disabled", true ); // Outputs the ID of the input field
});
