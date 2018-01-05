<?php
use STS\Metrics\Drivers\NullDriver;

class NullDriverTest extends TestCase
{
    public function testCanCreateDriver()
    {
        app('config')->set('metrics.default', null);

        $manager = app(\STS\Metrics\MetricsManager::class);

        $this->assertInstanceOf(NullDriver::class, $manager->driver());
    }

    public function testEmptyFormat()
    {
        $driver = app(NullDriver::class);

        $metric = (new \STS\Metrics\Metric("my_metric"));

        $this->assertEquals([], $driver->format($metric));
    }

    public function testDoesntFlush()
    {
        $driver = app(NullDriver::class);

        $metric = (new \STS\Metrics\Metric("my_metric"));
        $driver->add($metric);

        // Make sure we DO keep track of metrics
        $this->assertEquals(1, count($driver->getMetrics()));

        // But nothing happens when we flush
        $driver->flush();
    }
}
