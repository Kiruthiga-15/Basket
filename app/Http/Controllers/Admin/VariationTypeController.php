<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VariationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VariationTypeController extends Controller
{
    

    /* =========================
    STORE
    ========================= */
    public function store(Request $request)
    {
        Log::info('Variation Type Store', $request->all());

        $request->validate([
            'name' => 'required|unique:variation_types,name',
            'status' => 'required|in:0,1'
        ]);

        try {

            $row = VariationType::create([
                'name' => $request->name,
                'status' => $request->status
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Variation Type Created',
                'data' => $row
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Variation already exists'
            ]);
        }
    }

    /* =========================
    EDIT
    ========================= */
    public function edit($id)
    {
        $row = VariationType::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $row
        ]);
    }

    /* =========================
    UPDATE
    ========================= */
    public function update(Request $request, $id)
    {
        $row = VariationType::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:variation_types,name,' . $id,
            'status' => 'required|in:0,1'
        ]);

        $row->update([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Variation Type Updated',
            'data' => $row
        ]);
    }

    /* =========================
    DELETE
    ========================= */
    public function destroy($id)
    {
        VariationType::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully'
        ]);
    }

    /* =========================
    STATUS TOGGLE
    ========================= */
    public function status($id)
    {
        $row = VariationType::findOrFail($id);

        $row->status = !$row->status;

        $row->save();

        return response()->json([
            'status' => true,
            'message' => 'Status Updated',
            'data' => $row
        ]);
    }
}