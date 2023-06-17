<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductGallery;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductGalleryController extends Controller
{
    public function index()
    {
        return view("pages.product-gallery.index")->with([
            "product_galleries" => ProductGallery::with("Product")->get()
        ]);
    }

    public function create()
    {
        return view("pages.product-gallery.create")->with([
            "products" => Product::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'is_default' => 'required|boolean'
        ]);
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data["image"] = $request->file("image")->store("product-gallery", "public");
            ProductGallery::create($data);
            DB::commit();
            return redirect()->route("admin.galeri.index")->with("success", "Data berhasil ditambah");
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function destroy(ProductGallery $galeri)
    {
        Storage::delete("public/" . $galeri->image);
        $galeri->delete();
        return redirect()->back()->with("success", "Data berhasil dihapus");
    }
}
