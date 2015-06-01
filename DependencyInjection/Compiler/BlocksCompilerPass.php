<?php

namespace Origammi\Bundle\BlocksBundle\DependencyInjection\Compiler;

use Origammi\Bundle\BlocksBundle\Form\BlockType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class BlocksCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds('origammi_blocks.block');
        $definition     = $container->getDefinition(
            'origammi_blocks.blocks_container'
        );

        foreach ($taggedServices as $id => $tags) {
            $blockDefinition = $container->getDefinition($id);
            $formClass       = $blockDefinition->getClass();
            $formType        = new $formClass();

            if (! $formType instanceof BlockType) {
                throw new \InvalidArgumentException(
                    sprintf('Block definition `%s` has to extend BlockType.', $id)
                );
            }

            // every block is also a form type, for simplicity we add tags here, instead in service definition
            $blockDefinition->addTag('form.type', ['alias' => $formType->getName()]);

            $definition->addMethodCall(
                'addBlockType',
                [ new Reference($id) ]
            );
        }
    }
}
