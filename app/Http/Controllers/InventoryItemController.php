<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem; 
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itemInventors = InventoryItem::all()->toArray();
        return array_reverse($itemInventors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $itemInventor = new InventoryItem([
            'inventoryId' => $request->input('inventoryId'), 
            'itemId' => $request->input('itemId'),
          
        ]);
        $itemInventor->save();

        return response()->json('ItemInventor created!');
    }

    /**
     * Display the specified resource.
     */
    public function show($inventoryId)
    {
        
        $inventoryItems = InventoryItem::where('inventoryId', $inventoryId)->get();
    
        return response()->json($inventoryItems);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $itemInventor = InventoryItem::find($id);
        $itemInventor->update($request->all());
        return response()->json($itemInventor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $itemInventor = InventoryItem::find($id);
        $itemInventor->delete();
        return response()->json(['message' => 'ItemInventor deleted successfully']);
    }
}
