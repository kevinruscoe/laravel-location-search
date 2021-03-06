<?php

use KevinRuscoe\GeoHelpers\Point;
use KevinRuscoe\GeoHelpers\MilesMetresCalculator;

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
    $users = App\User::withinMetresOf(
        MilesMetresCalculator::milesToMetres(100),
        new Point(52, 0.2)
    )->get();

    // Order users by their first addresses' metres
    $users = $users->sortBy(function($user) {
        return $user->addresses[0]->metres;
    });

    foreach ($users as $user) {
        foreach ($user->addresses as $address) {
            printf(
                "User Id: %s, Address Id: %s, Miles: %s<br>\n", 
                $user->id,
                $address->id,
                MilesMetresCalculator::metresToMiles($address->metres)
            );
        }
    }
});
