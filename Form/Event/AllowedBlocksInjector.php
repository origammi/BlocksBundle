<?php

namespace Origammi\Bundle\BlocksBundle\Form\Event;

use Origammi\Bundle\BlocksBundle\Annotation\Conversion\BlocksConverter;
use Origammi\Bundle\BlocksBundle\BlocksContainer;
use Origammi\Bundle\BlocksBundle\Entity\Block;
use Origammi\Bundle\BlocksBundle\Entity\BlockCollection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class AllowedBlocksInjector
 *
 * @package   Origammi\Bundle\BlocksBundle\Form\Event
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2015 Astina AG (http://astina.ch)
 */
class AllowedBlocksInjector implements EventSubscriberInterface
{
    /**
     * @var BlocksConverter
     */
    private $blocksConverter;

    /**
     * @var BlocksContainer
     */
    private $blocksContainer;

    /**
     * @param BlocksConverter $blocksConverter
     * @param BlocksContainer $blocksContainer
     */
    public function __construct(BlocksConverter $blocksConverter, BlocksContainer $blocksContainer)
    {
        $this->blocksConverter = $blocksConverter;
        $this->blocksContainer = $blocksContainer;
    }

    /**
     * Before building BlockCollection form, we add default blocks to it.
     * And sort them accordingly.
     *
     * @param FormEvent $event
     *
     * @return BlockCollection
     *
     */
    public function onPreSetData(FormEvent $event)
    {
        $parentForm           = $event->getForm()->getParent();
        $propertyName         = $event->getForm()->getConfig()->getName();
        $blockCollectionData  = $this->blocksConverter->convert($parentForm->getData());

        foreach ($blockCollectionData as $blockCollectionDataProperty) {
            if ($propertyName === $blockCollectionDataProperty->getPropertyName()) {
                $event->getForm()->add('blocks', 'infinite_form_polycollection', array(
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'label'        => false,
                    'types'        => $blockCollectionDataProperty->getAllowed()
                ));
            }
        }
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
        ];
    }
}
