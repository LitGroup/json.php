<?php
/**
 * This file is part of the "litgroup/json" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\LitGroup\Json;

use LitGroup\Json\Encoder;
use LitGroup\Json\EncoderConfiguration;

class EncoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EncoderConfiguration|\PHPUnit_Framework_MockObject_MockObject
     */
    private $config;

    /**
     * @var Encoder
     */
    private $encoder;


    protected function setUp()
    {
        $this->config = $this->getMock(EncoderConfiguration::class, ['getOptionsBitmask']);
        $this->encoder = new Encoder($this->config);
    }

    protected function tearDown()
    {
        $this->config = null;
        $this->encoder = null;
        json_encode(null); // To clear last error.
    }

    public function getEncodeTests()
    {
        return [
            [0,                           'Привет, мир!'                               ],
            [JSON_UNESCAPED_UNICODE,      'Привет, мир!'                               ],
            [JSON_UNESCAPED_SLASHES,      '/'                                          ],
            [JSON_HEX_TAG,                'Text with <tag>'                            ],
            [JSON_HEX_QUOT|JSON_HEX_APOS, 'Text with " and \''                         ],
            [JSON_HEX_AMP,                'Text with &'                                ],
            [JSON_NUMERIC_CHECK,          '01027'                                      ],
            [JSON_PRETTY_PRINT,           ['test' => ['name' => 'Pretty Print Option']]],
            [JSON_FORCE_OBJECT,           []                                           ],
        ];
    }
    /**
     * @test
     * @dataProvider getEncodeTests
     *
     * @param int $options
     * @param mixed $value
     */
    public function testEncode($options, $value)
    {
        $this->config
            ->expects($this->any())
            ->method('getOptionsBitmask')
            ->willReturn($options)
        ;
        $this->assertSame(json_encode($value, $options), $this->encoder->encode($value));
    }
    /**
     * @test
     * @expectedException \LitGroup\Json\Exception\JsonException
     */
    public function testMaxDepthException()
    {
        $this->config->setMaxDepth(1);

        // Value with depth > 1
        $value = ['sub_array' => []];
        $this->encoder->encode($value);
    }
}
