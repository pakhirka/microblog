<?php

namespace Tests;

use AppBundle\DataFixtures\ORM\LoadData;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FixturesLoadTest extends WebTestCase
{
    public function testLoadFixtures()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $container = static::$kernel->getContainer();

        $this->assertNotNull($container, 'Container is null');

        $em = $container->get('doctrine.orm.entity_manager');

        $fixtures = new LoadData();
        $fixtures->setContainer($container);

        $loader = new Loader();
        $loader->addFixture($fixtures);
        $purger = new ORMPurger($em);
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());
    }
}
