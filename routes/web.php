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

    $users = (new KevinRuscoe\UserLocationFinder(
        51.87789,
        -0.3501,
        100,
    ))->fetch();

    foreach ($users as $user) {
        foreach ($user->addresses as $address) {
            printf(
                "User Id: %s, Address Id: %s, Distance: %s<br>\n", 
                $user->id,
                $address->id,
                $address->geoResults->distance
            );
        }
    }
});
