<?php

namespace Origammi\Bundle\BlocksBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Origammi\Bundle\BlocksBundle\Form\BlockType;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * Class BlockCollection
 *
 * @package   Origammi\Bundle\BlocksBundle\Entity
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2015 Astina AG (http://astina.ch)
 *
 * @ORM\Entity
 * ORM\Table(name="blocks")
 * ORM\InheritanceType("JOINED")
 */
class BlockCollection implements \ArrayAccess, \IteratorAggregate
{
    use Timestampable;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Collection|Block[]
     *
     * @ORM\OneToMany(
     *   targetEntity="Origammi\Bundle\BlocksBundle\Entity\Block",
     *   mappedBy="collection",
     *   orphanRemoval=true,
     *   cascade={"remove", "persist"}
     * )
     * @ORM\OrderBy({"sort" = "ASC"})
     * @Assert\Valid()
     */
    private $blocks;

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection|Block[]
     */
    public function getBlocks()
    {
        // TODO: this should not be necessary anymore when we have doctrine >=2.5.0
        // https://github.com/doctrine/doctrine2/commit/a906295c65f1516737458fbee2f6fa96254f27a5
        if (! $this->blocks) {
            $this->blocks = new ArrayCollection();
        }

        return $this->blocks;
    }

    /**
     * @param Collection|Block[] $blocks
     *
     * @return $this
     */
    public function setBlocks(Collection $blocks)
    {
        foreach ($blocks as $block) {
            $block->setGroup($this);
        }

        $this->blocks = $blocks;

        return $this;
    }

    /**
     * @param Block $block
     *
     * @return $this
     */
    public function removeBlock(Block $block)
    {
        $this->blocks->removeElement($block);

        return $this;
    }

    /**
     * @param Block $block
     *
     * @return $this
     */
    public function addBlock(Block $block)
    {
        $block->setCollection($this);
        $this->blocks->add($block);

        return $this;
    }

    /**
     * @param BlockType $type
     *
     * @return bool
     */
    public function hasBlockType(BlockType $type)
    {
        foreach ($this->getBlocks() as $block) {
            if ($block::getType() == $type->getBlockName()) {
                return true;
            }
        }

        return false;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return $this->blocks->offsetExists($offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->blocks->offsetGet($offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->blocks->offsetSet($offset, $value);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->blocks->offsetUnset($offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     *
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     *       <b>Traversable</b>
     */
    public function getIterator()
    {
        return $this->blocks->getIterator();
    }

    /**
     * Clone object.
     */
    public function __clone()
    {
        if ($this->id) {
            $this->id        = null;
            $this->createdAt = null;
            $this->updatedAt = null;
            $blocks          = $this->blocks;
            $this->blocks    = new ArrayCollection();

            foreach ($blocks as $block) {
                $clonedBlock = clone ($block);
                $clonedBlock->setCollection($this);

                $this->blocks->add($clonedBlock);
            }
        }
    }
}
