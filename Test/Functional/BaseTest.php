<?php

namespace Origammi\Bundle\BlocksBundle\Test\Functional;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Prepares DB and fixtures and creates test client.
     */
    public function setUp()
    {
        $this->loadFixtures([]);

        $this->client = static::createClient();
    }

    /**
     * Tries to get exception from response, so it can show a bit more info if test fails.
     *
     * @param Response $response
     *
     * @return string
     */
    protected function getErrorFromResponse(Response $response = null)
    {
        if (! $response) {
            $response = $this->client->getResponse();
        }

        $crawler   = new Crawler($response->getContent());
        $titleNode = $crawler->filter('title');
        $errors    = PHP_EOL;

        if (! $titleNode->count()) {
            return null;
        }

        $title = trim($titleNode->text());
        if (strlen($title)) {
            $errors .= 'Page title: ' . $title . PHP_EOL;
        }

        if ($crawler->filter('.form-errors')->count()) {
            // Let's try to get form errors
            $formErrors = $crawler->filter('.form-errors')->children();
            foreach ($formErrors as $formError) {
                $errors .= '* ' . $formError->textContent . PHP_EOL;
            }
        }

        return $errors;
    }
}
