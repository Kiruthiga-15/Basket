<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\VariationType;
use App\Models\VariationValue;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /* ===============================
    LIST PAGE
    =============================== */
    public function index()
    {
        $categories = Category::latest()->get();
        $variationTypes= VariationType::latest()->get();
        $variationValues= VariationValue::latest()->get();
        $products = Product::with([
            'category',
            'sizeValue',
            'colorValue'
        ])->latest()->get();
        
        return view(
            'admin.products.products',
            compact('categories','variationTypes','variationValues','products')
        );
    }


    /* ===============================
    CREATE
    =============================== */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|unique:categories,name',
            'image'  => 'required|image|mimes:jpg,jpeg,png,webp',
            'status' => 'required'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $imageName =
                time().'_'.
                Str::slug($request->name).'.'.
                $file->getClientOriginalExtension();

            $imagePath = $file->storeAs(
                'categories',
                $imageName,
                'public'
            );
        }

        $category = Category::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'image'       => $imagePath,
            'description' => $request->description,
            'status'      => $request->status
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Category Created Successfully',
            'data'    => $category

        ]);
    }


    /* ===============================
    GET SINGLE DATA FOR EDIT
    =============================== */
    public function edit($id)
    {
        $row = Category::findOrFail($id);

        return response()->json([
            'status' => true,
            'data'   => $row
        ]);
    }


    /* ===============================
    UPDATE
    =============================== */
    public function update(Request $request, $id)
    {
        $row = Category::findOrFail($id);

        $request->validate([
            'name'   => 'required|unique:categories,name,'.$id,
            'status' => 'required'
        ]);

        $imagePath = $row->image;

        if ($request->hasFile('image')) {

            if ($row->image) {
                Storage::disk('public')->delete($row->image);
            }

            $file = $request->file('image');

            $imageName =
                time().'_'.
                Str::slug($request->name).'.'.
                $file->getClientOriginalExtension();

            $imagePath = $file->storeAs(
                'categories',
                $imageName,
                'public'
            );
        }

        $row->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'image'       => $imagePath,
            'description' => $request->description,
            'status'      => $request->status
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Category Updated Successfully',
            'data'    => $row

        ]);
    }


    /* ===============================
    DELETE
    =============================== */
    public function destroy($id)
    {
        $row = Category::findOrFail($id);

        if ($row->image) {
            Storage::disk('public')->delete($row->image);
        }

        $row->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Category Deleted Successfully'
        ]);
    }

    public function changeStatus($id)
    {
        $row = Category::findOrFail($id);

        $row->status =
            $row->status == 1 ? 0 : 1;

        $row->save();

        return response()->json([
            'status'  => true,
            'message' => 'Status Updated',
            'data'    => $row
        ]);
    }
}