<?php

namespace KevinRuscoe\GeoHelpers;

class MilesMetresCalculator
{
    /**
     * Convert miles to metres.
     * 
     * @param float $miles
     * @return float
     */
    public static function milesToMetres(float $miles = 0)
    {
        return $miles * 1609.344;
    }

    /**
     * Convert metres to miles.
     * 
     * @param float $metres
     * @return float
     */
    public static function metresToMiles(float $metres = 0)
    {
        return $metres * 0.0006213712;
    }
}