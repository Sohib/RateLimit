<?php
/**
 * Created by PhpStorm.
 * User: Sohib
 * Date: 2019-04-23
 * Time: 23:39.
 */

namespace Suhayb\RateLimit;

class RateLimit
{
    /** @var RateLimitQuery */
    private $data;

    public function __construct(RateLimitQuery $data)
    {
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
}
