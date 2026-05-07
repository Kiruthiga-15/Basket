<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /* ==========================
       STORE
    ========================== */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|unique:products,name',
            'price' => 'required',
            'status' => 'required'
        ]);

        $mainImage = null;

        if ($request->hasFile('main_image')) {

            $file = $request->file('main_image');

            $imageName =
                time().'_'.
                Str::slug($request->name).'.'.
                $file->getClientOriginalExtension();

            $mainImage = $file->storeAs(
                'products',
                $imageName,
                'public'
            );
        }

        $product = Product::create([
            'category_id' => $request->category_id,

            'variation_type_size_id' => $request->variation_type_size_id,
            'variation_value_size_id' => $request->variation_value_size_id,

            'variation_type_color_id' => $request->variation_type_color_id,
            'variation_value_color_id' => $request->variation_value_color_id,

            'name' => $request->name,
            'slug' => Str::slug($request->name),

            'price' => $request->price,
            'discount_price' => $request->discount_price,

            'sku' => $request->sku,
            'stock' => $request->stock,

            'delivery_charge' => $request->delivery_charge,

            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,

            'main_image' => $mainImage,

            'short_description' => $request->short_description,
            'long_description' => $request->long_description,

            'status' => $request->status
        ]);

        if ($request->hasFile('gallery')) {

            foreach ($request->file('gallery') as $file) {

                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $path = $file->storeAs(
                    'products/gallery',
                    $name,
                    'public'
                );

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Product Created Successfully',
            'data' => $product
        ]);
    }

    /* ==========================
       EDIT
    ========================== */
    public function edit($id)
    {
        $row = Product::with('images')->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $row
        ]);
    }

    /* ==========================
       UPDATE
    ========================== */
    public function update(Request $request, $id)
    {
        $row = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:products,name,'.$id,
            'price' => 'required',
            'status' => 'required'
        ]);

        $mainImage = $row->main_image;
 
        if ($request->hasFile('main_image')) {

            if ($row->main_image) {
                Storage::disk('public')->delete($row->main_image);
            }

            $file = $request->file('main_image');

            $imageName =
                time().'_'.
                Str::slug($request->name).'.'.
                $file->getClientOriginalExtension();

            $mainImage = $file->storeAs(
                'products',
                $imageName,
                'public'
            );
        }

        $row->update([

            'category_id' => $request->category_id,

            'variation_type_size_id' => $request->variation_type_size_id,
            'variation_value_size_id' => $request->variation_value_size_id,

            'variation_type_color_id' => $request->variation_type_color_id,
            'variation_value_color_id' => $request->variation_value_color_id,

            'name' => $request->name,
            'slug' => Str::slug($request->name),

            'price' => $request->price,
            'discount_price' => $request->discount_price,

            'sku' => $request->sku,
            'stock' => $request->stock,

            'delivery_charge' => $request->delivery_charge,

            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,

            'main_image' => $mainImage,

            'short_description' => $request->short_description,
            'long_description' => $request->long_description,

            'status' => $request->status
        ]);

        if ($request->hasFile('gallery')) {

            // save new images (don't delete existing ones)
            foreach ($request->file('gallery') as $file) {

                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $path = $file->storeAs(
                    'products/gallery',
                    $name,
                    'public'
                );

                ProductImage::create([
                    'product_id' => $row->id,
                    'image' => $path
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Product Updated Successfully',
            'data' => $row
        ]);
    }

    /* ==========================
       DELETE
    ========================== */
    public function destroy($id)
    {
        $row = Product::findOrFail($id);

        if ($row->main_image) {
            Storage::disk('public')->delete($row->main_image);
        }

        $row->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product Deleted Successfully'
        ]);
    }

    /* ==========================
       STATUS
    ========================== */
    public function changeStatus($id)
    {
        $row = Product::findOrFail($id);

        $row->status =
            $row->status == 1 ? 0 : 1;

        $row->save();

        return response()->json([
            'status' => true,
            'message' => 'Status Updated',
            'data' => $row
        ]);
    }

    /* ==========================
       DELETE IMAGE
    ========================== */
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);

        if ($image->image) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return response()->json([
            'status' => true,
            'message' => 'Image Deleted Successfully'
        ]);
    }
}