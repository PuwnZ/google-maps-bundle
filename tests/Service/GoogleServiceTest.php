<?php

declare(strict_types=1);

namespace Puwnz\GoogleMapsBundle\Tests\Service;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Puwnz\GoogleMapsBundle\Factory\GeocodeQueryBuilderFactory;
use Puwnz\GoogleMapsBundle\Service\GoogleService;
use Puwnz\GoogleMapsLib\Constants\SupportedLanguage;
use Puwnz\GoogleMapsLib\Constants\SupportedRegion;
use Puwnz\GoogleMapsLib\Geocode\DTO\GeocodeResult;
use Puwnz\GoogleMapsLib\Geocode\Parser\GeocodeParser;
use Puwnz\GoogleMapsLib\Geocode\QueryBuilder\GeocodeQueryBuilder;
use Puwnz\GoogleMapsLib\Geocode\Type\GeocodeComponentQueryType;
use Puwnz\GoogleMapsLib\GoogleService as GoogleServiceLib;

class GoogleServiceTest extends TestCase
{
    /** @var MockObject|GeocodeParser */
    private $geocodeParser;

    /** @var MockObject|GeocodeQueryBuilderFactory */
    private $geocodeQueryBuilderFactory;

    /** @var GoogleService */
    private $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->geocodeParser = $this->createMock(GoogleServiceLib::class);
        $this->geocodeQueryBuilderFactory = $this->createMock(GeocodeQueryBuilderFactory::class);

        $this->service = new GoogleService($this->geocodeParser, $this->geocodeQueryBuilderFactory);
    }

    public function testCall(): void
    {
        $address = '10 rue de la Paix, Paris';
        $components = [
            GeocodeComponentQueryType::COUNTRY => 'FR',
        ];
        $language = SupportedLanguage::FRENCH;
        $region = SupportedRegion::FR;
        $bounds = [
            'northeast' => [
                'lat' => 0.0,
                'lng' => 1.0,
            ],
            'southwest' => [
                'lat' => -0.0,
                'lng' => -1.0,
            ],
        ];

        $geocodeResults = [new GeocodeResult()];

        $geocodeQueryBuilder = $this->createMock(GeocodeQueryBuilder::class);

        $this->geocodeQueryBuilderFactory->expects(static::once())
            ->method('build')
            ->willReturn($geocodeQueryBuilder);

        $geocodeQueryBuilder->expects(static::once())
            ->method('setAddress')
            ->with($address)
            ->willReturn($geocodeQueryBuilder);

        $geocodeQueryBuilder->expects(static::once())
            ->method('setComponents')
            ->with($components)
            ->willReturn($geocodeQueryBuilder);

        $geocodeQueryBuilder->expects(static::once())
            ->method('setLanguage')
            ->with($language)
            ->willReturn($geocodeQueryBuilder);

        $geocodeQueryBuilder->expects(static::once())
            ->method('setRegion')
            ->with($region)
            ->willReturn($geocodeQueryBuilder);

        $geocodeQueryBuilder->expects(static::once())
            ->method('setBounds')
            ->with($bounds)
            ->willReturn($geocodeQueryBuilder);

        $this->geocodeParser->expects(static::once())
            ->method('apply')
            ->with($geocodeQueryBuilder)
            ->willReturn($geocodeResults);

        $actual = $this->service->geocode($address, $components, $language, $region, $bounds);

        $expected = $geocodeResults;

        static::assertSame($expected, $actual);
    }

    public function testReverseCall(): void
    {
        $geocodeResults = [new GeocodeResult()];

        $geocodeQueryBuilder = $this->createMock(GeocodeQueryBuilder::class);

        $this->geocodeQueryBuilderFactory->expects(static::once())
            ->method('build')
            ->willReturn($geocodeQueryBuilder);

        $geocodeQueryBuilder->expects(static::once())
            ->method('setLatLng')
            ->with(0., 0.)
            ->willReturn($geocodeQueryBuilder);

        $this->geocodeParser->expects(static::once())
            ->method('apply')
            ->with($geocodeQueryBuilder)
            ->willReturn($geocodeResults);

        $actual = $this->service->reverseGeocode(0., 0.);

        $expected = $geocodeResults;

        static::assertSame($expected, $actual);
    }
}
