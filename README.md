https://stackoverflow.com/a/45945863

```
mysql> set global sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
```

```
mysql> set session sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
```

```
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
```