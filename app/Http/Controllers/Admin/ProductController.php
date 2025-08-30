<?php

namespace App\Http\Controllers\admin;

use League\Csv\Reader;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Jobs\ImportProductsJob;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::query();

            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="view btn btn-info btn-sm me-1">View</a>';
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-warning btn-sm me-1">Update</a>';
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm me-1">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category = $request->category;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return response()->json(['success' => true, 'message' => 'Product Add Successfully!!!', 'status' => 201]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['name', 'description', 'price', 'stock', 'category']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully.',
                'product' => $product
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Request $request)
    {
        $product->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.'
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,xlsx,xls']
        ]);

        try {
            Excel::queueImport(new ProductsImport, $request->file('file'))
                ->allOnQueue('imports')
                ->allOnConnection('database');

            return response()->json([
                'success' => true,
                'message' => 'Data imported successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
