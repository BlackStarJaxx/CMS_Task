<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{

    public function index()
    {
        return(ProductResource::collection(Product::latest()->paginate(Input::get('per_page','20'))));
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'units' => $request->units,
            'price' => $request->price,
            'currency' => $request->currency,
            'image' => $request->image
        ]);

        return response()->json([
            'status' => (bool) $product,
            'data'   => $product,
            'message' => $product ? 'Product Created!' : 'Error Creating Product'

        ]);
    }

    public function show(Product $product)
    {
        return response()->json($product,200);


    }

    public function uploadFile(Request $request)
    {
        if($request->hasFile('image')){
            $name = time()."_".$request->file('image')
                    ->getClientOriginalName();
            $request->file('image')
                ->move(public_path('images'), $name);
        }
        return response()->json(asset("images/$name"),201);
    }

    public function update(Request $request, Product $product)
    {
        $status = $product->update(
            $request->only(['name', 'description', 'units', 'price', 'image','currency',])
        );

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Product Updated!' : 'Error Updating Product'

        ]);
    }

    public function updateUnits(Request $request, Product $product)
    {
        $product->units = $product->units + $request->get('units');
        $status = $product->save();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Units Added!' : 'Error Adding Product Units'
        ]);
    }

    public function destroy(Product $product)
    {
         $product->delete();

       return response()->json([
            'status'  => $product,
            'message' => $product ? 'Product Deleted!' : 'Error Deleting Product'
        ]);
    }

}
