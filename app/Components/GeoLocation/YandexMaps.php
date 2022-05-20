<?php

class YandexMaps implements GeoService {

    public function getCoordinates(string $address): string {
        return 'yandex.coordinates';
    }
}
