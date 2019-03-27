```
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
```

cwl