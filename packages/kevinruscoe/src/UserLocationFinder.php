<?php

namespace KevinRuscoe;

use DB;
use App\User;
use App\Address;

class UserLocationFinder
{
    protected $distance = 0;

    protected $latitude = 0;

    protected $longitude = 0;

    public function __construct($latitude = 0, $longitude = 0, $distance = 0) {
        $this->distance = $distance;

        $this->latitude = $latitude;

        $this->longitude = $longitude;

        return $this;
    }

    public function fetch()
    {        
        $from = [
            'lat' => $this->latitude,
            'lng' => $this->longitude
        ];

        $results = DB::select(
            "select users.id as user_id, addresses.id as address_id, st_distance_sphere(POINT(?, ?), addresses.location) / 1609.344 as distance from addresses inner join users on addresses.user_id = users.id having distance < ? order by distance asc",
            [
                $this->latitude,
                $this->longitude,
                $this->distance
            ]
        );

        $users = User::find(array_column($results, 'user_id'));

        $addresses = Address::find(array_column($results, 'address_id'));

        foreach ($users as $user) {
            $userId = $user->id;

            $user->addresses = $addresses
                ->where('user_id', $user->id)
                ->map(function($address) use ($userId, $results, $from) {
                    $result = null;

                    foreach ($results as $result) {
                        if (
                            $result->user_id == $userId && 
                            $result->address_id == $address->id
                        ) {
                            $address->geoResults = (object) [
                                'distance' => $result->distance,
                                'from' => $from
                            ];
                        }

                    }

                    return $address;
                })
                ->sortBy(function($address) {
                    return $address->geoResults->distance;
                })
                ->values();
        }

        return $users->sortBy(function($user) {
            return $user->addresses[0]->geoResults->distance;
        });
    }
}