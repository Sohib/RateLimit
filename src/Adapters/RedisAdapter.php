<?php
/**
 * Created by PhpStorm.
 * User: Sohib
 * Date: 2019-05-01
 * Time: 20:52
 */

namespace Suhayb\RateLimit\Adapters;


use Predis\Client;
use Suhayb\RateLimit\RateLimitQuery;

class RedisAdapter implements RateLimitQuery
{
    /** @var  Client $client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetch(string $ip): int
    {
        return intval($this->client->get($ip));
    }

    public function store(string $ip, int $count): void
    {
        $this->client->set($ip, $count);
    }

    public function delete(string $ip): void
    {
        $this->client->del([$ip]);
    }

    public function all(): array
    {
        $data = [];
        foreach ($this->client->keys("*") as $key) {
            $data[$key] = $this->client->get($key);
        }
        return $data;
    }
}