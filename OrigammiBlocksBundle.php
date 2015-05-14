<?php

namespace Origammi\Bundle\BlocksBundle;

use Origammi\Bundle\BlocksBundle\DependencyInjection\Compiler\BlocksCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\KernelInterface;

class OrigammiBlocksBundle extends Bundle
{
    private $kernel;

    /**
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @param ContainerBuilder $builder
     */
    public function build(ContainerBuilder $builder)
    {
        $config = $builder->getCompiler()->getPassConfig();
        $passes = $config->getBeforeOptimizationPasses();

        // compiler pass has to execute before symfony2 forms are registered, because we are adding form.type dynamically
        array_unshift($passes, new BlocksCompilerPass($this->kernel));

        $config->setBeforeOptimizationPasses($passes);
    }
}
