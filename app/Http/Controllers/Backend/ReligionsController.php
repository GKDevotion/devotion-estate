<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Religion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReligionsController extends Controller
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
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('religion.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Religions !');
        }

        $dataArr = Religion::select('id', 'name', 'status', 'updated_at')->get();
        return view('backend.pages.religions.index', compact('dataArr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('religion.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Religions !');
        }

        return view('backend.pages.religions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('religion.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Religions !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
        ]);

        // Create New Server Record
        $dataObj = new Religion();
        $dataObj->name = $request->name;
        $dataObj->status = $request->status;
        $dataObj->save();

        session()->flash('success', 'Record has been created !!');
        return redirect()->route('admin.religion.index');
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
        if (is_null($this->user) || !$this->user->can('religion.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Religions !');
        }

        $data = Religion::find($id);
        return view('backend.pages.religions.edit', compact('data'));
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
        if (is_null($this->user) || !$this->user->can('religion.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Religions !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
        ]);

        // Create New Server Record
        $dataObj = Religion::find( $id );
        $dataObj->name = $request->name;
        $dataObj->status = $request->status;
        $dataObj->save();

        session()->flash('success', 'Records has been updated !!');
        return redirect()->route('admin.religion.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('religion.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete Religions !');
        }

        $dataObj = Religion::find($id);
        if ( $dataObj ) {
            $dataObj->delete();
            return response()->json( ['data' => ['message' => $dataObj->name.' record has been successfully deleted.'] ], 200 );
        } else {
            return response()->json( ['data' => ['message' => 'Record already deleted.'] ], 200);
        }
    }
}
