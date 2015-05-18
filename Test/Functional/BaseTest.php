<?php

namespace Origammi\Bundle\BlocksBundle\Test\Functional;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

abstract class BaseTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    public function setUp()
    {
        $this->loadFixtures([]);

        $this->client = static::createClient();
    }
}