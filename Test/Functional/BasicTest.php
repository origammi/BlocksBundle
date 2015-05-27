<?php

namespace Origammi\Bundle\BlocksBundle\Test\Functional;

class BasicTest extends BaseTest
{
    /**
     * Just checks if form page is working.
     */
    public function testSimple()
    {
        $this->client->request('GET', '/');

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode(),
            $this->getErrorFromResponse()
        );
    }

    /**
     * Tests a really simple save operation.
     *
     * @depends testSimple
     */
    public function testSimpleSaveOfPost()
    {
        $crawler = $this->client->request('GET', '/new');
        $form    = $crawler->selectButton('Save')->form();

        $this->client->submit($form, [
            'form[title]'                          => __METHOD__,
            'form[blocks][blocks][0][text]'        => __METHOD__,
            'form[blocks][blocks][1][text]'        => __METHOD__,
            'form[blocks][blocks][2][caption]'     => __METHOD__,
            'form[blocks][blocks][2][image][file]' => $this->getTestUploadImage(),
            'form[blocks][blocks][3][text]'        => __METHOD__,
            'form[blocks][blocks][4][caption]'     => __METHOD__,
            'form[blocks][blocks][4][externalId]'  => 'jI-kpVh6e1U',
        ]);

        $this->assertTrue($this->client->getResponse()->isRedirect(), $this->getErrorFromResponse());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(1, $crawler->filter('.flash-success')->count(), 'Flash message not found.');
    }

    /**
     * Tests a really simple edit operation.
     *
     * @depends testSimpleSaveOfPost
     */
    public function testSimpleEditOfPost()
    {
        $crawler = $this->client->request('GET', '/edit/1');
        $form    = $crawler->selectButton('Save')->form();

        $this->client->submit($form, [
            'form[title]'                          => __METHOD__,
            'form[blocks][blocks][0][text]'        => __METHOD__,
            'form[blocks][blocks][1][text]'        => __METHOD__,
            'form[blocks][blocks][2][caption]'     => __METHOD__,
            'form[blocks][blocks][2][image][file]' => $this->getTestUploadImage(),
            'form[blocks][blocks][3][text]'        => __METHOD__,
            'form[blocks][blocks][4][caption]'     => __METHOD__,
            'form[blocks][blocks][4][externalId]'  => 'dQw4w9WgXcQ',
        ]);

        $this->assertTrue($this->client->getResponse()->isRedirect(), $this->getErrorFromResponse());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(1, $crawler->filter('.flash-success')->count(), 'Flash message not found.');
    }
}
