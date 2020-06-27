<?php

declare(strict_types=1);

namespace Puwnz\GoogleMapsBundle\Factory;

use Puwnz\GoogleMapsLib\Geocode\QueryBuilder\GeocodeQueryBuilder;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GeocodeQueryBuilderFactory
{
    /** @var ValidatorInterface */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function build() : GeocodeQueryBuilder
    {
        return (new GeocodeQueryBuilder($this->validator));
    }
}
