<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
//        $request->validate([
//
//        ]);
        Order::insert([
            'user_id'=>Auth()->user()->id,

            'phone'=>$request->phone,
            'date'=>$request->date,
            'time'=>$request->time,
            'meal_id'=> $request->meal_id,
            'qty'=>$request->qty,
            'address'=>$request->address,
            'status'=>"تتم مراجعة الطلب",

        ]);

        $notification = array(
            'message_id' => 'تم الإضافة بنجاح',
            'alert-type' => 'info'
        );

        return redirect()->route("home")->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
    public function show_order(Order $order)
    {
        //
        $order=Order::where("user_id", Auth()->user()->id)->get();
        return view('orders.show_order', compact("order"));
    }
}
