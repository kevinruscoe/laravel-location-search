<?php

namespace KevinRuscoe\GeoHelpers;

class Point
{
    /**
     * The latitude.
     * 
     * @var float
     */
    private $latitude;

    /**
     * The longitude.
     * 
     * @var float
     */
    private $longitude;

    /**
     * Constructor.
     * 
     * @param float $latitude
     * @param float $longitude
     * @return Point$this
     */
    public function __construct(float $latitude = 0, float $longitude = 0)
    {
        $this->setLatitude($latitude);

        $this->setLongitude($longitude);

        return $this;
    }

    /**
     * Get the latitude.
     * 
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set the latitude.
     * 
     * @param float $latitude
     * @throws \OutOfBoundsException
     * @return Point $this
     */
    public function setLatitude(float $latitude)
    {
        if ($latitude < -90 || $latitude > 90) {
            throw new \OutOfBoundsException(
                "Latitudes must fall between -90 and 90."
            );
        }

        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get the longitude.
     * 
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set the longitude.
     * 
     * @param float $longitude
     * @throws \OutOfBoundsException
     * @return Point$this
     */
    public function setLongitude(float $longitude = 0)
    {
        if ($longitude < -180 || $longitude > 180) {
            throw new \OutOfBoundsException(
                "Longitudes must fall between -180 and 180."
            );
        }

        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Unpacks a MySQL WKB.
     * 
     * @param string $point
     * @return Point$this
     */
    public function unpackFromMysqlPoint(string $point)
    {
        $unpacked = unpack(
            'x/x/x/x/corder/Ltype/dlon/dlat',
            $point,
            0
        );

        $this->setLatitude($unpacked['lat']);
        
        $this->setLongatude($unpacked['lon']);

        return $this;
    }

    /**
     * Creates a MySQL Point().
     * 
     * @return string
     */
    public function toMysqlPoint()
    {
        return sprintf(
            "POINT(%s, %s)",
            $this->longitude,
            $this->latitude
        );
    }

    /**
     * Returns lat/lng array.
     * 
     * @return array
     */
    public function toArray()
    {
        return [
            'lat' => $this->latitude,
            'lng' => $this->longitude
        ];
    }

    /**
     * Returns a MySQL Point().
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->toMysqlPoint();
    }
}