<?php

namespace Origammi\Bundle\BlocksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class BlockType
 *
 * @package   Origammi\Bundle\BlocksBundle\Form
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2014 Astina AG (http://astina.ch)
 */
abstract class BlockType extends AbstractType
{
    const BLOCK_PREFIX = 'origammi_block_';

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('sort', 'hidden', [
            'empty_data' => $options['default_sort']
        ]);

        $builder->add('_type', 'hidden', [
            'data'   => $this->getName(),
            'mapped' => false
        ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'         => $this->getDataClass(),
                'model_class'        => $this->getDataClass(),
                'label'              => $this->getName(),
                'translation_domain' => 'blocks',
                'default_sort'       => 0,
            ]
        );
    }

    /**
     * @return string
     */
    final public function getName()
    {
        return self::BLOCK_PREFIX . $this->getBlockName();
    }

    /**
     * @return string
     */
    abstract public function getDataClass();

    /**
     * @return string
     */
    abstract public function getBlockName();

    /**
     * @return string
     */
    public function getParent()
    {
        return 'origammi_block_default';
    }
}
