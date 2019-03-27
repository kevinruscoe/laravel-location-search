<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Eager loads addresses within $distance of $lat/$lng Also removes users
     * that doesn't have resulting addresses.
     * 
     * @param Illuminate\Database\Eloquent\Builder $builder
     * @param float $distance
     * @param float $lat
     * @param float $lng
     * 
     * @return Illuminate\Database\Eloquent\Builder $builder
     */
    public function scopeOrderedDistanceFrom(
        Builder $builder, 
        float $distance = 0,
        float $lat = 0,
        float $lng = 0
    ) {
        return $builder->with([
            'addresses' => function($builder) use ($distance, $lat, $lng) {
                $builder->distanceFrom($distance, $lat, $lng)
                    ->orderBy('distance');
            }
        ])->whereHas('addresses', function($builder) use ($distance, $lat, $lng) {
            $builder->distanceFrom($distance, $lat, $lng);
        });
    }
}
