<?php
/**
 * Created by PhpStorm.
 * User: Sohib
 * Date: 2019-04-24
 * Time: 23:18
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


    public function fetch($ip): int
    {
        return $this->data[$ip] ?? 0;
    }

    public function store($ip, $count): void
    {
        $this->data[$ip] = $count;
    }

    public function delete($ip): void
    {
        unset($this->data[$ip]);
    }

    public function all(): array
    {
        return $this->data;
    }
}