<?php

namespace App\Http\Controllers;

use App\Product;
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
        return $this->showAll(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:100',
            'description' => 'required|max:191',
            'price' => 'required|numeric|min:0',
        ];

        $v = Validator::make($request->toArray(), $rules);
        if($v->fails())
            return $this->errorResponse($v->errors(),412);

        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_approved' => false,
            'price' => $request->price,
        ]);

        return $this->showOne($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->showOne($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'title' => 'required|max:100',
            'description' => 'required|max:191',
            'price' => 'required|numeric|min:0',
        ];

        $v = Validator::make($request->toArray(), $rules);
        if($v->fails())
            return $this->errorResponse($v->errors(),412);
            
        if($product->title != $request->title)
            $product->title = $request->title;

        if($product->description != $request->description)
            $product->description = $request->description;
        
        if($product->price != $request->price)
            $product->price = $request->price;

        if($product->isDirty())
            $product->save();
        else
            return $this->errorResponse("You have to send something to change", 412);

        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->showOne($product);
    }
}
