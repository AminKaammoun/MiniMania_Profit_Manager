<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::all()->toArray();
        return array_reverse($types);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = new Type([
            'name' => $request->input('name')
          
        ]);
        $type->save();

        return response()->json('Type created!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $type = Type::find($id);
        return response()->json($type);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $type = Type::find($id);
        $type->update($request->all());
        return response()->json($type);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $type = Type::find($id);
        $type->delete();
        return response()->json(['message' => 'Type deleted successfully']);
    }
}
