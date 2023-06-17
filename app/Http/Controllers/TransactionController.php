<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return view("pages.transaction.index")->with([
            "transactions" => Transaction::with(["TransactionDetails", "TransactionDetails.Product", "User"])->get()
        ]);
    }

    public function show(Transaction $transaksi)
    {
        $transaksi = Transaction::with(["TransactionDetails", "TransactionDetails.Product", "User"])->findOrFail($transaksi->id);

        return response()->json($transaksi);
    }
}
