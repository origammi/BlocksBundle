<?php

namespace Origammi\Bundle\BlocksBundle\Form\Block\Block;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class BlockGalleryImageType
 *
 * @package   Origammi\Bundle\BlocksBundle\Form\Block
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2014 Astina AG (http://astina.ch)
 *
 * @DI\FormType
 */
class BlockGalleryImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'imageFile',
            'vich_file',
            [
                'required'     => false,
                'allow_delete' => false,
            ]
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'  => 'Origammi\Bundle\BlocksBundle\Entity\Block\GalleryImage',
                'model_class' => 'Origammi\Bundle\BlocksBundle\Entity\Block\GalleryImage',
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'type_block_gallery_image';
    }
}
