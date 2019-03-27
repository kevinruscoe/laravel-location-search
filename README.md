```
$distance = 100;
$lat = 52;
$lng = 0.2;

$users = App\User::distanceFrom($distance, $lat, $lng)->get()
    ->sortBy(function($user) {
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