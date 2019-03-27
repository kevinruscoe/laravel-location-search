<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {

    $executionStartTime = microtime(true);

    $distance = 100;
    $lat = 52;
    $lng = 0.2;

    $users = App\User::orderedDistanceFrom($distance, $lat, $lng)->get();

    // Order users by their first addresses' distance
    $users = $users->sortBy(function($user) {
        return $user->addresses[0]->distance;
    });

    foreach ($users as $user) {
        foreach ($user->addresses as $address) {
            printf(
                "User Id: %s, Address Id: %s, Distance: %s<br>\n", 
                $user->id,
                $address->id,
                $address->distance
            );
        }
    }

    $executionEndTime = microtime(true);

    $seconds = $executionEndTime - $executionStartTime;

    echo "This script took $seconds to execute.";
});
