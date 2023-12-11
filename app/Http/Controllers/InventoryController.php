<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::all()->toArray();
        return array_reverse($inventories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inventory = new Inventory([
            'userId' => $request->input('userId')
        ]);
        $inventory->save();
        return response()->json("Inventory created!");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inventory = Inventory::find($id);
        return response()->json($inventory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $inventory = Inventory::find($id);
        $inventory->update($request->all());

        return response()->json($inventory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inventory = Inventory::find($id);
        $inventory->delete();

        return response()->json(['message' => 'Inventory deleted successfully']);
    }
}
