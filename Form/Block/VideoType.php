<?php

namespace Origammi\Bundle\BlocksBundle\Form\Block;

use Origammi\Bundle\BlocksBundle\Entity\Block\Video;
use Origammi\Bundle\BlocksBundle\Form\BlockType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class BlockVideoType
 *
 * @package   Origammi\Bundle\BlocksBundle\Form\Block
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2014 Astina AG (http://astina.ch)
 */
class VideoType extends BlockType
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
            ->add('provider', 'hidden', [
                'data' => Video::PROVIDER_YOUTUBE
            ])
            ->add('externalId', 'text', [
                'required' => false
            ]);
    }

    /**
     * @return string
     */
    public function getDataClass()
    {
        return 'Origammi\Bundle\BlocksBundle\Entity\Block\Video';
    }

    /**
     * @return string
     */
    public function getBlockName()
    {
        return 'video';
    }
}
