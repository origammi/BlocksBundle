<?php

namespace Origammi\Bundle\BlocksBundle\Annotation;

use Origammi\Bundle\BlocksBundle\Form\BlockType;

/**
 * Class BlockCollectionData
 *
 * @package   Origammi\Bundle\BlocksBundle\Annotation
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2015 Astina AG (http://astina.ch)
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
class BlockCollectionData
{
    /**
     * @var string
     */
    private $propertyName;

    /**
     * @var array<string>
     */
    private $defaults;

    /**
     * @var array<string>
     */
    private $allowed;

    /**
     * @var array<string>
     */
    private $required;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        foreach ($options as $key => $value) {
            if (! property_exists($this, $key)) {
                throw new \InvalidArgumentException(
                    sprintf('Property "%s" does not exist', $key)
                );
            }

            $setter = 'set' . ucfirst($key);

            if (method_exists($this, $setter)) {
                $this->$setter($value);
            } else {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * @return array
     */
    public function getAllowed()
    {
        return $this->allowed;
    }

    /**
     * @return array
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @return string
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * @param string $propertyName
     *
     * @return $this
     */
    public function setPropertyName($propertyName)
    {
        $this->propertyName = $propertyName;

        return $this;
    }

    /**
     * @param array $defaults
     *
     * @return $this
     */
    protected function setDefaults(array $defaults)
    {
        $this->defaults = $this->prefixBlocks($defaults);

        return $this;
    }

    /**
     * @param array $allowed
     *
     * @return $this
     */
    protected function setAllowed(array $allowed)
    {
        $this->allowed = $this->prefixBlocks($allowed);

        return $this;
    }

    /**
     * @param array $required
     *
     * @return $this
     */
    protected function setRequired(array $required)
    {
        $this->required = $this->prefixBlocks($required);

        return $this;
    }

    /**
     * @param array $blocks
     *
     * @return array
     */
    private function prefixBlocks(array $blocks)
    {
        $prefixed = [];

        foreach ($blocks as $name) {
            $prefixed[] = BlockType::BLOCK_PREFIX . $name;
        }

        return $prefixed;
    }
}