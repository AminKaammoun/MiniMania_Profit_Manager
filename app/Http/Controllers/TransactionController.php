<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all()->toArray();
        return array_reverse($transactions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $transaction = new Transaction([  
            'itemId' => $request->input('itemId'),
            'userId' => $request->input('userId'),
    
            'boughtPrice' => $request->input('boughtPrice'),
            'SoldPrice' => $request->input('SoldPrice'),
            //'boughtDate' => $request->input('boughtDate'),
            //'soldDate' => $request->input('soldDate'), 
            //'profit' => $request->input('profit')
        ]);
        if($request->has('SoldPrice') && $request->input('SoldPrice') !== null){
            $transaction['profit'] = $transaction['SoldPrice'] - $transaction['boughtPrice'];
        }

        $transaction->save();

        return response()->json('Transaction created!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);
        return response()->json($transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        $transaction->update($request->all());
        return response()->json($transaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        return response()->json(['message' => 'Transaction deleted successfully']);
    }
}
