<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::where('user_id', auth()->user()->id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate data
        $data = $request->only('name', 'description', 'price', 'quantity');
        $validator = Validator::make($data, [
            'name'     => 'required|string',
            'price'    => 'required|numeric|min:0|not_in:0',
            'quantity' => 'required|numeric|min:1'
        ]);

        // //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        //Request is valid, create new product
        $product              = new Product();
        $product->user_id     = auth()->user()->id;
        $product->name        = $request->name;
        $product->description = $request->description;
        $product->price       = $request->price;
        $product->quantity    = $request->quantity;

        $product->save();

        //Product created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Product created successfully.',
            'data'    => $product
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product not found.'
            ], 400);
        }
    
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product not found.'
            ], 400);
        }
        
        //Validate data
        $data = $request->only('name', 'description', 'price', 'quantity');
        $validator = Validator::make($data, [
            'name'     => 'required|string',
            'price'    => 'required|numeric|min:0|not_in:0',
            'quantity' => 'required|numeric|min:1'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        //Request is valid, update product
        $product->name        = $request->name;
        $product->description = $request->description;
        $product->price       = $request->price;
        $product->quantity    = $request->quantity;

        //Product updated, return success response
        if ($product->save()) {
            return response()->json([
            'success' => true,
            'message' => 'Product updated successfully.',
            'data'    => $product
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product not found.'
            ], 400);
        } else {
            $product->delete();
        
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.'
            ], 200);
        }
    }
}
