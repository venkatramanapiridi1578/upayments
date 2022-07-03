<?php

namespace App\Http\Controllers\API;

use App\Product;
use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


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
            'product_id' => 'required',
            'session_id' => 'required',
            'qty' => 'required'           
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        //$product = Product::findOrFail($data['product_id']);

        if (Auth::check())
        {
            // The user is logged in...
            $data["user_id"] = Auth::id();
        }
       
       
       

        $Cart = Cart::create($data);

        return response([ 'cart' => new CartResource($Cart), 'message' => 'Item added successfully'], 201);
    }


    public function index()
    {
        $Products = Cart::all()->where('user_id',Auth::id());

        return response([ 'carts' => CartResource::collection($Products), 'message' => 'Retrieved successfully'], 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $Cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $Cart)
    {
        return response([ 'cart' => new CartResource($Product), 'message' => 'Retrieved successfully'], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $Cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $Cart)
    {

         $Cart->update($request->all());

        return response([ 'cart' => new CartResource($Cart), 'message' => 'Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Cart $Cart
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */


    public function destroy(Cart $Cart)
    {
        if (Auth::check())
        {
            // The user is logged in...           
            $Cart->delete();
        }

        

        return response(['message' => 'Deleted from cart'], 200);
    }

}
