<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Support\Str;

class AdminProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('supplier')->orderBy('nama_barang')->get();
        return view('admin.stok', compact('produks'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('admin.input', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'nullable|string|unique:produks,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|string|max:30',
            'harga_beli' => 'required|numeric|min:0',
            'tanggal_masuk' => 'required|date',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        if (empty($validated['kode_barang'])) {
            $validated['kode_barang'] = strtoupper(Str::slug(substr($validated['nama_barang'],0,10))) . '-' . rand(100,999);
        }

        Produk::create($validated);

        return redirect()->route('admin.stok')->with('success','Barang berhasil ditambahkan.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('admin.stok')->with('success','Barang berhasil dihapus.');
    }
}
