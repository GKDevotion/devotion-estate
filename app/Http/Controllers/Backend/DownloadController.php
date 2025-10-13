<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyMeeting;
use App\Models\CorporateEmail;
use App\Models\Department;
use App\Models\PersonMeeting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class DownloadController extends Controller
{
    public $user;
    public $is_assign_super_admin = 0;
    public $admin_id = 0;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    /**
     *
     */
    public function setPublicVar(){
        $this->is_assign_super_admin = $this->user->is_assign_super_admin;
        $this->admin_id = $this->user->id;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     *
     */
    public function downloadCorporateEmailCSV( Request $request ){

        $this->setPublicVar();

        // Retrieve request parameters
        $first_name = $request->firstName;
        $last_name = $request->lastName;
        $email = $request->email;
        $company_id = $request->companyId;
        $status = $request->status;

        $query = CorporateEmail::select( 'industry_id', 'first_name', 'last_name', 'primary_email', 'email', 'status', 'company_parent_id', 'company_id' );

        if( !$this->is_assign_super_admin ){
            $query = $query->where( 'admin_id', $this->admin_id );
        }

        if( $first_name ){
            $query = $query->where( "first_name", "like", "%{$first_name}%" );
        }

        if( $last_name ){
            $query = $query->where( "last_name", "like", "%{$last_name}%" );
        }

        if( $email ){
            $query = $query->where( "email", "like", "%{$email}%" );
        }

        if( $company_id ){
            $query = $query->where( 'company_id', $company_id );
        }

        if( $status ){
            $query = $query->where( 'status', $status );
        }

        $result = $query->get();

        $handle = fopen('php://temp', 'w+');
        $header = ['First Name', 'Last Name', 'Email', 'Company', 'Primary Company', 'Industry', 'Status'];//, 'Primary Email'
        fputcsv($handle, $header);

        $filename = "data-".time().".csv";

        if( $result ){
            foreach ($result as $ar) {
                $row = [
                    $ar->first_name,
                    $ar->last_name,
                    $ar->email,
                    $ar->company->name,
                    $ar->company_parent->name ?? '',
                    $ar->industry->name,
                    // $ar->primary_email,
                    $ar->status == 0 ? 'Suspended' : 'Active',
                ];

                fputcsv($handle, $row);
            }
        }

        rewind($handle);
        $csvOutput = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csvOutput, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    /**
     *
     */
    public function viewCorporateEmailPDF( Request $request ){

        $this->setPublicVar();

        // Retrieve request parameters
        $first_name = $request->firstName;
        $last_name = $request->lastName;
        $email = $request->email;
        $company_id = $request->companyId;
        $status = $request->status;

        $query = CorporateEmail::select( 'industry_id', 'first_name', 'last_name', 'primary_email', 'email', 'status', 'company_parent_id', 'company_id' );

        if( !$this->is_assign_super_admin ){
            $query = $query->where( 'admin_id', $this->admin_id );
        }

        if( $first_name ){
            $query = $query->where( "first_name", "like", "%{$first_name}%" );
        }

        if( $last_name ){
            $query = $query->where( "last_name", "like", "%{$last_name}%" );
        }

        if( $email ){
            $query = $query->where( "email", "like", "%{$email}%" );
        }

        if( $company_id ){
            $query = $query->where( 'company_id', $company_id );
        }

        if( $status ){
            $query = $query->where( 'status', $status );
        }

        $result = $query->get();
        $rowData = [];
        if( $result ){
            foreach ($result as $ar) {
                $row = [
                    'first_name' => $ar->first_name,
                    'last_name' => $ar->last_name,
                    'email' => $ar->email,
                    'company' => $ar->company->name,
                    'parent_company' => $ar->company_parent->name ?? '',
                    'industry' => $ar->industry->name,
                    // 'primary_email' => $ar->primary_email,
                    'status' => $ar->status == 0 ? 'Suspended' : 'Active',
                ];

                $rowData[] = $row;
            }
        }

        // Customize data based on parameters
        $data = [
            'title' => 'Corporate Email(s)',
            'result' => $rowData
        ];

        // Generate the PDF
        $pdf = Pdf::loadView('backend.pages.corporate_email.pdf-view', $data)->setPaper('a4', 'landscape');

        return $pdf->download('corporate-email.pdf');
    }

    /**
     *
     */
    public function viewCompanyPDF( Request $request ){

        $this->setPublicVar();

        // Retrieve request parameters
        $industry_id = $request->industryId;
        $name = $request->companyName;
        $status = $request->status;

        $query = Company::select( 'industry_id', 'name', 'sort_name', 'website_link', 'status' );

        if( !$this->is_assign_super_admin ){
            $query = $query->where( 'admin_id', $this->admin_id );
        }

        if( $industry_id ){
            $query = $query->where( "industry_id", "like", "%{$industry_id}%" );
        }

        if( $name ){
            $query = $query->where( "name", "like", "%{$name}%" );
        }

        if( $status ){
            $query = $query->where( 'status', $status );
        }

        $result = $query->get();
        $rowData = [];
        if( $result ){
            foreach ($result as $ar) {
                $row = [
                    'name' => $ar->name,
                    'sort_name' => $ar->sort_name,
                    'website_link' => $ar->website_link,
                    'industry_name' => $ar->industry->name,
                    'status' => $ar->status == 0 ? 'De-Active' : 'Active',
                ];

                $rowData[] = $row;
            }
        }

        // Customize data based on parameters
        $data = [
            'title' => 'Company List(s)',
            'result' => $rowData
        ];

        // Generate the PDF
        $pdf = Pdf::loadView('backend.pages.companies.pdf-view', $data)->setPaper('a4', 'landscape');

        return $pdf->download('company.pdf');
    }

    /**
     *
     */
    public function viewDepartmentPDF( Request $request ){

        $this->setPublicVar();

        // Retrieve request parameters
        $industry_id = $request->industryId;
        $name = $request->departmentName;
        $status = $request->status;
        $company_id = $request->companyId;

        $query = Department::select( 'industry_id', 'company_id', 'name', 'status' );

        if( !$this->is_assign_super_admin ){
            $query = $query->where( 'admin_id', $this->admin_id );
        }

        if( $industry_id ){
            $query = $query->where( "industry_id", $industry_id );
        }

        if( $company_id ){
            $query = $query->where( "company_id", $company_id );
        }

        if( $name ){
            $query = $query->where( "name", "like", "%{$name}%" );
        }

        if( $status ){
            $query = $query->where( 'status', $status );
        }

        $result = $query->get();
        $rowData = [];
        if( $result ){
            foreach ($result as $ar) {
                $row = [
                    'name' => $ar->name,
                    'industry_name' => $ar->industry->name,
                    'company_name' => $ar->company->name,
                    'status' => $ar->status == 0 ? 'De-Active' : 'Active',
                ];

                $rowData[] = $row;
            }
        }

        // Customize data based on parameters
        $data = [
            'title' => 'Department List(s)',
            'result' => $rowData
        ];

        // Generate the PDF
        $pdf = Pdf::loadView('backend.pages.departments.pdf-view', $data)->setPaper('a4', 'landscape');

        return $pdf->download('department.pdf');
    }

    /**
     *
     */
    public function downloadClientMeetingCSV( Request $request ){

        $this->setPublicVar();

        // Retrieve request parameters
        $segment_id = $request->segment_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $status = $request->status;

        $query = PersonMeeting::where( 'client_id', '>', 0 );

        if( !$this->is_assign_super_admin ){
            $query = $query->where( 'admin_id', $this->admin_id );
        }

        if( $segment_id != "" && $segment_id != "null"){
            $query = $query->where( "segment_id", $segment_id );
        }

        if( $start_date != "" && $end_date != "" ){
            $query = $query->whereBetween('follow_up_date', [$start_date, $end_date]);
        } else {
            if( $start_date != "" ){
                $query = $query->where( "follow_up_date", ">=", $start_date );
            }

            if( $end_date != "" ){
                $query = $query->where( 'follow_up_date', "<=", $end_date );
            }
        }

        if( $status != "" ){
            $query = $query->where( 'status', $status );
        }

        $result = $query->get();

        $handle = fopen('php://temp', 'w+');
        $header = ['Unique ID', 'Client Name', 'Meeting Title', 'Time', 'Type', 'Remarks', 'Discussion', 'Status'];
        fputcsv($handle, $header);

        $filename = "data-".time().".csv";

        if( $result ){
            $statusArr = [
                'De-Active',
                'Active',
                'Hold',
                'On Going',
                'Complete'
            ];
            foreach ($result as $ar) {
                $row = [
                    $ar->client->unique_id,
                    $ar->client->first_name.' '.$ar->client->last_name,
                    $ar->title,
                    $ar->follow_up_date,
                    $ar->communication_type->name,
                    $ar->description,
                    $ar->follow_up_detail,
                    $statusArr[$ar->status],
                ];

                fputcsv($handle, $row);
            }
        }

        rewind($handle);
        $csvOutput = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csvOutput, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    /**
     *
     */
    public function viewClientMeetingPDF( Request $request ){

        $this->setPublicVar();

        // Retrieve request parameters
        $segment_id = $request->segment_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $status = $request->status;

        $query = PersonMeeting::where( 'client_id', '>', 0 );

        if( !$this->is_assign_super_admin ){
            $query = $query->where( 'admin_id', $this->admin_id );
        }

        if( $segment_id != "" && $segment_id != "null"){
            $query = $query->where( "segment_id", $segment_id );
        }

        if( $start_date != "" && $end_date != "" ){
            $query = $query->whereBetween('follow_up_date', [$start_date, $end_date]);
        } else {
            if( $start_date != "" ){
                $query = $query->where( "follow_up_date", ">=", $start_date );
            }

            if( $end_date != "" ){
                $query = $query->where( 'follow_up_date', "<=", $end_date );
            }
        }

        if( $status != "" ){
            $query = $query->where( 'status', $status );
        }

        // startQueryLog();
        $result = $query->get();
        // displayQueryResult();die;

        $rowData = [];
        if( $result ){

            $statusArr = [
                'De-Active',
                'Active',
                'Hold',
                'On Going',
                'Complete'
            ];

            foreach ($result as $ar) {
                $row = [
                    'unique_id' => $ar->client->unique_id,
                    'client_name' => $ar->client->first_name.' '.$ar->client->last_name,
                    'meeting_title' => $ar->title,
                    'date_time' => $ar->follow_up_date,
                    'type' => $ar->communication_type->name,
                    'remarks' => $ar->description,
                    'discussion' => $ar->follow_up_detail,
                    'status' => $statusArr[$ar->status],
                ];

                $rowData[] = $row;
            }
        }

        // Customize data based on parameters
        $data = [
            'title' => 'Client Meeting List(s)',
            'result' => $rowData
        ];

        // Generate the PDF
        $pdf = Pdf::loadView('backend.pages.client-meeting.pdf-view', $data)->setPaper('a4', 'landscape');

        return $pdf->download('client-meeting.pdf');
    }

    /**
     *
     */
    public function downloadCompanyMeetingCSV( Request $request ){

        $this->setPublicVar();

        // Retrieve request parameters
        $segment_id = $request->segment_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $status = $request->status;

        $query = CompanyMeeting::where( 'company_id', '>', 0 );

        if( !$this->is_assign_super_admin ){
            $query = $query->where( 'admin_id', $this->admin_id );
        }

        if( $segment_id != "" && $segment_id != "null"){
            $query = $query->where( "segment_id", $segment_id );
        }

        if( $start_date != "" && $end_date != "" ){
            $query = $query->whereBetween('follow_up_date', [$start_date, $end_date]);
        } else {
            if( $start_date != "" ){
                $query = $query->where( "follow_up_date", ">=", $start_date );
            }

            if( $end_date != "" ){
                $query = $query->where( 'follow_up_date', "<=", $end_date );
            }
        }

        if( $status != "" ){
            $query = $query->where( 'status', $status );
        }

        $result = $query->get();

        $handle = fopen('php://temp', 'w+');
        $header = [ 'Company Name', 'Meeting Title', 'Meeting date', 'Meeting Type', 'Short Description', 'Description', 'Discussion', 'Status'];
        fputcsv($handle, $header);

        $filename = "data-".time().".csv";

        if( $result ){
            $statusArr = [
                'De-Active',
                'Active',
                'Hold',
                'On Going',
                'Complete'
            ];
            foreach ($result as $ar) {
                $row = [
                    $ar->company->name,
                    $ar->title,
                    $ar->date,
                    $ar->communication_type->name,
                    $ar->short_description,
                    $ar->description,
                    $ar->follow_up_detail,
                    $statusArr[$ar->status],
                ];

                fputcsv($handle, $row);
            }
        }

        rewind($handle);
        $csvOutput = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csvOutput, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    /**
     *
     */
    public function viewCompanyMeetingPDF( Request $request ){

        $this->setPublicVar();

        // Retrieve request parameters
        $segment_id = $request->segment_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $status = $request->status;

        $query = CompanyMeeting::where( 'company_id', '>', 0 );

        if( !$this->is_assign_super_admin ){
            $query = $query->where( 'admin_id', $this->admin_id );
        }

        if( $segment_id != "" && $segment_id != "null"){
            $query = $query->where( "segment_id", $segment_id );
        }

        if( $start_date != "" && $end_date != "" ){
            $query = $query->whereBetween('follow_up_date', [$start_date, $end_date]);
        } else {
            if( $start_date != "" ){
                $query = $query->where( "follow_up_date", ">=", $start_date );
            }

            if( $end_date != "" ){
                $query = $query->where( 'follow_up_date', "<=", $end_date );
            }
        }

        if( $status != "" ){
            $query = $query->where( 'status', $status );
        }

        // startQueryLog();
        $result = $query->get();
        // displayQueryResult();die;

        $rowData = [];
        if( $result ){

            $statusArr = [
                'De-Active',
                'Active',
                'Hold',
                'On Going',
                'Complete'
            ];

            foreach ($result as $ar) {
                $row = [
                    'company_name' => $ar->company->name,
                    'meeting_title' => $ar->title,
                    'date_time' => $ar->follow_up_date,
                    'type' => $ar->communication_type->name,
                    'short_description' => $ar->short_description,
                    'description' => $ar->description,
                    'discussion' => $ar->follow_up_detail,
                    'status' => $statusArr[$ar->status],
                ];

                $rowData[] = $row;
            }
        }

        // Customize data based on parameters
        $data = [
            'title' => 'Client Meeting List(s)',
            'result' => $rowData
        ];

        // Generate the PDF
        $pdf = Pdf::loadView('backend.pages.companies.meeting-pdf-view', $data)->setPaper('a4', 'landscape');

        return $pdf->download('company-meeting.pdf');
    }
}
