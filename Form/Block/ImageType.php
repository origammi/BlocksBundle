<?php

namespace Origammi\Bundle\BlocksBundle\Form\Block;

use Origammi\Bundle\BlocksBundle\Form\BlockType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ImageType
 *
 * @package   Origammi\Bundle\BlocksBundle\Form\Block
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2014 Astina AG (http://astina.ch)
 */
class ImageType extends BlockType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('caption')
            ->add('image', 'vich_file', [
                'required' => false,
            ]);
    }

    /**
     * @return string
     */
    public function getDataClass()
    {
        return 'Origammi\Bundle\BlocksBundle\Entity\Block\Image';
    }

    /**
     * @return string
     */
    public function getBlockName()
    {
        return 'image';
    }
}
