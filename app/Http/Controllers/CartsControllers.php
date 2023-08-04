<?php

namespace App\Http\Controllers;

use App\Carts;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartsControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $page_title = "Carts";
        $carts = Carts::where('user_id',auth()->id())->where('quantity','>',0)->whereStatus(0)->paginate(10);
        return view('cart',compact('page_title','carts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = \Validator::make($request->all(),[
            'quantity'=>'required',
            'product'=>'required'
        ]);

        if ($validator->fails()){
            return response()->json(['status'=>1,'message'=>$validator->errors()->first()]);
        }

        $product_id = $request->product;
        $product = Products::find($product_id);

        $quantity = $request->quantity;
        //$price = $product->price;

        if ($quantity > $product->quantity){
            return response()->json(['status'=>1,'message'=>'The maximum available quantity is '.$product->quantity]);
        }

        $carts = Carts::where('product_id',$product->id)->where('user_id',auth()->id());

        if ($carts->count() == 0){
            Carts::create([
                'user_id'=>auth()->id(),
                'quantity'=>$quantity,
                'product_id'=>$product->id
            ]);
        }else{
            $carts = $carts->first();
            $carts->quantity+= $quantity;
            $carts->save();
        }

        $product->quantity-=$quantity;
        $product->save();

        return response()->json(['status'=>0,'message'=>$product->name.' has been added to your cart']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $cart = Carts::where('user_id',$id)->count();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(),[
            'id'=>'required',
            'quantity'=>'required'
        ]);

        if ($validator->fails()){
            return response()->json(['status'=>1,'message'=>$validator->errors()->first()]);
        }

        $cart_id = $request->id;
        $carts = Carts::find($cart_id);
        $product = Products::find($carts->product_id);

        $quantity = $request->quantity;

        if ($quantity > $product->quantity){
            return response()->json(['status'=>1,'message'=>'The maximum available quantity is '.$product->quantity]);
        }

        $type = $request->type;
        if ($type == "add" && $carts->quantity > 0){
            $carts->quantity = $quantity;
            $carts->save();
        }elseif ($type == "remove" && $carts->quantity > 0){
            $carts->quantity-= $quantity;
            $product->quantity+=$quantity;
            $product->save();
            $carts->save();
        }else{
            $carts->delete();
        }

        return response()->json(['status'=>0,'message'=>$product->name.' has been updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
