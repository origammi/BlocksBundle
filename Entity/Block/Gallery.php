<?php

namespace Origammi\Bundle\BlocksBundle\Entity\Block;

use Origammi\Bundle\BlocksBundle\Entity\Block;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Gallery
 *
 * @package   Origammi\Bundle\BlocksBundle\Entity\Block
 * @author    Jure Zitnik <jzitnik@origammi.co>
 * @copyright 2014 Astina AG (http://origammi.co)
 *
 * @ORM\Entity
 * @ORM\Table(name="block_galleries")
 */
class Gallery extends Block
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $caption;

    /**
     * @var ArrayCollection|GalleryImage[]
     *
     * @ORM\OneToMany(
     *  targetEntity="Origammi\Bundle\BlocksBundle\Entity\Block\GalleryImage",
     *  mappedBy="gallery",
     *  orphanRemoval=true,
     *  cascade={"remove", "persist"}
     * )
     * @Assert\Valid()
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|GalleryImage[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param GalleryImage $image
     *
     * @return $this
     */
    public function addImage(GalleryImage $image)
    {
        $image->setGallery($this);

        $this->images->add($image);

        return $this;
    }

    /**
     * @param GalleryImage $image
     *
     * @return $this
     */
    public function removeImage(GalleryImage $image)
    {
        $this->images->removeElement($image);

        // we set image's gallery to null, so orphanRemoval=true removes it automatically
        $image->setGallery(null);

        return $this;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param string $caption
     *
     * @return $this
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * @return string
     */
    public static function getType()
    {
        return 'gallery';
    }

    /**
     * @return GalleryImage|null
     */
    public function getFirstImage()
    {
        return $this->images->first();
    }

    /**
     * Checks if block is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return 0 === $this->getImages()->count();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->caption;
    }
}
