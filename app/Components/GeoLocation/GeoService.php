<?php

interface GeoService {

    public function getCoordinates(string $address): string;

}