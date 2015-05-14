<?php

namespace Origammi\Bundle\BlocksBundle\Form\Block;

use Symfony\Component\Form\FormBuilderInterface;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class BlockInfoType
 *
 * @package   Origammi\Bundle\BlocksBundle\Form\Block
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2014 Astina AG (http://astina.ch)
 *
 * @DI\FormType
 */
class BlockInfoType extends BlockType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('rows', 'info_row_collection');
    }

    /**
     * @return string
     */
    public function getDataClass()
    {
        return 'AppBundle\Entity\Block\Info';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'type_block_info';
    }
}
