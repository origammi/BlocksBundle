<?php

namespace Origammi\Bundle\BlocksBundle\Form\Event;

use Doctrine\Common\Collections\ArrayCollection;
use Origammi\Bundle\BlocksBundle\Annotation\BlockCollectionData;
use Origammi\Bundle\BlocksBundle\Annotation\Conversion\BlocksConverter;
use Origammi\Bundle\BlocksBundle\BlocksContainer;
use Origammi\Bundle\BlocksBundle\Entity\Block;
use Origammi\Bundle\BlocksBundle\Entity\BlockCollection;
use Origammi\Bundle\BlocksBundle\Exception\BlockNotFoundException;
use Origammi\Bundle\BlocksBundle\Form\BlockType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class DefaultBlockPopulator
 *
 * @package   Origammi\Bundle\BlocksBundle\Form\Event
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2014 Astina AG (http://astina.ch)
 */
class DefaultBlockPopulator implements EventSubscriberInterface
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
    public function onPostSetData(FormEvent $event)
    {
        // if there is data, we are editing, so we don't need to set up default blocks
        if ($event->getData()) {
            return;
        }

        $parentForm           = $event->getForm()->getParent();
        $propertyName         = $event->getForm()->getConfig()->getName();
        $blockCollectionData  = $this->blocksConverter->convert($parentForm->getData());
        $registeredBlockTypes = $this->blocksContainer->getBlockTypes();

        foreach ($blockCollectionData as $blockCollectionDataProperty) {
            if ($propertyName === $blockCollectionDataProperty->getPropertyName()) {
                $this->addDefaultBlocks($event, $blockCollectionDataProperty, $registeredBlockTypes);
            }
        }
    }

    /**
     * @param FormEvent                   $event
     * @param BlockCollectionData         $collectionData
     * @param ArrayCollection|BlockType[] $registeredBlockTypes
     *
     * @throws BlockNotFoundException
     */
    private function addDefaultBlocks(
        FormEvent $event,
        BlockCollectionData $collectionData,
        $registeredBlockTypes
    ) {
        foreach ($collectionData->getDefaults() as $key => $blockTypeName) {
            /** @var BlockType $blockType */
            $blockType = $registeredBlockTypes->get($blockTypeName);

            if (! $blockType) {
                throw new BlockNotFoundException(
                    $blockTypeName,
                    $collectionData->getPropertyName(),
                    $registeredBlockTypes->toArray()
                );
            }

            $event->getForm()->get('blocks')->add($key, $blockType->getName(), [
                'label'        => $blockType->getName(),
                'default_sort' => ($key + 1) * 10,
            ]);
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
            FormEvents::POST_SET_DATA => 'onPostSetData',
        ];
    }
}
