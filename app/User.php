<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use KevinRuscoe\GeoHelpers\Point;

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
     * @param Point $point
     * @throws \Expection
     * 
     * @return Illuminate\Database\Eloquent\Builder $builder
     */
    public function scopeWithinMetresOf(
        Builder $builder, 
        float $metres = 0,
        Point $point = null
    ) {
        if (is_null($point)) {
            throw new \Exception('$point must be a Point object.');
        }
        
        return $builder->with([
            'addresses' => function($builder) use ($metres, $point) {
                $builder->withinMetresOf($metres, $point)
                    ->orderBy('metres');
            }
        ])->whereHas('addresses', function($builder) use ($metres, $point) {
            $builder->withinMetresOf($metres, $point);
        });
    }
}
