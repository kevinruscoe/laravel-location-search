```php
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
```

cwl