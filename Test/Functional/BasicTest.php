<?php

namespace Origammi\Bundle\BlocksBundle\Test\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasicTest extends WebTestCase
{
    public function testSimple()
    {
        $client = static::createClient();
    }
}