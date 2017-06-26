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

use PHPUnit\Framework\TestCase;
use LitGroup\Json\DecoderConfiguration;

class DecoderConfigurationTest extends TestCase
{
    const OPTIONS_DEFAULT = 0;

    /**
     * @test
     */
    public function testUseAssoc()
    {
        $config = $this->getConfiguration();
        $this->assertTrue($config->getUseAssoc(), 'Assoc must be used by default.');

        $this->assertSame($config, $config->setUseAssoc(false));
        $this->assertFalse($config->getUseAssoc());

        $this->assertSame($config, $config->setUseAssoc(true));
        $this->assertTrue($config->getUseAssoc());
    }

    /**
     * @test
     */
    public function testDefaultOptions()
    {
        $this->assertSame(self::OPTIONS_DEFAULT, $this->getConfiguration()->getOptionsBitmask());
    }

    /**
     * @test
     */
    public function testBigIntAsString()
    {
        $config = $this->getConfiguration();

        $this->assertSame($config, $config->setBigIntAsString(true));
        $this->assertSame(\JSON_BIGINT_AS_STRING, $config->getOptionsBitmask());

        $this->assertSame($config, $config->setBigIntAsString(false));
        $this->assertSame(self::OPTIONS_DEFAULT, $config->getOptionsBitmask());
    }

    /**
     * @return DecoderConfiguration
     */
    private function getConfiguration()
    {
        return new DecoderConfiguration();
    }
}
