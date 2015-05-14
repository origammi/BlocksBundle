<?php

namespace Origammi\Bundle\BlocksBundle\Form;

use Symfony\Component\Form\AbstractType;

/**
 * Class BlockDefaultType
 *
 * The type is used only for templating all blocks with the same markup.
 *
 * @package   Origammi\Bundle\BlocksBundle\Form
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2014 Astina AG (http://astina.ch)
 */
class BlockDefaultType extends AbstractType
{
    /**
     * @return string
     */
    public function getName()
    {
        return BlockType::BLOCK_PREFIX . 'default';
    }
}
