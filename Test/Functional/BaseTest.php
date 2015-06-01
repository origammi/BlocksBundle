<?php

namespace Origammi\Bundle\BlocksBundle\Test\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $uploadDir;

    /**
     * Prepares DB and fixtures and creates test client.
     */
    public function setUp()
    {
        $this->client    = static::createClient();
        $this->uploadDir = $this->getContainer()->getParameter('upload_dir');

        $fs = new Filesystem();
        // clean up
        $fs->remove($this->uploadDir);
        // then recreate directory
        $fs->mkdir($this->uploadDir);
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

        return $errors;
    }

    /**
     * @return UploadedFile
     */
    protected function getTestUploadImage()
    {
        $dir       = self::$kernel->getRootDir() . '/data';
        $imagePath = $dir . '/logo.jpg';

        if (! file_exists($imagePath)) {
            throw new \LogicException(
                sprintf('Image `%s` does not exists.', $imagePath)
            );
        }

        $image = new UploadedFile(
            $imagePath,
            basename($imagePath),
            'image/jpeg'
        );

        return $image;
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function getContainer()
    {
        return $this->client->getContainer();
    }
}
