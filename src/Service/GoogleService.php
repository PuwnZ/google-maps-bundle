<?php

declare(strict_types=1);

namespace Puwnz\GoogleMapsBundle\Service;

use Puwnz\GoogleMapsBundle\Factory\GeocodeQueryBuilderFactory;
use Puwnz\GoogleMapsLib\GoogleService as GoogleServiceLib;

class GoogleService
{
    /** @var GoogleServiceLib */
    private $googleService;

    /** @var GeocodeQueryBuilderFactory */
    private $geocodeQueryBuilderFactory;

    public function __construct(GoogleServiceLib $googleService, GeocodeQueryBuilderFactory $geocodeQueryBuilderFactory)
    {
        $this->googleService = $googleService;
        $this->geocodeQueryBuilderFactory = $geocodeQueryBuilderFactory;
    }

    public function reverseGeocode(float $lat, float $lng): array
    {
        $geocodeQueryBuilder = $this->geocodeQueryBuilderFactory->build();

        $geocodeQueryBuilder->setLatLng($lat, $lng);

        return $this->googleService->apply($geocodeQueryBuilder);
    }

    public function geocode(
        string $address,
        array $components = [],
        ?string $language = null,
        ?string $region = null,
        array $bounds = []
    ): array {
        $geocodeQueryBuilder = $this->geocodeQueryBuilderFactory->build();
        $geocodeQueryBuilder->setAddress($address);

        if ($components !== []) {
            $geocodeQueryBuilder->setComponents($components);
        }

        if (!empty($language)) {
            $geocodeQueryBuilder->setLanguage($language);
        }

        if (!empty($region)) {
            $geocodeQueryBuilder->setRegion($region);
        }

        if ($bounds !== []) {
            $geocodeQueryBuilder->setBounds($bounds);
        }

        return $this->googleService->apply($geocodeQueryBuilder);
    }
}
