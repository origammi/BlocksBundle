<?php

namespace Origammi\Bundle\BlocksBundle\Test\Form\Event;

use Origammi\Bundle\BlocksBundle\Entity\Block;
use Origammi\Bundle\BlocksBundle\Entity\BlockCollection;
use Origammi\Bundle\BlocksBundle\Form\Event\BlockSorter;
use Symfony\Component\Form\FormEvent;

class BlockSorterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests if blocks are sorted properly.
     */
    public function testBasicSorting()
    {
        $blockFirst  = new Block\Text(__CLASS__);
        $blockSecond = new Block\Text(__METHOD__);
        $collection  = new BlockCollection();

        $collection
            ->addBlock($blockFirst)
            ->addBlock($blockSecond);

        /** @var FormEvent|\PHPUnit_Framework_MockObject_MockObject $event */
        $event = $this
            ->getMockBuilder('Symfony\Component\Form\FormEvent')
            ->disableOriginalConstructor()
            ->getMock();

        $event
            ->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($collection));

        $sorter = new BlockSorter();

        $sorter->onSubmit($event);

        $this->assertEquals(10, $blockFirst->getSort());
        $this->assertEquals(20, $blockSecond->getSort());
    }
}
