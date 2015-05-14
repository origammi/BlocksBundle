<?php

namespace Origammi\Bundle\BlocksBundle\Entity\Block;

use Origammi\Bundle\BlocksBundle\Entity\Block;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Lead
 *
 * @package   Origammi\Bundle\BlocksBundle\Entity\Block
 * @author    Jure Zitnik <jzitnik@origammi.co>
 * @copyright 2014 Astina AG (http://origammi.co)
 *
 * @ORM\Entity
 * @ORM\Table(name="block_leads")
 */
class Lead extends Block
{
    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $text;

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Checks if block is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return !$this->getText();
    }

    /**
     * @return string
     */
    public static function getType()
    {
        return 'lead';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->text;
    }
}
