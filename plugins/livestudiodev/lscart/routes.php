<?php

Route::post('files/{id}', function($id) {
    $test = \Input::file('file');

    \Storage::disk('local')->put('cartfiles/'.$id,$test);
});

Route::get('api/lsearch', function() {
    $products = \LivestudioDev\Lscart\Models\Product::with('image')->get();

    return Response::json($products);
});

?>