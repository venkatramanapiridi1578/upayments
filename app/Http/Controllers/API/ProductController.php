<?php

namespace App\Http\Controllers\API;

use App\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'price' => 'required',
            'category' => 'required|max:255',
            'description' => 'required',
            'avatar' => 'required'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $Product = Product::create($data);

        return response([ 'Product' => new ProductResource($Product), 'message' => 'Created successfully'], 201);
    }


    public function index()
    {
        $Products = Product::all();

        return response([ 'Products' => ProductResource::collection($Products), 'message' => 'Retrieved successfully'], 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $Product)
    {
        return response([ 'Product' => new ProductResource($Product), 'message' => 'Retrieved successfully'], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $Product)
    {

        $Product->update($request->all());

        return response([ 'Product' => new ProductResource($Product), 'message' => 'Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $Product
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */


    public function destroy(Product $Product)
    {
        $Product->delete();

        return response(['message' => 'Deleted'], 204);
    }

}
