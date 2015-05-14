<?php

namespace Origammi\Bundle\BlocksBundle\Entity;

/**
 * Interface Block
 *
 * @package   Origammi\Bundle\BlocksBundle\Entity
 * @author    Jure Zitnik <jzitnik@origammi.co>
 * @copyright 2014 Astina AG (http://origammi.co)
 */
interface BlockInterface
{
    /**
     * @return string
     */
    public static function getType();
}
