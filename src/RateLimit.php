<?php
/**
 * Created by PhpStorm.
 * User: Sohib
 * Date: 2019-04-23
 * Time: 23:39.
 */

namespace Suhayb\RateLimit;

use Suhayb\RateLimit\Exception\MaxLimitException;

class RateLimit
{
    /** @var RateLimitQuery */
    private $data;
    /** @var int $limit */
    private $maxLimit;

    public function __construct(int $maxLimit, RateLimitQuery $data)
    {
        $this->maxLimit = $maxLimit;
        $this->data = $data;
    }

    public function check($ip)
    {
        return $this->data->fetch($ip);
    }

    public function store($ip, $count)
    {
        $this->data->store($ip, $count);
    }

    public function delete($ip)
    {
        $this->data->delete($ip);
    }

    public function all()
    {
        return $this->data->all();
    }

    public function run($ip, $callback)
    {
        $count = $this->check($ip);
        if ($count < $this->maxLimit) {
            $this->store($ip, $count + 1);
            $callback();
        } else {
            throw new MaxLimitException("${ip} has exceed $this->maxLimit");
        }
    }
}
