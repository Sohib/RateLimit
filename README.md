# RateLimit
General purpose rate limiting for IP Address or any data

## Installation

Use the package manager [composer](https://getcomposer.org/download/) to install RateLimit.

```bash
composer require suhayb/ratelimit
```

## Usage

```php
<?php


include_once 'vendor/autoload.php';

use \Suhayb\RateLimit\RateLimit;
use \Suhayb\RateLimit\Adapters\ArrayAdapter;

# could be change to any data source compatible with RateLimitQuery interface 
$dataSource = new ArrayAdapter([]);
$rateLimit = new RateLimit(5, $dataSource);

# threw Max Limit Exception on exceeding the limit  
$rateLimit->run("10.11.13.1", function () {
        # do anything
});
    
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](./LICENSE)
