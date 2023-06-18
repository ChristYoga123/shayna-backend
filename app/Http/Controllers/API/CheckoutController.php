<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Midtrans\Config::$clientKey = env("MIDTRANS_CLIENTKEY");
        Midtrans\Config::$serverKey = env("MIDTRANS_SERVERKEY");
        Midtrans\Config::$isSanitized = env("MIDTRANS_IS_SANITIZED");
        Midtrans\Config::$isProduction = env("MIDTRANS_IS_PRODUCTION");
        Midtrans\Config::$is3ds = env("MIDTRANS_IS_3DS");
    }

    public function index(Transaction $transaction)
    {
        $product = Transaction::with("TransactionDetails.Product")->findOrFail($transaction->id);
        if ($product)
            return ResponseFormatter::success($product, "Data ditemukan");
        return ResponseFormatter::error("Data tidak ditemukan", 404);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|max:255",
            "email" => "required|email|max:255",
            "phone_number" => "required|numeric",
            "shipping_address" => "required",
            "transaction_details" => "required|array",
            "transaction_details.*" => "integer|exists:products,id",
        ]);

        DB::beginTransaction();
        try {
            $total = 0;

            // get total transaction
            foreach ($request->transaction_details as $product) {
                $price = Product::find($product);
                $total += $price->price;
            }
            // insert transaction
            $transaction = Transaction::create([
                "name" => $request->name,
                "email" => $request->email,
                "phone_number" => $request->phone_number,
                "shipping_address" => $request->shipping_address,
                "total" => $total,
            ]);
            // insert transaction detail
            foreach ($request->transaction_details as $index => $transaction_detail) {
                $details[] = new TransactionDetail([
                    "transaction_id" => $transaction->id,
                    "product_id" => $transaction_detail,
                ]);

                Product::find($transaction_detail)->decrement("quantity");
            }

            $transaction->TransactionDetails()->saveMany($details);

            // Midtrans API
            $parameter = [
                "transaction_details" => [
                    "order_id" => $transaction->id . "-" . Str::random(9),
                    "gross_amount" => $transaction->total
                ],
            ];
            //code...
            $payment_url = \Midtrans\Snap::createTransaction($parameter)->redirect_url;
            $transaction->midtrans_booking_code = $parameter["transaction_details"]["order_id"];
            $transaction->midtrans_url = $payment_url;
            $transaction->save();
            DB::commit();
            return ResponseFormatter::success($transaction, "Data transaksi berhasil ditambah");
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error(null, $e->getMessage());
        }
    }

    public function midtransCallback(Request $request)
    {
        $notif = $request->method() == 'POST' ? new Midtrans\Notification() : Midtrans\Transaction::status($request->order_id);

        $transaction_status = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        $transaction_id = explode('-', $notif->order_id[0]);
        $transaction = Transaction::find($transaction_id)->first();
        if ($transaction_status == 'capture') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'challenge'
                $transaction->payment_status = 'pending';
            } else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'success'
                $transaction->payment_status = 'paid';
            }
        } else if ($transaction_status == 'cancel') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'failure'
                $transaction->payment_status = 'failed';
            } else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'failure'
                $transaction->payment_status = 'failed';
            }
        } else if ($transaction_status == 'deny') {
            // TODO Set payment status in merchant's database to 'failure'
            $transaction->payment_status = 'failed';
        } else if ($transaction_status == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            $transaction->payment_status = 'paid';
        } else if ($transaction_status == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            $transaction->payment_status = 'pending';
        } else if ($transaction_status == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $transaction->payment_status = 'failed';
        }
        $transaction->save();
        return ResponseFormatter::success([
            "transaction" => "success"
        ], "Pembayaran berhasil masuk");
    }
}
