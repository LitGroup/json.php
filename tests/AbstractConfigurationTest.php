<?php
/**
 * This file is part of the "litgroup/json" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Test\LitGroup\Json;

use LitGroup\Json\AbstractConfiguration;

class AbstractConfigurationTest extends \PHPUnit_Framework_TestCase
{
    const DEPTH_DEFAULT = 512;
    const DEPTH_CUSTOM = 128;

    /**
     * @test
     */
    public function testDefaultDepth()
    {
        $this->assertSame(self::DEPTH_DEFAULT, $this->getConfiguration()->getMaxDepth());
    }

    /**
     * @test
     */
    public function testCustomDepth()
    {
        $config = $this->getConfiguration();

        $this->assertSame($config, $config->setMaxDepth(self::DEPTH_CUSTOM));
        $this->assertSame(self::DEPTH_CUSTOM, $config->getMaxDepth());
    }

    /**
     * @return array
     */
    public function getInvalidDepthTests()
    {
        return [[-1], [0]];
    }

    /**
     * @test
     * @dataProvider getInvalidDepthTests
     * @expectedException \InvalidArgumentException
     *
     * @param int $depth
     */
    public function testInvalidDepth($depth)
    {
        $this->getConfiguration()->setMaxDepth($depth);
    }

    /**
     * @return AbstractConfiguration
     */
    private function getConfiguration()
    {
        return $this->getMockForAbstractClass(AbstractConfiguration::class);
    }
}
