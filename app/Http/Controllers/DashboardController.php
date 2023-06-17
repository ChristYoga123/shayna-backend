<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $income = Transaction::wherePaymentStatus("paid")->sum("total");
        $sales = Transaction::count();
        $items = Transaction::with("TransactionDetails", "TransactionDetails.Product", "User")->orderBy("id", "DESC")->take(5)->get();
        $pie = [
            "waiting" => Transaction::wherePaymentStatus("waiting")->count(),
            "paid" => Transaction::wherePaymentStatus("paid")->count(),
            "failed" => Transaction::wherePaymentStatus("failed")->count(),
        ];

        return view("pages.dashboard.index")->with([
            "income" => $income,
            "sales" => $sales,
            "items" => $items,
            "pie" => $pie
        ]);
    }
}
