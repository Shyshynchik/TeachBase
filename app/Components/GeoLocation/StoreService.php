<?php

class StoreService {

    private GeoService $geoService;
    private StoreInterface $store;

    public function __construct(GeoService $geoService, StoreInterface $store)
    {
        $this->geoService = $geoService;
        $this->store = $store;
    }

    public function getStoreCoordinates(): string {
        return $this->geoService->getCoordinates($this->store->getAddress());
    }

}
