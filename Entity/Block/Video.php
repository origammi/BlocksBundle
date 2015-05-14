<?php

namespace Origammi\Bundle\BlocksBundle\Entity\Block;

use Origammi\Bundle\BlocksBundle\Entity\Block;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Video
 *
 * @package   Origammi\Bundle\BlocksBundle\Entity\Block
 * @author    Matej Velikonja <mvelikonja@origammi.co>
 * @copyright 2014 Astina AG (http://origammi.co)
 *
 * @ORM\Entity
 * @ORM\Table(name="block_videos")
 * @Vich\Uploadable()
 */
class Video extends Block
{
    const PROVIDER_YOUTUBE = 'youtube';

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $caption;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $externalId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $provider;

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
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     *
     * @return $this
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param string $provider
     *
     * @return $this
     */
    public function setProvider($provider)
    {
        if (! in_array($provider, $this->getProviders())) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Provider `%s` is not valid. Use one of: %s.',
                    $provider,
                    implode(', ', $this->getProviders())
                )
            );
        }

        $this->provider = $provider;

        return $this;
    }

    /**
     * @return array
     */
    public function getProviders()
    {
        return ReflectionHelper::getConstants($this, 'PROVIDER_');
    }

    /**
     * Checks if block is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return !$this->getExternalId();
    }

    /**
     * @return string
     */
    public static function getType()
    {
        return 'video';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->externalId;
    }
}
