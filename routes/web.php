<?php

use Illuminate\Support\Facades\Route;
use App\Notifications\NewNotification;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});
