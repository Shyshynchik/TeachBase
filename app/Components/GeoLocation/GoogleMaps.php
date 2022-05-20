<?php

class GoogleMaps implements GeoService {

    public function getCoordinates(string $address): string {
        return 'google.coordinates';
    }
}
