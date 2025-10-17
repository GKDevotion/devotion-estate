/**
 *
 */
if( $("#downloadCorporateEmailCSV").length > 0 ){
    document.getElementById("downloadCorporateEmailCSV").addEventListener("click", function () {
        const data = {
            status: $("#corporate_status").val(),
            companyId: $("#corporate_company_id").val(),
            email: $("#corporate_email").val(),
            firstName: $("#corporate_first_name").val(),
            lastName: $("#corporate_last_name").val(),
        };

        fetch(url+'/corporate-email-download-csv', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),  // CSRF token
            },
            body: JSON.stringify(data)
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'corporate-email.csv';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => console.error('Error:', error));
    });
}

/**
 *
 */
if( $("#viewCorporateEmailPDF").length > 0 ){
    document.getElementById("viewCorporateEmailPDF").addEventListener("click", function () {
        var status = $("#corporate_status").val();
        var companyId = $("#corporate_company_id").val();
        var email = $("#corporate_email").val();
        var firstName = $("#corporate_first_name").val();
        var lastName = $("#corporate_last_name").val();

        // Construct the URL with query parameters
        const openURL = url+`/corporate-email-view-pdf?status=${status}&companyId=${companyId}&email=${email}&firstName=${firstName}&lastName=${lastName}`;

        // Open the URL in a new tab
        window.open(openURL, '_blank');
    });
}

/**
 *
 */
if( $("#viewCompanyPDF").length > 0 ){
    document.getElementById("viewCompanyPDF").addEventListener("click", function () {
        var status = $("#status").val();
        var industryId = $("#industry_id").val();
        var companyName = $("#company_name").val();

        // Construct the URL with query parameters
        const openURL = url+`/company-view-pdf?status=${status}&industryId=${industryId}&companyName=${companyName}`;

        // Open the URL in a new tab
        window.open(openURL, '_blank');
    });
}

/**
 *
 */
if( $("#viewDepartmentPDF").length > 0 ){
    document.getElementById("viewDepartmentPDF").addEventListener("click", function () {
        var status = $("#status").val();
        var industryId = $("#industry_id").val();
        var companyId = $("#company_id").val();
        var departmentName = $("#department_name").val();

        // Construct the URL with query parameters
        const openURL = url+`/department-view-pdf?status=${status}&industryId=${industryId}&companyId=${companyId}&departmentName=${departmentName}`;

        // Open the URL in a new tab
        window.open(openURL, '_blank');
    });
}

/**
 * Download Client Personal Meeting data
 */
if( $("#downloadClientMeetingCSV").length > 0 ){

    document.getElementById("downloadClientMeetingCSV").addEventListener("click", function () {
        const data = {
            status: $("#meeting_status").val(),
            segment_id: $("#segment").val(),
            start_date: $("#start_date").val(),
            end_date: $("#end_date").val(),
        };

        fetch(url+'/personal-client-meeting-download-csv', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),  // CSRF token
            },
            body: JSON.stringify(data)
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'client_meeting.csv';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => console.error('Error:', error));
    });
}

/**
 * View Client Personal Meeting data
 */
if( $("#viewClientMeetingPDF").length > 0 ){
    document.getElementById("viewClientMeetingPDF").addEventListener("click", function () {
        var status = $("#meeting_status").val();
        var segment_id = $("#segment").val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();

        // Construct the URL with query parameters
        const openURL = url+`/personal-client-meeting-view-pdf?status=${status}&segment_id=${segment_id}&start_date=${start_date}&end_date=${end_date}`;

        // Open the URL in a new tab
        window.open(openURL, '_blank');
    });
}

/**
 * Download Client Personal Meeting data
 */
if( $("#downloadCompanyMeetingCSV").length > 0 ){

    document.getElementById("downloadCompanyMeetingCSV").addEventListener("click", function () {
        const data = {
            status: $("#meeting_status").val(),
            segment_id: $("#segment").val(),
            start_date: $("#start_date").val(),
            end_date: $("#end_date").val(),
        };

        fetch(url+'/company-meeting-download-csv', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),  // CSRF token
            },
            body: JSON.stringify(data)
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'client_meeting.csv';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => console.error('Error:', error));
    });
}

/**
 * View Company Meeting data
 */
if( $("#viewCompanyMeetingPDF").length > 0 ){
    document.getElementById("viewCompanyMeetingPDF").addEventListener("click", function () {
        var status = $("#meeting_status").val();
        var segment_id = $("#segment").val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();

        // Construct the URL with query parameters
        const openURL = url+`/company-meeting-view-pdf?status=${status}&segment_id=${segment_id}&start_date=${start_date}&end_date=${end_date}`;

        // Open the URL in a new tab
        window.open(openURL, '_blank');
    });
}
