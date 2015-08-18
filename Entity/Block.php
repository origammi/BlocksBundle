<?php

namespace Origammi\Bundle\BlocksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * Class Block
 *
 * @package   Origammi\Bundle\BlocksBundle\Entity
 * @author    Jure Zitnik <jzitnik@origammi.co>
 * @copyright 2014 Astina AG (http://origammi.co)
 *
 * @ORM\Entity
 * @ORM\Table(name="blocks")
 * @ORM\InheritanceType("JOINED")
 */
abstract class Block implements BlockInterface
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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @var BlockCollection|null
     *
     * @ORM\ManyToOne(targetEntity="BlockCollection", inversedBy="blocks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $collection;

    /**
     * Checks if block is empty.
     *
     * @return bool
     */
    abstract public function isEmpty();

    /**
     * @return string
     */
    abstract public function __toString();

    /**
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     *
     * @return $this
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return BlockCollection
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param BlockCollection|null $collection
     *
     * @return $this
     */
    public function setCollection(BlockCollection $collection = null)
    {
        $this->collection = $collection;

        return $this;
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
        }
    }
}
