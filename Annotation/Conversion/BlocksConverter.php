<?php

namespace Origammi\Bundle\BlocksBundle\Annotation\Conversion;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Collections\ArrayCollection;
use Origammi\Bundle\BlocksBundle\Annotation\BlockCollectionData;

class BlocksConverter
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var string
     */
    private $annotationClass = 'Origammi\\Bundle\\BlocksBundle\\Annotation\\BlockCollectionData';

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param $originalObject
     *
     * @return ArrayCollection|BlockCollectionData[]
     */
    public function convert($originalObject)
    {
        $annotations      = new ArrayCollection();
        $reflectionObject = new \ReflectionObject($originalObject);

        foreach ($reflectionObject->getProperties() as $property) {
            /** @var BlockCollectionData $annotation */
            $annotation = $this->reader->getPropertyAnnotation($property, $this->annotationClass);

            if (null !== $annotation) {
                $propertyName = $property->getName();
                $annotation->setPropertyName($propertyName);

                $annotations->add($annotation);
            }
        }

        return $annotations;
    }

}