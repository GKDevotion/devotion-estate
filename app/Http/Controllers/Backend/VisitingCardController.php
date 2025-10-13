<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CorporateDomain;
use App\Models\Person;
use App\Models\VisitingCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS2D;
use Yajra\DataTables\Facades\DataTables;

class VisitingCardController extends Controller
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
    public function index( Request $request )
    {
        // if (is_null($this->user) || !$this->user->can('visiting-card.view')) {
        //     abort(403, 'Sorry !! You are Unauthorized to view VisitingCard !');
        // }

        $this->setPublicVar();

        $where = [];
        if( !$this->is_assign_super_admin ){
            $where['admin_id'] = $this->admin_id;
        }

        return view('backend.pages.visiting-card.index');
    }

    /**
     *
     */
    public function ajaxIndex( Request $request ){

        $this->setPublicVar();

        $query = VisitingCard::query();

        if( !$this->is_assign_super_admin ){
            $query->where( 'admin_id', $this->admin_id );
        }

        return DataTables::eloquent($query)
            ->addColumn('id', function(VisitingCard $data) {
                return $data->id;
            })
            ->addColumn('qr_code', function(VisitingCard $data) {
                return $data->qr_code;
            })
            ->addColumn('avtar', function(VisitingCard $data) {
                return url( 'storage/'.$data->avtar );
            })
            ->addColumn('name', function(VisitingCard $data) {
                return $data->name;
            })
            ->addColumn('company', function(VisitingCard $data) {
                return $data->company->name;
            })
            ->addColumn('email', function(VisitingCard $data) {
                return $data->email;
            })
            ->addColumn('view', function(VisitingCard $data) {
                return $data->view;
            })
            ->addColumn('status', function(VisitingCard $data) {
                $status = "";
                if( true ){
                    $status = '<i class="fa fa-'.( $data->status == 0 ? 'times' : 'check').' update-status" data-status="'.$data->status.'" data-id="'.$data->id.'" aria-hidden="true" data-table="corporate_emails"></i>';
                } else {
                 $status = '<select class="form-control update-status badge '.( $data->status == 0 ? 'bg-warning' : 'bg-success').' text-white" name="status" data-id="'.$data->id.'" data-table="corporate_emails">
                            <option value="1" '.($data->status == 1 ? 'selected' : '').'>Active</option>
                            <option value="0" '.($data->status == 0 ? 'selected' : '').'>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function(VisitingCard $data) {
                return formatDate( "Y-m-d H:i", $data->updated_at );
            })
            ->addColumn('action', function(VisitingCard $data ) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_'.$data->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_'.$data->id.'">
                    ';

                    // if ($this->user->can('visiting-card.edit')) {
                        $action.= '<a class="btn btn-edit text-white dropdown-item" href="'.route('admin.visiting-card.edit', $data->id).'">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                    // }

                    // if ($this->user->can('visiting-card.delete')) {
                        $action.= '<button class="btn btn-edit text-white dropdown-item delete-record" data-id="'.$data->id.'" data-title="'.$data->name.'" data-segment="visiting-card">
                                        <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                                    </button>';
                    // }

                    $action.= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id', 'name', 'email', 'company', 'qr_code', 'avtar', 'view', 'updated_at', 'status', 'action'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    if( $searchValue != "" ){
                        $query->where('name', 'like', "%{$searchValue}%")
                            ->orWhere('domain_supplier', 'like', "%{$searchValue}%")
                            ->orWhere('ending_with', 'like', "%{$searchValue}%")
                            ->orWhere('email', 'like', "%{$searchValue}%");
                        }
                }
            })
            ->order(function ($query) {
                if (request()->has('order')) {
                    $orderColumn = request('order')[0]['column'];
                    $orderDirection = request('order')[0]['dir'];
                    $columns = request('columns');
                    $query->orderBy($columns[$orderColumn]['data'], $orderDirection);
                }
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (is_null($this->user) || !$this->user->can('visiting-card.create')) {
        //     abort(403, 'Sorry !! You are Unauthorized to create VisitingCard !');
        // }

        $companyArr = Company::where( 'status', 1 )->orderBy('name', 'asc')->pluck( 'name', 'id' );
        return view( 'backend.pages.visiting-card.create', compact( 'companyArr' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (is_null($this->user) || !$this->user->can('visiting-card.create')) {
        //     abort(403, 'Sorry !! You are Unauthorized to create VisitingCard !');
        // }

        return $this->storeDBData( $request );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        // if (is_null($this->user) || !$this->user->can('visiting-card.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized to edit VisitingCard !');
        // }

        $companyArr = Company::where( 'status', 1 )->orderBy('name', 'asc')->pluck( 'name', 'id' );
        $data = VisitingCard::find( $id );

        return view('backend.pages.visiting-card.edit', compact( 'data', 'companyArr' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        // if (is_null($this->user) || !$this->user->can('visiting-card.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized to edit VisitingCard !');
        // }

        return $this->storeDBData( $request, $id );
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return void
     */
    public function storeDBData( $request, $id=null ){

        // Validation Data
        $request->validate([
            'company_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'position' => 'required',
            'mobile_number' => 'required',
            'office_number' => 'required',
            'office_address_1' => 'required',
        ]);

        // Create New Server Record
        $dataObj = new VisitingCard();
        if( $id ){
            $dataObj = VisitingCard::find( $id );
        } else {

            $dataObj->admin_id = $this->user->id;
            $dataObj->company_id = $request->company_id;

            $employeeSlug = convertStringToSlug( $request->email, ['-', '@', '.'] );
            $dataObj->slug = $employeeSlug;

            $companyObj = Company::select( 'slug' )->find($request->company_id);

            $companySlug = $companyObj->slug;
            if ( str_ends_with( $companySlug, '-' ) ) {
                $companySlug = rtrim( $companySlug, '-');
            }

            $short_url = $companySlug."/".$employeeSlug;
            $dataObj->short_url = $short_url;
            $dataObj->status = 1;

            $barCodeURL = url('visiting-card') . '/' . $short_url;
            $storagePath = storage_path('app/QR/'); // Define the folder path
            $customFileName = str_ireplace( "/", "-", $short_url ).'.png';//."-".str_ireplace( [ "@", "."], "-", $request->email ) . '.png'; // Set custom filename
            $fullFilePath = $storagePath . $customFileName; // Full file path

            // Ensure the directory exists
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0777, true);
            }

            // Generate QR Code and save it
            $d1 = new DNS2D();
            $d1->setStorPath($storagePath);
            file_put_contents($fullFilePath, base64_decode($d1->getBarcodePNG($barCodeURL, "QRCODE", 7, 7)));

            // Get the file name and its URL
            $qrCodeFileName = $customFileName;
            $qrCodeURL = asset('storage/app/QR/' . $qrCodeFileName); // Adjust if needed for public access

            $dataObj->qr_code = $qrCodeURL;
        }

        $dataObj->name = $request->name;
        $dataObj->email = $request->email;
        $dataObj->mobile_number = $request->mobile_number;
        $dataObj->office_number = $request->office_number;
        $dataObj->position = $request->position;
        $dataObj->office_address_1 = $request->office_address_1;
        $dataObj->office_address_2 = $request->office_address_2;
        $dataObj->status = $request->status;
        $dataObj->facebook = $request->facebook;
        $dataObj->instagram = $request->instagram;
        $dataObj->tiktok = $request->tiktok;
        $dataObj->pinterest = $request->pinterest;
        $dataObj->snapchat = $request->snapchat;
        $dataObj->quora = $request->quora;
        $dataObj->linkedin = $request->linkedin;
        $dataObj->twitter = $request->twitter;
        $dataObj->youtube = $request->youtube;
        $dataObj->save();

        //save employee avtar or passport size photo
        if ($request->hasFile('avtar')) {

            $filename = str_ireplace( " ", "-", $dataObj->id."-".basename( $_FILES['avtar']['name'] ) );
            $folderName = "visiting-card/".$dataObj->id;

            // Create the folder
            Storage::makeDirectory( $folderName );

            // Set permissions to 777
            chmod(storage_path('app/'.$folderName), 0777);

            // $image = $request->file('avtar');
            $destinationPath = storage_path('/app/'.$folderName);
            $dataObj->avtar = null;
            if ( move_uploaded_file( $_FILES['avtar']['tmp_name'], $destinationPath.'/'.$filename ) ) {
                $dataObj->avtar = 'app/'.$folderName."/".$filename;
                $dataObj->save();
            }
        }


        session()->flash('success', $request->name.' record has been created !!');
        return redirect()->route('admin.visiting-card.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('visiting-card.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete VisitingCard !');
        }

        $record = CorporateDomain::find($id);
        if (!is_null($record)) {
            $record->delete();
        }

        // session()->flash('success', 'Record has been deleted !!');
        return response()->json( ['data' => ['message' => "'".$record->name.'" has been successfully deleted.' ] ], 200);
    }
}
