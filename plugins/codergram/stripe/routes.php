<?php

use Codergram\Stripe\Classes\StripeDriver;
use LivestudioDev\Lscart\Models\Order;

// Route::post('stripe/processpayment', function() {

// // This is your Stripe CLI webhook secret for testing your endpoint locally.
// $endpoint_secret = 'whsec_2a0a4b47d7f6a6cec3dc380c54dd5cb0df3347c6eeeb9e76038ea3b135fd3892';

// $payload = @file_get_contents('php://input');
// $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
// $event = null;

// try {
//   $event = \Stripe\Webhook::constructEvent(
//     $payload, $sig_header, $endpoint_secret
//   );
// } catch(\UnexpectedValueException $e) {
//   // Invalid payload
//   http_response_code(400);
//   exit();
// } catch(\Stripe\Exception\SignatureVerificationException $e) {
//   // Invalid signature
//   http_response_code(400);
//   exit();
// }

// // Handle the event
// switch ($event->type) {
//   case 'charge.captured':
//     $charge = $event->data->object;
//   case 'charge.expired':
//     $charge = $event->data->object;
//   case 'charge.failed':
//     $charge = $event->data->object;
//   case 'charge.pending':
//     $charge = $event->data->object;
//   case 'charge.refunded':
//     $charge = $event->data->object;
//   case 'charge.succeeded':
//     $charge = $event->data->object;
//   case 'charge.updated':
//     $charge = $event->data->object;
//   case 'charge.dispute.closed':
//     $dispute = $event->data->object;
//   case 'charge.dispute.created':
//     $dispute = $event->data->object;
//   case 'charge.dispute.funds_reinstated':
//     $dispute = $event->data->object;
//   case 'charge.dispute.funds_withdrawn':
//     $dispute = $event->data->object;
//   case 'charge.dispute.updated':
//     $dispute = $event->data->object;
//   case 'charge.refund.updated':
//     $refund = $event->data->object;
//   case 'checkout.session.async_payment_failed':
//     $session = $event->data->object;
//   case 'checkout.session.async_payment_succeeded':
//     $session = $event->data->object;
//   case 'checkout.session.completed':
//     $session = $event->data->object;
//   case 'checkout.session.expired':
//     $session = $event->data->object;
//   // ... handle other event types
//   default:
//     echo 'Received unknown event type ' . $event->type;
// }

// http_response_code(200);

    
//     // $driver = new EcommpayDriver();

//     // $data = \Input::all();

//     // $gate = new \ecommpay\Gate('331c82a9f015bc7eaa1c2b67bd2393bbce5c8b3bff1774fd301336d060b1af0b8bb72ee14c1eecc117ec0d77d21bc896ae06585c86e07e5a98dc1d785e44f25c');
//     // $callback = json_encode($data);

//     // Log::info($callback);
//     // Log::info($callback->payment);
//     // //\Storage::disk('local')->put('test.json', $callback);

//     // if($callback){
    
//     //     $order = Order::where('id', $callback->payment->id)->first();
//     //     if($callback->payment->status == 'success'){
//     //         $order->status = 5;
//     //         $order->save();
//     //     }else {
//     //         $order->status = 3;
//     //         $order->save();
//     //     }

//     //     // return \Redirect::to("{$url}/koszonjuk/{$order->id}");

//     //     return response('OK', 200);
//     // }else {
//     //     // NO PAYMENT ID PROVIDED FUCK THEM
//     //     return null;
//     // }

//     // GETS TRIGGERED ON PAYMENT END (all states)
// });