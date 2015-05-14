<?php

namespace Origammi\Bundle\BlocksBundle\Form\Event;

use Origammi\Bundle\BlocksBundle\Entity\Block;
use Origammi\Bundle\BlocksBundle\Entity\BlockCollection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class BlockSorter
 *
 * @package   Origammi\Bundle\BlocksBundle\Form\Event
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2015 Astina AG (http://astina.ch)
 */
class BlockSorter implements EventSubscriberInterface
{
    /**
     * @param FormEvent $event
     */
    public function onSubmit(FormEvent $event)
    {
        $collection = $event->getData();
        $sort       = 10;
        $step       = 10;

        if (! $collection instanceof BlockCollection) {
            return;
        }

        foreach ($collection->getBlocks() as $block) {
            $block->setSort(null);

            if (! $block->isEmpty()) {
                $block->setSort($sort);

                $sort += $step;
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
            FormEvents::SUBMIT => 'onSubmit',
        ];
    }
}
