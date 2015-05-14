<?php

namespace Origammi\Bundle\BlocksBundle\Form\Block;

use AppBundle\Entity\Block\Video;
use Symfony\Component\Form\FormBuilderInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class BlockVideoType
 *
 * @package   Origammi\Bundle\BlocksBundle\Form\Block
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2014 Astina AG (http://astina.ch)
 *
 * @DI\FormType
 */
class BlockVideoType extends BlockType
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
        return 'AppBundle\Entity\Block\Video';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'type_block_video';
    }
}
