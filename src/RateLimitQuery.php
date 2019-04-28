<?php
/**
 * Created by PhpStorm.
 * User: Sohib
 * Date: 2019-04-24
 * Time: 23:17.
 */

namespace Suhayb\RateLimit;

interface RateLimitQuery
{
    public function fetch(string $ip): int;

    public function store(string $ip, int $count): void;

    public function delete(string $ip): void;

    public function all(): array;
}
