<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductGallery;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.product.index")->with([
            "products" => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.product.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|max:255',
            'description' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|integer'
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data["slug"] = Str::slug($request->name);
            Product::create($data);
            DB::commit();
            return redirect()->route("admin.barang.index")->with("success", "Data berhasil ditambah");
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $barang)
    {
        return view("pages.product.show")->with([
            "product" => $barang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $barang)
    {
        return view("pages.product.edit")->with([
            "product" => $barang
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $barang)
    {
        $request->validate([
            'name' => 'required|max:255|unique:products,name,' . $barang->id,
            'type' => 'required|max:255',
            'description' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|integer'
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data["slug"] = Str::slug($request->name);
            $barang->update($data);
            DB::commit();
            return redirect()->route("admin.barang.index")->with("success", "Data berhasil diubah");
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $barang)
    {
        foreach ($barang->ProductGalleries as $galeri) {
            Storage::delete("public/" . $galeri->image);
        }
        ProductGallery::whereProductId($barang->id)->delete();
        $barang->delete();
        return redirect()->back()->with("success", "Data berhasil dihapus");
    }
}
