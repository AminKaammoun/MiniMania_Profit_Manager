<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all()->toArray();
        return array_reverse($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $item = new Item([
            'nameEn' => $request->input('nameEn'),
            'namePt' => $request->input('namePt'),
            'type' => $request->input('type'),
            'category' => $request->input('category'),
            'image' => $request->input('image')
        ]);
        $item->save();

        return response()->json('Item created!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = Item::find($id);
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        $item->update($request->all());
        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();
        return response()->json(['message' => 'Item deleted successfully']);
    }
}
