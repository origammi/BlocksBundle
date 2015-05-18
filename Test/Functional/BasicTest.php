<?php

namespace Origammi\Bundle\BlocksBundle\Test\Functional;

class BasicTest extends BaseTest
{
    public function testSimple()
    {
        $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
