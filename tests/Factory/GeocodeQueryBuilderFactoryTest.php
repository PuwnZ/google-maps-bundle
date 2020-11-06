<?php

declare(strict_types=1);

namespace Puwnz\GoogleMapsBundle\Tests\Factory;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Puwnz\GoogleMapsBundle\Factory\GeocodeQueryBuilderFactory;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GeocodeQueryBuilderFactoryTest extends TestCase
{
    /** @var MockObject|ValidatorInterface */
    private $validator;

    /** @var GeocodeQueryBuilderFactory */
    private $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->service = new GeocodeQueryBuilderFactory($this->validator);
    }

    public function testBuild(): void
    {
        $queryBuilder = $this->service->build();
        $queryBuilder2 = $this->service->build();

        static::assertEquals($queryBuilder2, $queryBuilder);
        static::assertNotSame($queryBuilder2, $queryBuilder);
    }
}
