<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $slug = $request->input('slug');
        $limit = $request->input('limit', 6);

        $product = Product::with('ProductGalleries');

        if ($slug) {
            $product = Product::with('ProductGalleries')->whereSlug($slug)->first();

            if ($product) {
                return ResponseFormatter::success($product, "Data produk berhasil diambil");
            } else {
                return ResponseFormatter::error(null, "Data produk tidak ditemukan", 404);
            }
        }

        return ResponseFormatter::success($product->paginate($limit), 'Data list produk berhasil diterima');
    }
}
