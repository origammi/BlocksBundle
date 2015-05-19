<?php

namespace Origammi\Bundle\BlocksBundle\Test\Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Origammi\Bundle\BlocksBundle\Annotation as Origammi;
use Origammi\Bundle\BlocksBundle\Entity\BlockCollection;

/**
 * Class TestPost
 *
 * @package   Origammi\Bundle\BlocksBundle\Test\Application\Entity
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2015 Astina AG (http://astina.ch)
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TestPost
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var BlockCollection
     *
     * @ORM\ManyToOne(targetEntity="Origammi\Bundle\BlocksBundle\Entity\BlockCollection", cascade={"remove", "persist"})
     * @Origammi\BlockCollectionData(
     *  defaults={"lead", "text"},
     *  allowed={"lead", "text", "image", "quote", "video"},
     *  required={"lead"}
     * )
     */
    private $blocks;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return BlockCollection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * @param BlockCollection $blocks
     *
     * @return $this
     */
    public function setBlocks($blocks)
    {
        $this->blocks = $blocks;

        return $this;
    }
}
