<?php

declare(strict_types=1);

namespace Puwnz\GoogleMapsBundle;

use Puwnz\GoogleMapsLib\Geocode\DTO\GeocodeResult;
use Puwnz\GoogleMapsLib\Geocode\Exception\GeocodeViolationsException;
use Puwnz\GoogleMapsLib\Geocode\GeocodeParser;
use Puwnz\GoogleMapsLib\Geocode\QueryBuilder\GeocodeQueryBuilder;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GeocodeService
{
    /** @var GeocodeParser */
    private $geocodeParser;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(GeocodeParser $geocodeParser, ValidatorInterface $validator)
    {
        $this->geocodeParser = $geocodeParser;
        $this->validator = $validator;
    }

    /**
     * @return GeocodeResult[]
     * @throws GeocodeViolationsException
     */
    public function call(
        string $address,
        array $components = [],
        ?string $language = null,
        ?string $region = null,
        array $bounds = []
    ): array
    {
        $geocodeQueryBuilder = (new GeocodeQueryBuilder($this->validator))
            ->setAddress($address);

        if ($components !== []) {
            $geocodeQueryBuilder->setComponents($components);
        }

        if (!empty($language)) {
            $geocodeQueryBuilder->setLanguage($language);
        }

        if (!empty($region)) {
            $geocodeQueryBuilder->setLanguage($region);
        }

        if ($bounds !== []) {
            $geocodeQueryBuilder->setBounds($bounds);
        }

        return $this->geocodeParser->getGeocodeByBuilder($geocodeQueryBuilder);
    }
}
