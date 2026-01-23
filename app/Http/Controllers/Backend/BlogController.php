<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Blog;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Categories;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
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
        if (is_null($this->user) || !$this->user->can('blog.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view Location !');
        }

        return view('backend.pages.blog.index');
    }

    /**
     *
     */
    // public function ajaxIndex( Request $request ){

    //     $this->setPublicVar();

    //     $query = Blog::query();

    //     if( !$this->is_assign_super_admin ){
    //         $query->where( 'admin_id', $this->admin_id );
    //     }

    //     $query->select('id', 'image', 'title', 'category_id','sub_category_id', 'updated_at', 'status');

    //     return DataTables::eloquent($query)
    //         ->addColumn('id', function(Blog $ar) {
    //             return $ar->id;
    //         })
    //         ->addColumn('image', function (Blog $ar) {
    //             return $ar->image;
    //         })
    //         ->addColumn('title', function(Blog $ar) {
    //             return $ar->title;
    //         })
    //         ->addColumn('category_id', function(Blog $ar) {
    //             return $ar->category_id;
    //         })

    //         ->addColumn('sub_category_id', function(Blog $ar) {
    //             return $ar->sub_category_id;
    //         })


    //         ->addColumn('status', function(Blog $ar) {
    //             $status = "";
    //             if( true ){
    //                 $status = '<i class="fa fa-'.( $ar->status == 0 ? 'times' : 'check').' update-status" data-status="'.$ar->status.'" data-id="'.$ar->id.'" aria-hidden="true" data-table="blogs"></i>';
    //             } else {
    //              $status = '<select class="form-control update-status badge '.( $ar->status == 0 ? 'bg-warning' : 'bg-success').' text-white" name="status" data-id="'.$ar->id.'" data-table="blogs">
    //                         <option value="1" '.($ar->status == 1 ? 'selected' : '').'>Active</option>
    //                         <option value="0" '.($ar->status == 0 ? 'selected' : '').'>De-Active</option>
    //                     </select>';
    //             }

    //             return $status;
    //         })
    //         ->addColumn('updated_at', function(Blog $ar) {
    //             return formatDate( "Y-m-d H:i", $ar->updated_at );
    //         })
    //         ->addColumn('action', function(Blog $ar ) {

    //             $action = '
    //                 <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_'.$ar->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    //                     &#x22EE;
    //                 </button>
    //                 <div class="dropdown-menu" aria-labelledby="action_menu_'.$ar->id.'">
    //                 ';

    //                 if ($this->user->can('blog.edit')) {
    //                     $action.= '<a class="btn btn-edit text-white dropdown-item" href="'.route('admin.blog.edit', $ar->id).'">
    //                         <i class="fa fa-pencil"></i> Edit
    //                     </a>';
    //                 }

    //                 if ($this->user->can('blog.delete')) {
    //                     $action.= '<button class="btn btn-edit text-white dropdown-item delete-record" data-id="'.$ar->id.'" data-title="'.$ar->category_id.'" data-segment="blogs">
    //                                     <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
    //                                 </button>';
    //                 }

    //                 $action.= '
    //                 </div>
    //             ';

    //             return $action;
    //         })
    //         ->rawColumns(['id','image', 'title', 'category_id', 'sub_category_id', 'updated_at', 'status', 'action'])  // Specify the columns that contain HTML
    //         ->filter(function ($query) {
    //             if (request()->has('search')) {
    //                 $searchValue = request('search')['value'];
    //                 if( $searchValue != "" ){
    //                     $query->where('name', 'like', "%{$searchValue}%")
    //                         ->orWhere('display_name', 'like', "%{$searchValue}%");
    //                     }
    //             }
    //         })
    //         ->order(function ($query) {
    //             if (request()->has('order')) {
    //                 $orderColumn = request('order')[0]['column'];
    //                 $orderDirection = request('order')[0]['dir'];
    //                 $columns = request('columns');
    //                 $query->orderBy($columns[$orderColumn]['data'], $orderDirection);
    //             }
    //         })
    //         ->make(true);
    // }

    public function ajaxIndex()
    {

        $query = Blog::query();
        $query->select('id', 'image', 'title', 'updated_at', 'status');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Blog $city) {
                return $city->id;
            })
            ->addColumn('image', function (Blog $city) {
                $url = $city->image ? asset('storage/app/blog/' . $city->image) : url('public/img/devotion-group-favicon.png');
                return '<img src="' . $url . '" width="250px" height="230px" style="object-fit:fill;">';
            })

            ->addColumn('title', function (Blog $city) {
                return $city->title; // Display the country name
            })

            ->addColumn('status', function (Blog $city) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($city->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $city->status . '" data-id="' . $city->id . '" aria-hidden="true" data-table="blogs"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($city->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $city->id . '" data-table="banners">
                            <option value="1" ' . ($city->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($city->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function (Blog $city) {
                return formatDate("Y-m-d H:i", $city->updated_at);
            })
            ->addColumn('action', function (Blog $city) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $city->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $city->id . '">
                    ';

                if ($this->user->can('blog.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.blog.edit', $city->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

                if ($this->user->can('blog.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $city->id . '" data-title="' . $city->title . '" data-segment="blog">
                    <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                    </button>';
                }

                $action .= '
                    </div>
                ';


                return $action;
            })
            ->rawColumns(['id', 'image', 'title',  'updated_at', 'status', 'action'])  // Specify the columns that contain HTML
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $searchValue = request('search')['value'];
                    $query->where('title', 'like', "%{$searchValue}%");
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
        if (is_null($this->user) || !$this->user->can('blog.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Location !');
        }

        $categories = Categories::with('childrenRecursive')->where(['status' => 1, 'parent_id' => 0])->get();

        $blogArr = Blog::select('id', 'title')->where([
            'status' => 1,
            'website_id' => 1,
        ])
            ->get();

        $tags = Tag::where('status', 1)->get(); // or Tag::all();

        $continentObj = Continent::where('status', 1)->get();
        return view('backend.pages.blog.create', compact('continentObj', 'blogArr', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('blog.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Location !');
        }

        // Validation Data
        $request->validate([
            'title' => 'required',

        ]);

        $location = $this->StoreUpdateData($request);
        session()->flash('success', $location->title . ' record has been created !!');
        return redirect()->route('admin.blog.index');
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
        if (is_null($this->user) || !$this->user->can('blog.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Location !');
        }

        $data = Blog::find($id);
        $categories = Categories::with('childrenRecursive')->where(['status' => 1, 'parent_id' => 0])->get();

        $blogArr = Blog::select('id', 'title')->where([
            'status' => 1,
            'website_id' => 1,
        ])
            ->get();

           // Get selected tag ids
        $selectedTags = $data->tags->pluck('id')->toArray();

        $tags = Tag::where('status', 1)->get();

        $continentObj = Continent::select('id', 'name')->where(['status' => 1])->get();
        $countryObj = Country::select('id', 'name')->where(['continent_id' => $data->continent_id, 'status' => 1])->get();
        $stateObj = State::select('id', 'name')->where(['country_id' => $data->country_id, 'status' => 1])->get();
        $cityObj = City::select('id', 'name')->where(['state_id' => $data->state_id, 'status' => 1])->get();

        return view('backend.pages.blog.edit', compact('data', 'continentObj', 'categories','tags', 'selectedTags','blogArr', 'countryObj', 'stateObj', 'cityObj'));
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
        if (is_null($this->user) || !$this->user->can('blog.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Location !');
        }

        // Validation Data
        $request->validate([
            'title' => 'required',

        ]);

        // // Create New Server Record
        // $location = Blog::find( $id );
        // $location->admin_id = $this->user->id;
        // $location->name = $request->name;
        // $location->display_name = $request->display_name;
        // $location->address = $request->address;
        // $location->continent_id = $request->continent_id;
        // $location->country_id = $request->country_id;
        // $location->state_id = $request->state_id;
        // $location->city_id = $request->city_id;
        // $location->zipcode = $request->zipcode;
        // $location->status = $request->status;
        // $location->save();

        $location = $this->StoreUpdateData($request, $id);

        session()->flash('success', $location->title . ' record has been updated !!');
        return redirect()->route('admin.blog.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('blog.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete Location !');
        }

        $record = Blog::find($id);

        if (!is_null($record)) {
            $record->delete();
        }

        // session()->flash('success', 'Record has been deleted !!');
        return response()->json(['data' => ['message' => "'" . $record->title . '" has been successfully deleted.']], 200);
    }



    public function StoreUpdateData(Request $request, int $id = null)
    {
        // ✅ Find or create model
        $location = $id ? Blog::findOrFail($id) : new Blog();
        $location->admin_id = 1;
        $location->category_id = $request->category_id;
        $location->sub_category_id = $request->sub_category_id;
        $location->slug = convertStringToSlug($request->title);
        $location->keyword = $request->keyword;
        $location->description = $request->description;
        $location->title = $request->title;
        $location->short_description = $request->short_description;
        $location->status = $request->status;

        // Handle Image Upload
        if ($request->hasFile('image')) {

            if ($id) {
                // Delete old image if exists
                if (!empty($location->image) && file_exists(storage_path('app/blog/' . $location->image))) {
                    unlink(storage_path('app/blog/' . $location->image));
                }
            }

            // Create folder if not exists
            if (!file_exists(storage_path('app/blog'))) {
                mkdir(storage_path('app/blog'), 0777, true);
            }

            $file = $request->file('image');
            // $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileName = $originalName . '.' . $extension;

            //     // start watermark code
            $img = Image::make($file->getRealPath());

            $imgWidth  = $img->width();
            $imgHeight = $img->height();

            $watermarkPath = public_path('img/devotion-trusted-real-estate.png');

            if (file_exists($watermarkPath)) {

                $watermark = Image::make($watermarkPath);

                $watermarkWidth = (int) ($imgWidth * 0.20);

                $watermark->resize($watermarkWidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $watermark->sharpen(5);

                $margin = (int) ($imgWidth * 0.015);

                $img->insert($watermark, 'bottom-right', $margin, $margin);
            }


            // save modified image to storage
            $img->save(storage_path('app/blog/' . $fileName));

            // Save filename in DB
            $location->image = $fileName;
        }

        $location->save();

        // Remove old tag mappings (important for update)
        DB::table('blog_tag_maps')
            ->where('blog_id', $location->id)
            ->delete();

        if ($request->filled('tags')) {

            $insertData = [];

            foreach ($request->tags as $tagId) {
                $insertData[] = [
                    'admin_id'       => 1,
                    'blog_id'        => $location->id,
                    'category_id'    => $request->category_id,
                    'sub_category_id' => $request->sub_category_id,
                    'tag_id'         => $tagId,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }

            DB::table('blog_tag_maps')->insert($insertData);
        }

        return $location;
    }
}
