<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Transaction;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\InventoryItem;

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
        $user = User::find($transaction['userId']);

        $user->inventoryWorth += $transaction['boughtPrice'];
        $user->balance -= $transaction['boughtPrice'];
        if ($request->has('SoldPrice') && $request->input('SoldPrice') !== null) {
            $transaction['profit'] = $transaction['SoldPrice'] - $transaction['boughtPrice'];

            $user->inventoryWorth -= $transaction['boughtPrice'];
            $user->balance += $transaction['SoldPrice'];
        } else {
            $inventory = Inventory::where('userId', $transaction['userId'])->first();

            InventoryItem::create([
                'inventoryId' => $inventory['id'],
                'itemId' => $transaction['itemId'],
            ]);
        }

        $user->save();
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
        $oldBoughtPrice = $transaction->boughtPrice;
        $oldSoldPrice = $transaction->SoldPrice;
        $oldProfit = $transaction->profit;

        // Update transaction with new values
        $transaction->update($request->all());

        $user = User::find($transaction['userId']);
        $balanceChange = 0;
        $inventoryChange = 0;

        // Check if BoughtPrice is updated
        if ($oldBoughtPrice !== $transaction['boughtPrice']) {
            if (is_null($oldSoldPrice)) {

                $inventoryChange += $transaction['boughtPrice'] - $oldBoughtPrice;
            }

            $balanceChange -= $transaction['boughtPrice'] - $oldBoughtPrice;
        }

        // Check if SoldPrice is updated
        if ($oldSoldPrice !== $transaction->SoldPrice) {
            $balanceChange += $transaction->SoldPrice - $oldSoldPrice;

            // Check if there was an old SoldPrice
            if (!is_null($oldSoldPrice)) {
                // Change in profit is the new profit minus the old profit
                $profitChange = $transaction->profit - $oldProfit;

                $balanceChange += $profitChange; // Change in balance is the change in profit

                
            } else {
                $inventoryChange -= $transaction['boughtPrice'];
                $inventory = Inventory::where('userId', $transaction->userId)->first();
                $item = Item::find($transaction->itemId);
                $itemInventory = InventoryItem::where('inventoryId', $inventory->userId)->where('itemId', $item->id)->first();
                if ($itemInventory) {
                    $itemInventory->delete();
                }
            }
        }


        // Update user's balance and inventory
        $user->balance += $balanceChange;
        $user->inventoryWorth += $inventoryChange;
        $user->save();

        // Update profit based on the new BoughtPrice and SoldPrice
        if (!is_null($transaction->SoldPrice)) {
            $profit = $transaction->SoldPrice - $transaction->boughtPrice;
            $transaction->update(['profit' => $profit]);
        }



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
