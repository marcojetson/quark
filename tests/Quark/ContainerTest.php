<?php
/*
 * This file is part of the Quark package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Quark;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $container = new Container();
        $this->assertInstanceOf('Quark\Container', $container);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetUnknown()
    {
        $container = new Container();
        $container->unknown;
    }

    public function testSet()
    {
        $container = new Container();
        $container->set('service', function () {
            return new \stdClass();
        });

        $this->assertInstanceOf('stdClass', $container->service);
    }

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testSetInvalid()
    {
        $container = new Container();
        $container->set('service', []);
    }

    public function testGet()
    {
        $container = new Container();
        $container->set('service', function () {
            return new \stdClass();
        });

        $service1 = $container->service;
        $service2 = $container->service;

        $this->assertInstanceOf('stdClass', $service1);
        $this->assertInstanceOf('stdClass', $service2);
        $this->assertNotSame($service2, $service1);
    }

    public function testGetMagic()
    {
        $container = new Container();
        $container->set('service', function () {
            return new \stdClass();
        });

        $this->assertInstanceOf('stdClass', $container->service);
    }

    public function testShare()
    {
        $container = new Container();
        $container->share('service', function () {
            return new \stdClass();
        });

        $this->assertInstanceOf('stdClass', $container->service);
    }

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testShareInvalid()
    {
        $container = new Container();
        $container->share('service', []);
    }

    public function testGetShared()
    {
        $container = new Container();
        $container->share('service', function () {
            return new \stdClass();
        });

        $service1 = $container->service;
        $service2 = $container->service;

        $this->assertInstanceOf('stdClass', $service1);
        $this->assertInstanceOf('stdClass', $service2);
        $this->assertSame($service2, $service1);
    }

    public function testGetWithArguments()
    {
        $container = new Container();
        $container->set('service', function ($name) {
            $object = new \stdClass();
            $object->name = $name;

            return $object;
        });

        $service = $container->service('My service');

        $this->assertInstanceOf('stdClass', $service);
        $this->assertSame('My service', $service->name);
    }
}
