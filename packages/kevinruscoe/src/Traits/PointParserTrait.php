<?php

namespace KevinRuscoe\Traits;

trait PointParserTrait
{
    /**
     * Turns a POINT() or array to a raw DB Point
     * 
     * @param string|array $value
     * @return void
     */
    public function setLocationAttribute($value = 'POINT(0, 0)')
    {
        if (is_array($value)) {
            if (count($value) !== 2) {
                throw new \Exception(
                    "An arrayed location needs 2 values (lat and lng)."
                );
            }

            $lat = isset($value['lat']) ? $value['lat'] : $value[0];
            $lng = isset($value['lng']) ? $value['lng'] : $value[1];

            $value = sprintf("POINT(%s, %s)", $lat, $lng);
        }

        $this->attributes['location'] = \DB::raw($value);
    }

    /**
     * Turns a DB POINT() into a pair to lat/lng.
     * 
     * @param string $value
     * @return array
     */
    public function getLocationAttribute($value)
    {
        $unpacked = unpack(
            'x/x/x/x/corder/Ltype/dlat/dlon',
            $value,
            0
        );
        
        return [
            'lat' => $unpacked['lat'],
            'lng' => $unpacked['lon'],
        ];
    }
}