<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Inventory;

class UserInventoryController extends Controller
{

        public function index()
    {
        $inventories = Inventory::all()->toArray();
        return array_reverse($inventories);
    }

    public function show($id)
    {
        $user = User::find($id);
        $inventory = Inventory::where('userId', $user->id)->first();
        return response()->json($inventory);
    }
}