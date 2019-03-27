<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'location'
    ];

    public function setLocationAttribute($value)
    {
        if (is_array($value)) {
            if (count($value) !== 2) {
                throw new \Exception("An arrayed location needs 2 values");
            }

            $lat = isset($value['lat']) ? $value['lat'] : $value[0];
            $lng = isset($value['lng']) ? $value['lng'] : $value[1];

            $value = sprintf("POINT(%s, %s)", $lat, $lng);
        }

        $this->attributes['location'] = \DB::raw($value);
    }

    public function getLocationAttribute($value)
    {
        $unpacked = unpack('x/x/x/x/corder/Ltype/dlat/dlon', $value);
        
        return [
            'lat' => $unpacked['lat'],
            'lng' => $unpacked['lon'],
        ];
    }
}
