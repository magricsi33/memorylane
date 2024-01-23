<?php

use LivestudioDev\Lscartbarion\Classes\BarionDriver;
use LivestudioDev\Lscart\Models\Order;

Route::get('barion/afterpayment/{order_num}', function($order_num) {
    $driver = new BarionDriver();

    $paymentId = \Input::get('paymentId');
    $order = Order::where('order_number',$order_num)->first();

    if($paymentId){
        $response = $driver->getPaymentState($paymentId);
        
        $status = $response->Status;
        if($status == 'Succeeded'){
            // SUCCESS
        }else {
            // ERROR
        }

    }
    $url = \Url::to('/');
    return \Redirect::to("{$url}/koszonjuk/{$order->id}");

    // USER REDIRECT
});

Route::post('barion/processpayment', function() {
    $driver = new BarionDriver();

    
    $paymentId = \Input::get('paymentId');
    if($paymentId){
        $response = $driver->getPaymentState($paymentId);
        
        $status = $response->Status;
        $order_num = $response->OrderNumber;
        $order = Order::where('order_number',$order_num)->first();
        if($status == 'Succeeded'){
            $order->status = 5;
            $order->save();
        }else {
            $order->status = 3;
            $order->save();
        }

        $url = \Url::to('/');
        // return \Redirect::to("{$url}/koszonjuk/{$order->id}");
        return response('OK', 200);
    }else {
        // NO PAYMENT ID PROVIDED FUCK THEM
        return null;
    }

    // GETS TRIGGERED ON PAYMENT END (all states)
});