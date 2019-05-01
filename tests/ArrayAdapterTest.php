<?php
/**
 * Created by PhpStorm.
 * User: Sohib
 * Date: 2019-04-24
 * Time: 22:10.
 */

namespace Suhayb\RateLimit\Tests;

use PHPUnit\Framework\TestCase;
use Suhayb\RateLimit\Adapters\ArrayAdapter;
use Suhayb\RateLimit\RateLimit;

class ArrayAdapterTest extends TestCase
{
    /** @var ArrayAdapter $adapter */
    private $adapter;

    protected function setUp()
    {
        $this->adapter = new ArrayAdapter(['10.1.1.1' => 40]);
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
