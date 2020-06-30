<?php

declare(strict_types=1);

namespace Puwnz\GoogleMapsBundle\Service;

use Puwnz\GoogleMapsBundle\Factory\GeocodeQueryBuilderFactory;
use Puwnz\GoogleMapsLib\Geocode\DTO\GeocodeResult;
use Puwnz\GoogleMapsLib\Geocode\Exception\GeocodeViolationsException;
use Puwnz\GoogleMapsLib\Geocode\GeocodeParser;

class GeocodeService
{
    /** @var GeocodeParser */
    private $geocodeParser;

    /** @var GeocodeQueryBuilderFactory */
    private $geocodeQueryBuilderFactory;

    public function __construct(GeocodeParser $geocodeParser, GeocodeQueryBuilderFactory $geocodeQueryBuilderFactory)
    {
        $this->geocodeParser = $geocodeParser;
        $this->geocodeQueryBuilderFactory = $geocodeQueryBuilderFactory;
    }

    /**
     * @return GeocodeResult[]
     *
     * @throws GeocodeViolationsException
     */
    public function call(
        string $address,
        array $components = [],
        ?string $language = null,
        ?string $region = null,
        array $bounds = []
    ) : array {
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

        return $this->geocodeParser->getGeocodeByBuilder($geocodeQueryBuilder);
    }
}
