<?php
/**
 * Created by PhpStorm.
 * User: Sohib
 * Date: 2019-04-24
 * Time: 23:18.
 */

namespace Suhayb\RateLimit\Adapters;

use Suhayb\RateLimit\RateLimitQuery;

class ArrayAdapter implements RateLimitQuery
{
    /** @var array $data */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function fetch(string $ip): int
    {
        return $this->data[$ip] ?? 0;
    }

    public function store(string $ip, int $count): void
    {
        $this->data[$ip] = $count;
    }

    public function delete(string $ip): void
    {
        unset($this->data[$ip]);
    }

    public function all(): array
    {
        return $this->data;
    }
}
