<?php

namespace Origammi\Bundle\BlocksBundle;

use Doctrine\Common\Collections\ArrayCollection;
use Origammi\Bundle\BlocksBundle\Entity\Block;
use Origammi\Bundle\BlocksBundle\Form\BlockType;

class BlocksContainer
{
    /**
     * @var ArrayCollection|BlockType[]
     */
    private $blockTypes;

    public function __construct()
    {
        $this->blockTypes = new ArrayCollection();
    }

    public function addBlockType(BlockType $block)
    {
        $this->blockTypes->set(
            $block->getName(),
            $block
        );

        return $this;
    }

    /**
     * @return ArrayCollection|BlockType[]
     */
    public function getBlockTypes()
    {
        return $this->blockTypes;
    }

    /**
     * @return array|string[]
     */
    public function getBlockTypeNames()
    {
        $names = [];

        foreach ($this->getBlockTypes() as $blockType) {
            $names[] = $blockType->getName();
        }

        return $names;
    }
}
