<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Designations;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AgentsController extends Controller
{

    public $user;
    public $is_assign_super_admin = 0;
    public $admin_id = 0;
    public $user_type = 4; //	1: User, 2: Owner, 3: Client, 4: Agent

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
    public function setPublicVar()
    {
        $this->is_assign_super_admin = $this->user->is_assign_super_admin;
        $this->admin_id = $this->user->id;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('agents.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Agents !');
        }

        return view('backend.pages.agents.index', compact('request'));
    }

    /**
     *
     */
    public function ajaxIndex(Request $request)
    {

        $this->setPublicVar();

        $query = User::query();

        $query->where('type', $this->user_type);

        return DataTables::eloquent($query)
            ->addColumn('id', function (User $dt) {
                return $dt->id;
            })

            ->addColumn('image', function (User $dt) {
                $url = asset('storage/app/public/agent/' . $dt->image);

                return '<img src="' . $url . '" width="100" height="100" style="object-fit:cover; border-radius:5px;">';
            })

            ->addColumn('name', function (User $dt) {
                return $dt->first_name . " " . $dt->last_name;
            })
            ->addColumn('email_id', function (User $dt) {
                return $dt->email_id;
            })
            ->addColumn('login_by', function (User $dt) {
                return $dt->login_by;
            })
            ->addColumn('designtation', function (User $dt) {
                return $dt->designation->name ?? '';
            })
            ->addColumn('status', function (User $dt) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($dt->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $dt->status . '" data-id="' . $dt->id . '" aria-hidden="true" data-table="users"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($dt->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $dt->id . '" data-table="users">
                            <option value="1" ' . ($dt->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($dt->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })

            ->addColumn('created_at', function (User $dt) {
                return formatDate("Y-m-d H:i", $dt->created_at);
            })
            ->addColumn('updated_at', function (User $dt) {
                return formatDate("Y-m-d H:i", $dt->updated_at);
            })
            ->addColumn('action', function (User $dt) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $dt->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $dt->id . '">
                    ';

                if ($this->user->can('agents.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.agents.edit', $dt->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

            // if ($this->user->can('agents.delete')) {
            //     $action .= '<button class="btn btn-edit text-white dropdown-item delete-record" data-id="' . $dt->id . '" data-title="' . $dt->name . '" data-segment="users">
            //                         <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
            //                     </button>';
            // }
            if ($this->user->can('agents.delete')) {
                $action .= '<form method="POST" action="' .  route('admin.agents.destroy', $dt->id) . '" style="display:inline;">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-edit text-white dropdown-item" onclick="return confirm(\'Are you sure you want to delete ' . $dt->name . '?\');">
                        <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                    </button>
                </form>';
            }
                $action .= '
                    </div>
                ';

                return $action;
            })
            ->rawColumns(['id','image', 'name', 'email', 'login_by', 'designtation', 'created_at', 'updated_at', 'status', 'action'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    if ($searchValue != "") {
                        $query->where('name', 'like', "%{$searchValue}%")
                            ->orWhereHas('industry', function ($q) use ($searchValue) {
                                $q->where('name', 'like', "%{$searchValue}%");
                            })
                            ->orWhereHas('company', function ($q) use ($searchValue) {
                                $q->where('name', 'like', "%{$searchValue}%");
                            });
                        // ->orWhere('email', 'like', "%{$searchValue}%");
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
        if (is_null($this->user) || !$this->user->can('agents.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create user !');
        }

        $designationObj = Designations::select('id', 'name')->where('status', 1)->get();
        return view('backend.pages.agents.create', compact('designationObj'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('agents.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create User!');
        }

        // Validation Data
        $request->validate([
            'login_by' => 'required|max:20',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email_id' => 'required|max:50|email', //|unique:users',
            'password' => 'required|min:6',
            'mobile_no' => 'required',
            'designation_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', 

        ]);

        $imageName = null;

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            if ($file->isValid()) {

                if (!Storage::exists('public/agent')) {
                    Storage::makeDirectory('public/agent', 0777, true);
                }

                $imageName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $file->storeAs('public/agent', $imageName);
            } else {
                return back()->withErrors(['image' => 'The image failed to upload properly.']);
            }
        }

        // Create New User
        $user = new User();
        $user->login_by = $request->login_by;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->designation_id = $request->designation_id;
        $user->admin_id = $this->user->id;
        $user->email_id = $request->email_id;
        $user->password = Hash::make($request->password);
        $user->mobile_no = $request->mobile_no;
        $user->login = $request->login;
        $user->status = $request->status;
        $user->type = $this->user_type;

        $user->image = $imageName;
        $user->save();

        // $userAddress = new Address();
        // $userAddress->admin_id  = $this->user->id;
        // $userAddress->person_id = $user->id;
        // $userAddress->name = $user->first_name . " " . $user->last_name;
        // $userAddress->continent_id = $request->continent_id;
        // $userAddress->country_id = $request->country_id;
        // $userAddress->state_id = $request->state_id;
        // $userAddress->city_id = $request->city_id;
        // $userAddress->zipcode = $request->zipcode;
        // $userAddress->address = $request->address;
        // $userAddress->person_type = $this->user_type;
        // $userAddress->save();

        session()->flash('success', $user->login_by.' has been created !!');
        return redirect()->route('admin.agents.index');
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
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('agents.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Agents !');
        }

        $dataObj = User::find($id);
        $designationObj = Designations::select('id', 'name')->where('status', 1)->get();
        return view('backend.pages.agents.edit', compact('dataObj', 'designationObj'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('agents.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Agent !');
        }

        // Create New User
        $user = User::find($id);

        // Validation Data
        $request->validate([
            'login_by' => 'required|max:20',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email_id' => 'required|max:50|email', //|unique:users',
            // 'password' => 'required|min:6',
            'designation_id' => 'required',
            'mobile_no' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', 
        ]);


        $imageName = $user->image; // keep old image

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            if ($file->isValid()) {

                // Make folder if missing
                if (!Storage::exists('public/agent')) {
                    Storage::makeDirectory('public/agent');
                }

                // Delete old image
                if ($user->image && Storage::exists('public/agent/' . $user->image)) {
                    Storage::delete('public/agent/' . $user->image);
                }

                // Upload new image
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/agent', $imageName);
            }
        }

        $user->login_by = $request->login_by;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->designation_id = $request->designation_id;
        $user->admin_id = $this->user->id;
        $user->email_id = $request->email_id;
        $user->mobile_no = $request->mobile_no;
        $user->login = $request->login;
        $user->status = $request->status;
        $user->type = $this->user_type;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->image = $imageName;
        $user->save();

        // $userAddress = Address::find($request->address_id);
        // $userAddress->admin_id  = $this->user->id;
        // $userAddress->person_id = $user->id;
        // $userAddress->name = $user->first_name . " " . $user->last_name;
        // $userAddress->continent_id = $request->continent_id;
        // $userAddress->country_id = $request->country_id;
        // $userAddress->state_id = $request->state_id;
        // $userAddress->city_id = $request->city_id;
        // $userAddress->zipcode = $request->zipcode;
        // $userAddress->address = $request->address;
        // $userAddress->person_type = $this->user_type;
        // $userAddress->save();

        // session()->flash('success', 'User has been updated !!');
        session()->flash('success', $user->first_name . " " . $user->last_name . ' has been updated !!');
        return redirect()->route('admin.agents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('agents.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete Agents !');
        }

        $user = User::find($id);
        if ( $user ) {

            Address::where([
                'person_id' => $id,
                'person_type' => $this->user_type
            ])->delete();

            $user->delete();
        }

        // session()->flash('success', 'User has been deleted !!');
        return response()->json(['data' => ['message' => "'" . $user->name . '" has been successfully deleted.']], 200);
    }
}
