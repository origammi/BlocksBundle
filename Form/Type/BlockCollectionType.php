<?php

namespace Origammi\Bundle\BlocksBundle\Form\Type;

use Origammi\Bundle\BlocksBundle\BlocksContainer;
use Origammi\Bundle\BlocksBundle\Form\Event\AllowedBlocksInjector;
use Origammi\Bundle\BlocksBundle\Form\Event\BlockSorter;
use Origammi\Bundle\BlocksBundle\Form\Event\DefaultBlockPopulator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class BlocksCollectionType
 *
 * @package   Origammi\Bundle\BlocksBundle\Form\Type
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2015 Astina AG (http://astina.ch)
 */
class BlockCollectionType extends AbstractType
{
    /**]
     * @var DefaultBlockPopulator
     */
    private $blockPopulator;

    /**
     * @var AllowedBlocksInjector
     */
    private $allowedBlocksInjector;

    /**
     * @var BlocksContainer
     */
    private $blocksContainer;

    /**
     * @var BlockSorter
     */
    private $blockSorter;

    /**
     * @param DefaultBlockPopulator $blockListener
     * @param BlocksContainer       $blocksContainer
     * @param AllowedBlocksInjector $allowedBlocksInjector
     * @param BlockSorter           $blockSorter
     */
    public function __construct(
        DefaultBlockPopulator $blockListener,
        BlocksContainer $blocksContainer,
        AllowedBlocksInjector $allowedBlocksInjector,
        BlockSorter $blockSorter
    ){
        $this->blockPopulator        = $blockListener;
        $this->blocksContainer       = $blocksContainer;
        $this->allowedBlocksInjector = $allowedBlocksInjector;
        $this->blockSorter           = $blockSorter;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('blocks', 'infinite_form_polycollection', [
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
            'label'        => false,
            'types'        => $this->blocksContainer->getBlockTypeNames()
        ]);

        $builder->addEventSubscriber($this->blockPopulator);
        $builder->addEventSubscriber($this->allowedBlocksInjector);
        $builder->addEventSubscriber($this->blockSorter);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Origammi\Bundle\BlocksBundle\Entity\BlockCollection',
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'origammi_blocks';
    }
}
