<?php

namespace Origammi\Bundle\BlocksBundle\Entity\Block;

use Origammi\Bundle\BlocksBundle\Entity\Block;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Generic
 *
 * @package   Origammi\Bundle\BlocksBundle\Entity\Block
 * @author    Jure Zitnik <jzitnik@origammi.co>
 * @copyright 2014 Astina AG (http://origammi.co)
 */
class Generic extends Block
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var string $subType
     */
    private $subType;

    public function __construct($subType = null, $data = null)
    {
        $this->subType = $subType;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getSubType()
    {
        return $this->subType;
    }

    /**
     * @param string $subType
     *
     * @return $this
     */
    public function setSubType($subType)
    {
        $this->subType = $subType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return string
     */
    public static function getType()
    {
        return 'generic';
    }

    /**
     * Checks if block is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->data === null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->data);
    }
}
