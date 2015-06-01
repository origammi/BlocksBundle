<?php

namespace Origammi\Bundle\BlocksBundle\Exception;

use Origammi\Bundle\BlocksBundle\Form\BlockType;

/**
 * Class BlockNotFoundException
 *
 * @package   Origammi\Bundle\BlocksBundle\Exception
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2015 Astina AG (http://astina.ch)
 */
class BlockNotFoundException extends \Exception
{
    /**
     * @param string          $blockName
     * @param string          $propertyName
     * @param array|BlockType $availableBlocks
     */
    public function __construct($blockName, $propertyName, array $availableBlocks)
    {
        $this->message = sprintf(
            "Block type `%s` is not registered for property `%s`.\nRegistered block types are: %s.",
            $blockName,
            $propertyName,
            implode(', ', array_keys($availableBlocks))
        );
    }
}
