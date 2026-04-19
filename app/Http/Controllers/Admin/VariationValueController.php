<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VariationValue;
use App\Models\VariationType;
use Illuminate\Http\Request;

class VariationValueController extends Controller
{
    public function index()
    {
        $variationTypes = VariationType::where('status', 1)->get();

        $variationValues = VariationValue::with('type')
            ->latest()
            ->get();

        return view('admin.products.products', compact(
            'variationTypes',
            'variationValues'
        ));
    }

    /* =========================
    CHECK DUPLICATE (AJAX)
    ========================= */
    public function check(Request $request)
    {
        $exists = VariationValue::where('variation_type_id', $request->variation_type_id)
            ->where('value_name', $request->value_name)
            ->when($request->id, function ($q) use ($request) {
                $q->where('id', '!=', $request->id);
            })
            ->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    /* =========================
    STORE
    ========================= */
    public function store(Request $request)
    {
        $request->validate([
            'variation_type_id' => 'required|exists:variation_types,id',
            'value_name' => 'required',
            'value_type' => 'required|in:text,color',
            'status' => 'required|in:0,1',
        ]);

        $row = VariationValue::create($request->all());

        $row->load('type');

        return response()->json([
            'status' => true,
            'message' => 'Created successfully',
            'data' => $row
        ]);
    }

    /* =========================
    EDIT
    ========================= */
    public function edit($id)
    {
        return response()->json([
            'status' => true,
            'data' => VariationValue::findOrFail($id)
        ]);
    }

    /* =========================
    UPDATE
    ========================= */
    public function update(Request $request, $id)
    {
        $row = VariationValue::findOrFail($id);

        $row->update($request->all());

        $row->load('type');

        return response()->json([
            'status' => true,
            'message' => 'Updated successfully',
            'data' => $row
        ]);
    }

    /* =========================
    DELETE
    ========================= */
    public function destroy($id)
    {
        VariationValue::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ]);
    }

    /* =========================
    STATUS TOGGLE
    ========================= */
    public function status($id)
    {
        $row = VariationValue::findOrFail($id);
        $row->status = !$row->status;
        $row->save();

        $row->load('type');

        return response()->json([
            'status' => true,
            'message' => 'Status updated',
            'data' => $row
        ]);
    }
}