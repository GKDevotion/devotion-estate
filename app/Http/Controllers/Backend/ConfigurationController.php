<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public $user;

    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     $this->user = Auth::guard('admin')->user();
        //     return $next($request);
        // });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataArr = Configuration::get();
        return view('backend.pages.configurations.index', compact('dataArr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.configurations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation Data
        $request->validate([
            'display_name' => 'required',
            'key' => 'required',
            'value' => 'required',
        ]);

        $dataObj = new Configuration();
        $dataObj->display_name = $request->display_name;
        $dataObj->key = $request->key;
        $dataObj->value = $request->value;
        $dataObj->save();

        session()->flash('success', $dataObj->key.' has been created !!');
        return redirect()->route('admin.configurations.index');
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
        $data = Configuration::find($id);
        return view('backend.pages.configurations.edit', compact('data'));
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
        $request->validate([
            'display_name' => 'required',
            'key' => 'required',
            'value' => 'required',
        ]);

        $dataObj = Configuration::find( $id );
        $dataObj->display_name = $request->display_name;
        $dataObj->key = $request->key;
        $dataObj->value = $request->value;
        $dataObj->save();

        session()->flash('success', $dataObj->key.' has been updated !!');
        return redirect()->route('admin.configurations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $dataObj = Configuration::find($id);
        if (!is_null($dataObj)) {
            $dataObj->delete();
        }

        // session()->flash('success', $dataObj->name.' menu has been deleted !!');
        return response()->json( ['data' => ['message' => "'".$dataObj->key.'" has been successfully deleted.' ] ], 200);
    }
}
