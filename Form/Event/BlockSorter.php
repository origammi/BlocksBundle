<?php

namespace Origammi\Bundle\BlocksBundle\Form\Event;

use Origammi\Bundle\BlocksBundle\Entity\Block;
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
    public function preSubmit(FormEvent $event)
    {
        $collection = $event->getData();
        $sort       = 10;
        $step       = 10;

        if (! isset($collection['blocks'])) {
            return;
        }

        foreach ($collection['blocks'] as &$block) {
            if (! isset($block['sort'])) {
                throw new \LogicException(sprintf('Block `%s` does not have a sort field.', $block['_type']));
            }

            $block['sort'] = $sort;
            $sort += $step;
        }

        // set back data, since we are using array which is not passed by reference
        $event->setData($collection);
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
            FormEvents::PRE_SUBMIT=> 'preSubmit',
        ];
    }
}
