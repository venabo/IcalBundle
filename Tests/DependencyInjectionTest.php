<?php

namespace BOMO\IcalBundle\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class DependencyInjectionTest extends TestCase
{
    public function testServicesRegistration()
    {
        $container = new ContainerBuilder();
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $container->compile();

        $key = 'bomo_ical.ics_provider';
        $this->assertTrue($container->has($key), "Service $key doesn't seem to be registered");

        $service = $container->get($key);
        $this->assertNotNull($service, "Instance of $key should not be null");
    }
}
