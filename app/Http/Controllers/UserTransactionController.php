<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Transaction;

class UserTransactionController extends Controller
{

        public function index()
    {
        $transactions = Transaction::all()->toArray();
        return array_reverse($transactions);
    }

    public function show($userId)
    {
        
        $trans = Transaction::where('userId', $userId)->get();
    
        return response()->json($trans);
    }
   
}