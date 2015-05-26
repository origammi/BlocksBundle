<?php

namespace Origammi\Bundle\BlocksBundle\Test\Util;

use Origammi\Bundle\BlocksBundle\Util\ReflectionHelper;

/**
 * Class ReflectionHelperTest
 *
 * @package   Origammi\Bundle\BlocksBundle\Test\Util
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2015 Astina AG (http://astina.ch)
 */
class ReflectionHelperTest extends \PHPUnit_Framework_TestCase
{
    const TEST_CONST1   = 1;
    const TEST_CONST2   = 2;
    const TEST_CONST3   = 3;
    const EXAMPLE_CONST = 'test constant';

    /**
     * Test if helper returns all constants of class.
     */
    public function testIfAllConstantsAreReturned()
    {
        $constants = ReflectionHelper::getConstants($this);

        $this->assertCount(4, $constants);
    }

    /**
     * Test if helper returns all prefixed constants of class.
     */
    public function testIfAllPrefixedConstantsAreReturned()
    {
        $constants = ReflectionHelper::getConstants($this, 'TEST_');

        $this->assertCount(3, $constants);
    }

    /**
     * Test if helper returns proper constant value.
     */
    public function testIfProperConstantValueIsReturned()
    {
        $constants = ReflectionHelper::getConstants($this, 'EXAMPLE_');

        $this->assertEquals(self::EXAMPLE_CONST, $constants[0]);
    }
}
