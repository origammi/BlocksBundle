<?php

namespace Origammi\Bundle\BlocksBundle\Entity\Block;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class GalleryImage
 *
 * @package   Origammi\Bundle\BlocksBundle\Entity\Block
 * @author    Jure Zitnik <jzitnik@origammi.co>
 * @copyright 2014 Astina AG (http://origammi.co)
 *
 * @ORM\Entity
 * @ORM\Table(name="block_galleries_images")
 * @Vich\Uploadable()
 */
class GalleryImage
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
     * @var Gallery|null
     *
     * @ORM\ManyToOne(targetEntity="Gallery", inversedBy="images")
     */
    private $gallery;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Gallery|null
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param Gallery|null $gallery
     *
     * @return $this
     */
    public function setGallery(Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->gallery->getCaption();
    }
}
