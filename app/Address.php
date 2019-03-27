<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use KevinRuscoe\Traits\PointParserTrait;
use Illuminate\Database\Eloquent\Builder;

class Address extends Model
{
    use PointParserTrait;

    protected $fillable = [
        'location'
    ];

    /**
     * Selects addresses within $distance of $lat/$lng.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param float $distance
     * @param float $lat
     * @param float $lng
     * 
     * @return \Illuminate\Database\Eloquent\Builder $builder
     */
    public function scopeDistanceFrom(
        Builder $builder,
        float $distance = 0,
        float $lat = 0,
        float $lng = 0
    ) {
        return $builder
            ->select()
            ->addSelect(
                \DB::raw(
                    sprintf(
                        "st_distance_sphere(POINT(%s, %s), location) / 1609.344 as distance",
                        $lat,
                        $lng
                    )
                )
            )
            ->having("distance", "<=", $distance);
    }
}
