<?php
/**
 * Created by PhpStorm.
 * User: Sohib
 * Date: 2019-04-24
 * Time: 22:10.
 */

namespace Suhayb\RateLimit\Tests;

use Predis\Client;
use PHPUnit\Framework\TestCase;
use Suhayb\RateLimit\RateLimit;
use Suhayb\RateLimit\Adapters\RedisAdapter;

class RedisAdapterTest extends TestCase
{
    /** @var RedisAdapter $adapter */
    private $adapter;

    protected function setUp()
    {
        $client = new Client(getenv('REDIS_URI'));
        $this->adapter = new RedisAdapter($client);
    }

    /** @test */
    public function it_can_get_an_ip()
    {
        $rateLimit = new RateLimit(5, $this->adapter);
        $this->assertIsInt($rateLimit->check('10.11.13.1'));
        $this->assertEquals(0, $rateLimit->check('10.11.13.1'));
    }

    /** @test */
    public function it_can_store_data()
    {
        $rateLimit = new RateLimit(5, $this->adapter);

        $rateLimit->store('10.10.1.1', 2);
        $all = $rateLimit->all();

        $this->assertArrayHasKey('10.10.1.1', $rateLimit->all());
        $this->assertEquals(2, $rateLimit->check('10.10.1.1'));
    }

    /** @test */
    public function it_can_delete()
    {
        $rateLimit = new RateLimit(5, $this->adapter);

        $rateLimit->delete('10.1.1.1');
        $this->assertArrayNotHasKey('10.1.1.1', $rateLimit->all());
        $this->assertEquals(0, $rateLimit->check('10.1.1.1'));
    }

    /** @test
     * @expectedException \Suhayb\RateLimit\Exception\MaxLimitException
     */
    public function it_limit_running_to_with_run_syntax()
    {
        $rate = new RateLimit(5, $this->adapter);

        for ($i = 0; $i < 6; $i++) {
            $rate->run('10.10.10.10', function () {
                // do stuff
            });
        }
    }
}
