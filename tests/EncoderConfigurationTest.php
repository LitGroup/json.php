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
use LitGroup\Json\EncoderConfiguration;

class EncoderConfigurationTest extends TestCase
{
    /**
     * @test
     */
    public function testDefaultOptions()
    {
        $this->assertSame(
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
            $this->getConfiguration()->getOptionsBitmask()
        );
    }

    /**
     * @return array
     */
    public function getSingleOptionTests()
    {
        return [
            ['HexQuot', JSON_HEX_QUOT],
            ['HexTag', JSON_HEX_TAG],
            ['HexAmp', JSON_HEX_AMP],
            ['HexApos', JSON_HEX_APOS],
            ['NumericCheck', JSON_NUMERIC_CHECK],
            ['PrettyPrint', JSON_PRETTY_PRINT],
            ['UnescapedSlashes', JSON_UNESCAPED_SLASHES],
            ['UnescapedUnicode', JSON_UNESCAPED_UNICODE],
            ['ForceObject', JSON_FORCE_OBJECT],
            ['PartialOutputOnError', JSON_PARTIAL_OUTPUT_ON_ERROR],
        ];
    }
    /**
     * @test
     * @dataProvider getSingleOptionTests
     *
     * @param string $option
     * @param int    $bitmask
     */
    public function testSingleOption($option, $bitmask)
    {
        $config = $this->getConfiguration();

        $this->assertSame($config, call_user_func([$config, "set{$option}"], true));
        $this->assertSame($bitmask, $config->getOptionsBitmask() & $bitmask);

        $this->assertSame($config, call_user_func([$config, "set{$option}"], false));
        $this->assertSame(0, $config->getOptionsBitmask() & $bitmask);
    }

    /**
     * @return array
     */
    public function getMultipleOptionsTests()
    {
        return [
            [
                ['HexQuot', 'HexApos', 'HexTag', 'HexAmp', 'ForceObject'],
                JSON_HEX_QUOT | JSON_HEX_APOS | JSON_HEX_TAG | JSON_HEX_AMP | JSON_FORCE_OBJECT,
            ],
            [
                ['PrettyPrint', 'UnescapedSlashes', 'UnescapedUnicode', 'NumericCheck'],
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK,
            ],
        ];
    }
    /**
     * @test
     * @dataProvider getMultipleOptionsTests
     *
     * @param string[] $options
     * @param int      $bitmask
     */
    public function testMultipleOptions(array $options, $bitmask)
    {
        $config = $this->getConfiguration();

        foreach ($options as $option) {
            call_user_func([$config, "set{$option}"], true);
        }
        $this->assertSame($bitmask, $config->getOptionsBitmask() & $bitmask);
    }

    /**
     * @return EncoderConfiguration
     */
    private function getConfiguration()
    {
        return new EncoderConfiguration();
    }
}
