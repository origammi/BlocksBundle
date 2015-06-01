<?php

namespace Origammi\Bundle\BlocksBundle\Form\Block;

use Origammi\Bundle\BlocksBundle\Form\BlockType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class BlockImageType
 *
 * @package   Origammi\Bundle\BlocksBundle\Form\Block
 * @author    Jure Zitnik <jzitnik@astina.ch>
 * @copyright 2014 Astina AG (http://astina.ch)
 */
class GalleryType extends BlockType
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
            ->add(
                'images',
                'collection',
                [
                    'type'         => 'type_block_gallery_image',
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            );
    }

    /**
     * @return string
     */
    public function getDataClass()
    {
        return 'Origammi\Bundle\BlocksBundle\Entity\Block\Gallery';
    }

    /**
     * @return string
     */
    public function getBlockName()
    {
        return 'gallery';
    }
}
