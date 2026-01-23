<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    const WEBSITE_ID = 1;
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index()
    {

        if (is_null($this->user) || !$this->user->can('category.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view City !');
        }
        $dataArr = Categories::where('website_id', self::WEBSITE_ID)->get();
        return view('backend.pages.category.index', compact('dataArr'));
    }

    public function ajaxIndex()
    {

        $query = Categories::query();
        $query->select('id', 'image',  'title', 'parent_id', 'slug', 'status', 'updated_at');

        return DataTables::eloquent($query)
            ->addColumn('id', function (Categories $city) {
                return $city->id;
            })
            ->addColumn('image', function (Categories $city) {
                $url = $city->image ? asset('storage/app/public/' . $city->image) : url('public/img/devotion-group-favicon.png');
                return '<img src="' . $url . '" width="200px" height="200px" style="object-fit:fill;">';
            })

            ->addColumn('title', function (Categories $city) {
                return $city->title; // Display the country name
            })
            ->addColumn('parent_id', function (Categories $category) {
                return $category->parent ? $category->parent->title : '-';
            })


            ->addColumn('slug', function (Categories $city) {
                return $city->slug; // Display the country name
            })

            ->addColumn('status', function (Categories $city) {
                $status = "";
                if (true) {
                    $status = '<i class="fa fa-' . ($city->status == 0 ? 'times' : 'check') . ' update-status" data-status="' . $city->status . '" data-id="' . $city->id . '" aria-hidden="true" data-table="categories"></i>';
                } else {
                    $status = '<select class="form-control update-status badge ' . ($city->status == 0 ? 'bg-warning' : 'bg-success') . ' text-white" name="status" data-id="' . $city->id . '" data-table="categories">
                            <option value="1" ' . ($city->status == 1 ? 'selected' : '') . '>Active</option>
                            <option value="0" ' . ($city->status == 0 ? 'selected' : '') . '>De-Active</option>
                        </select>';
                }

                return $status;
            })
            ->addColumn('updated_at', function (Categories $city) {
                return formatDate("Y-m-d H:i", $city->updated_at);
            })
            ->addColumn('action', function (Categories $city) {

                $action = '
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="action_menu_' . $city->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="action_menu_' . $city->id . '">
                    ';

                if ($this->user->can('category.edit')) {
                    $action .= '<a class="btn btn-edit text-white dropdown-item" href="' . route('admin.category.edit', $city->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                }

                if ($this->user->can('category.delete')) {
                    $action .= '<button class="btn btn-edit text-white delete-record dropdown-item" data-id="' . $city->id . '" data-title="' . $city->title . '" data-segment="category">
                    <i class="fa fa-trash fa-sm" aria-hidden="true"></i> Delete
                    </button>';
                }

                $action .= '
                    </div>
                ';


                return $action;
            })
            ->rawColumns(['id',  'image', 'title', 'parent_id', 'slug', 'status',   'updated_at', 'action'])  // Specify the columns that contain HTML
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

    public function create()
    {

        if (is_null($this->user) || !$this->user->can('category.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create category !');
        }

        $parentArr = Categories::where('website_id', self::WEBSITE_ID)
            ->pluck('title', 'id');

        return view('backend.pages.category.create', compact('parentArr'));
    }

    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('category.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Brochure !');
        }

        $request->validate([
            'title' => 'required|min:1|max:64',
        ]);

        $slug = convertStringToSlug($request->title);

        if (!empty($request->parent_id) && $request->parent_id != 0) {
            $parent = Categories::where([
                'website_id' => self::WEBSITE_ID,
                'id' => $request->parent_id
            ])->first();

            if ($parent) {
                $slug = convertStringToSlug($parent->title) . '-' . $slug;
            }
        }

        $category = new Categories();
        $manager = new ImageManager(['driver' => 'gd']);

        if ($request->hasFile('image')) {
             // Create folder if not exists
            if (!file_exists(storage_path('public/category'))) {
                mkdir(storage_path('public/category'), 0777, true);
            } 

            $image = $request->file('image');
            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();

            $path = storage_path('app/public/category/' . $filename);

            $manager->make($image)
                ->resize(1519, 417)
                ->save($path);

            $category->image = 'category/' . $filename;
        }


        $category->title = $request->title;
        $category->slug = $slug;
        $category->parent_id = $request->parent_id ?? 0;
        $category->website_id = self::WEBSITE_ID;
        $category->status = $request->status ?? 1;
        $category->save();

        return redirect()
            ->route('admin.category.index')
            ->with('message', 'Category successfully created');
    }

    public function edit($id)
    {

        if (is_null($this->user) || !$this->user->can('category.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Category !');
        }

        $dataArr = Categories::findOrFail($id);

        $parentArr = Categories::where('website_id', self::WEBSITE_ID)
            ->where('id', '!=', $id)
            ->pluck('title', 'id');

        return view('backend.pages.category.edit', compact('dataArr', 'parentArr'));
    }

    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('category.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create Category !');
        }

        $request->validate([
            'title' => 'required|min:1|max:64',
        ]);

        $category = Categories::findOrFail($id);
        $slug = convertStringToSlug($request->title);

        if (!empty($request->parent_id)) {
            $parent = Categories::where([
                'website_id' => self::WEBSITE_ID,
                'id' => $request->parent_id
            ])->first();

            if ($parent) {
                $slug = convertStringToSlug($parent->title) . '-' . $slug;
            }
        }


        $manager = new ImageManager(['driver' => 'gd']);

        if ($request->hasFile('image')) {
            if ($category->image && Storage::exists('public/' . $category->image)) {
                Storage::delete('public/' . $category->image);
            }

             // Create folder if not exists
            if (!file_exists(storage_path('public/category'))) {
                mkdir(storage_path('public/category'), 0777, true);
            }
 
            $image = $request->file('image');
            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();

            $path = storage_path('app/public/category/' . $filename);

            $manager->make($image)
                ->resize(1519, 417)
                ->save($path);

            $category->image = 'category/' . $filename;
        }


        $category->title = $request->title;
        $category->slug = $slug;
        $category->parent_id = $request->parent_id ?? 0;
        $category->website_id = self::WEBSITE_ID;
        $category->status = $request->status ?? 1;
        $category->save();

        return redirect()
            ->route('admin.category.index')
            ->with('message', 'Category successfully updated');
    }

    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('category.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit Category !');
        }
        $category = Categories::find($id);

        if ($category) {
            if ($category->image && Storage::exists('public/' . $category->image)) {
                Storage::delete('public/' . $category->image);
            }
            $category->delete();
        }

        return response()->json([
            'data' => ['message' => 'Category successfully deleted.']
        ], 200);
    }
}
