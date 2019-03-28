<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use KevinRuscoe\GeoHelpers\Point;

class Address extends Model
{
    protected $fillable = [
        'location'
    ];

    /**
     * Turns a POINT() or array to a raw DB Point
     * 
     * @param string|array $value
     * @return void
     */
    public function setLocationAttribute(Point $point)
    {
        $this->attributes['location'] = \DB::raw($point->toMysqlPoint());
    }

    /**
     * Turns a DB POINT() into a pair to lat/lng.
     * 
     * @param string $value
     * @return array
     */
    public function getLocationAttribute($location)
    {
        return (new Point)
            ->unpackFromMysqlPoint($location)
            ->toArray();
    }

    /**
     * Selects addresses within $distance of $lat/$lng.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param float $distance
     * @param Point $point
     * @throws \Exception
     * 
     * @return \Illuminate\Database\Eloquent\Builder $builder
     */
    public function scopeWithinMetresOf(
        Builder $builder,
        float $metres = 0,
        Point $point = null
    ) {
        if (is_null($point)) {
            throw new \Exception('$point must be a Point object.');
        }

        return $builder
            ->select()
            ->addSelect(
                \DB::raw(
                    sprintf(
                        "st_distance_sphere(%s, location) as metres",
                        $point->toMysqlPoint()
                    )
                )
            )
            ->having("metres", "<=", $metres);
    }
}
