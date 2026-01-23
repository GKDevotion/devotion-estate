<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;


class CategoryController extends Controller
{
    const WEBSITE_ID = 1;

    public function index()
    {
        $dataArr = Categories::where('website_id', self::WEBSITE_ID)->get();

        return view('backend.pages.category.index', compact('dataArr'));
    }

    public function create()
    {
        $parentArr = Categories::where('website_id', self::WEBSITE_ID)
            ->pluck('title', 'id');

        return view('backend.pages.category.create', compact('parentArr'));
    }

    public function store(Request $request)
    {
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
            Storage::makeDirectory('public/category');

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
        $dataArr = Categories::findOrFail($id);

        $parentArr = Categories::where('website_id', self::WEBSITE_ID)
            ->where('id', '!=', $id)
            ->pluck('title', 'id');

        return view('backend.pages.category.edit', compact('dataArr', 'parentArr'));
    }

    public function update(Request $request, $id)
    {
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

            Storage::makeDirectory('public/category');

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
