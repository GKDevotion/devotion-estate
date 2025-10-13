<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use App\Models\Company;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoardMemberController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        if (is_null($this->user) || !$this->user->can('board-member.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any Board Member !');
        }

        $where = [];
        if( $request->cid ){
            $where['company_id'] = _de( $request->cid );
        } else if( $request->iid ){
            $where['industry_id'] = _de( $request->iid );
        }

        $datas = BoardMember::with('company', 'industry')->where( $where )->get();

        return view('backend.pages.board-member.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('board-member.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any Board Member !');
        }

        $companies  = Company::select('id', 'name', 'industry_id')->where(['status' => 1])->get();
        $industries  = Industry::select('id', 'name')->where(['status' => 1])->get();
        return view('backend.pages.board-member.create', compact('companies', 'industries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('board-member.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any Board Member !');
        }

        // Validation Data
        $request->validate([
            'first_name' => 'required|max:25',
            'middle_name' => 'required|max:25',
            'last_name' => 'required|max:25',
            'email' => 'required|max:100|email|unique:board_members',
            'mobile_number' => 'required',
            'industry_id' => 'required',
            'company_id' => 'required',
        ]);

        // Create New Admin
        $dataObj = new BoardMember();
        $dataObj->first_name = $request->first_name;
        $dataObj->middle_name = $request->middle_name;
        $dataObj->last_name = $request->last_name;
        $dataObj->email = $request->email;
        $dataObj->mobile_number = $request->mobile_number;
        $dataObj->industry_id = $request->industry_id;
        $dataObj->company_id = $request->company_id;
        $dataObj->save();

        session()->flash('success', $dataObj->first_name. ' '.$dataObj->last_name.' has been created !!');
        return redirect()->route('admin.board-member.index');
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
        if (is_null($this->user) || !$this->user->can('board-member.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any Board Member !');
        }

        $dataObj = BoardMember::find($id);
        $companies  = Company::select('id', 'name', 'industry_id')->where(['status' => 1])->get();
        $industries  = Industry::select('id', 'name')->where(['status' => 1])->get();
        return view('backend.pages.board-member.edit', compact('dataObj', 'companies', 'industries'));
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
        if (is_null($this->user) || !$this->user->can('admin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }

        // Validation Data
        $request->validate([
            'first_name' => 'required|max:25',
            'middle_name' => 'required|max:25',
            'last_name' => 'required|max:25',
            'email' => 'required|max:100|email|unique:board_members',
            'mobile_number' => 'required',
            'industry_id' => 'required',
            'company_id' => 'required',
        ]);

        $dataObj = BoardMember::find($id);
        $dataObj->first_name = $request->first_name;
        $dataObj->middle_name = $request->middle_name;
        $dataObj->last_name = $request->last_name;
        $dataObj->email = $request->email;
        $dataObj->mobile_number = $request->mobile_number;
        $dataObj->industry_id = $request->industry_id;
        $dataObj->company_id = $request->company_id;
        $dataObj->save();

        session()->flash('success', $dataObj->first_name. ' '.$dataObj->last_name.' has been updated !!');
        return redirect()->route('admin.admin.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('board-member.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any Board Member !');
        }

        $dataObj = BoardMember::find($id);
        if (!is_null($dataObj)) {
            $dataObj->delete();
        }

        session()->flash('success', $dataObj->first_name. ' '.$dataObj->last_name.' has been deleted !!');
        return back();
    }

    /**
     *
     */
    public function updateFieldStatus($table, $id, $status)
    {
        DB::table($table)->where('id', $id)->update(['status' => $status]);

        $response = [
            'success' => true,
            'data'    => "",
            'message' => $table." status update successfully.",
        ];

        return response()->json($response, 200);
    }
}
