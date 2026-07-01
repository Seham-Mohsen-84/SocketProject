<?php

use App\Events\PublicMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/send-message', function (Request $request) {
    $message = $request->input('message', 'Hello World!');
    
    broadcast(new PublicMessage($message));
    
    return response()->json([
        'status' => 'Success',
        'message' => 'Message broadcasted!',
        'payload' => [
            'message' => $message
        ]
    ]);
});
