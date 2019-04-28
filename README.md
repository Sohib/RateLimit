# RateLimit
General purpose rate limiting for IP Address or any data

## Installation

Use the package manager [composer](https://getcomposer.org/download/) to install RateLimit.

```bash
composer require suhayb/ratelimit
```

## Usage

```php
    # load from file or database
    $data = []

    $rate = new \Suhayb\RateLimit\RateLimit(
        new \Suhayb\RateLimit\Adapters\ArrayAdapter($data)
    );
    
    $ip = request()->ip();
    $count = $rate->check($ip);
    
    if ($count < 3) {
        # update ratelimiter datastore
        $rate->store($ip, $count + 1);
        # show data
    }
    
    # show error 
    abort(404);

    
    
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](./LICENSE)
