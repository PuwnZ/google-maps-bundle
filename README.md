# Readme

## Overview

The Google Maps Lib project provides a Google Map Lib integration for you Symfony 4+ and PHP 7.3+ project. At this time, just geocode is enable in this lib, because my needs is only on this part, but you can open [issues](/issues) to push your needs.

## Installation

To install this lib you can just use composer :

```
composer require puwnz/google-maps-bundle
```

## Integration

### Bundle registration

```php
<?php
// config/bundles.php

return [
    Puwnz\GoogleMapsBundle\GoogleMapsBundle::class => ['all' => true]
];
```

### Config integration

> You can just add `GOOGLE_API_KEY` a var env in you application to set configuration.

Configuration by default : 

```yaml
# config/packages/google_maps.yaml
google_maps:
    api_key: '%env(GOOGLE_API_KEY)%'
```

## Example

To use this package on your symfony project, you can use than the next example :

```php
<?php

namespace App\Controller;

use Puwnz\GoogleMapsBundle\Service\GoogleService;
use Puwnz\GoogleMapsLib\Geocode\DTO\GeocodeResult;

class FooService  {

    /** @var GoogleService */
    private $googleService;

    public function __construct(GoogleService $geocodeService) {
        $this->googleService = $geocodeService;
    }
    
    /**
    * @return GeocodeResult[]
    */
    public function getGeocodeResult(string $address) : array
    {
        return $this->googleService->geocode($address);
    }
}
```

## Testing

The bundle is fully unit tested by [PHPUnit](http://www.phpunit.de/) with a code coverage close to **100%**.

## Contribute

We love contributors! This is an open source project. If you'd like to contribute, feel free to propose a PR!

## License

The Google Map Lib is under the MIT license. For the full copyright and license information, please read the
[LICENSE](/LICENSE) file that was distributed with this source code.
