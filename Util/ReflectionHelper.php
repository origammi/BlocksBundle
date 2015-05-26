<?php

namespace Origammi\Bundle\BlocksBundle\Util;

/**
 * Class ReflectionHelper
 *
 * @package   Origammi\Bundle\BlocksBundle\Util
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2015 Astina AG (http://astina.ch)
 */
class ReflectionHelper
{
    /**
     * @param mixed  $object
     * @param string $prefix
     *
     * @return array
     */
    public static function getConstants($object, $prefix = null)
    {
        $reflection = new \ReflectionClass($object);
        $constants  = [];

        //search for all constants in this class that start with $prefix
        foreach ($reflection->getConstants() as $constName => $constValue) {
            if (!$prefix || strpos($constName, $prefix) === 0) {
                $constants[] = $constValue;
            }
        }

        return $constants;
    }
}
