<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class TestAppKernel extends Kernel
{
    /**
     * @return array|\Symfony\Component\HttpKernel\Bundle\BundleInterface[]
     */
    public function registerBundles()
    {
        return [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Liip\FunctionalTestBundle\LiipFunctionalTestBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new \Symfony\Bundle\DebugBundle\DebugBundle(),

            new Vich\UploaderBundle\VichUploaderBundle(),
            new Infinite\FormBundle\InfiniteFormBundle,
            new Trsteel\CkeditorBundle\TrsteelCkeditorBundle(),

            new \Origammi\Bundle\BlocksBundle\OrigammiBlocksBundle($this),
        ];
    }

    /**
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.yml');
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function getCacheDir()
    {
        return __DIR__ . '/tmp/cache/' . $this->environment;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function getLogDir()
    {
        return __DIR__ . '/tmp/logs';
    }
}