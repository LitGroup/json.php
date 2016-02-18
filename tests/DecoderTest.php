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


use LitGroup\Json\Decoder;
use LitGroup\Json\DecoderConfiguration;

class DecoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DecoderConfiguration
     */
    private $config;

    /**
     * @var Decoder
     */
    private $decoder;


    protected function setUp()
    {
        $this->config = new DecoderConfiguration();
        $this->decoder = new Decoder($this->config);
    }

    protected function tearDown()
    {
        $this->config = null;
        $this->decoder = null;
        json_encode(null); // To clear last error.
    }

    /**
     * @test
     */
    public function testDecode()
    {
        $this->config->setUseAssoc(true);

        $this->assertSame(
            ['item' => 'Tesla Model S', 'amount' => 10],
            $this->decoder->decode('{"item": "Tesla Model S", "amount": 10}')
        );
    }

    /**
     * @test
     */
    public function testDecodeObject()
    {
        $this->config->setUseAssoc(false);

        $data = $this->decoder->decode('{"item": "Tesla Model S", "amount": 10}');
        $this->assertInstanceOf(\stdClass::class, $data);
        $this->assertSame('Tesla Model S', $data->item);
        $this->assertSame(10, $data->amount);
    }

    /**
     * @test
     */
    public function testDecodeBigInt()
    {
        $this->config->setBigIntAsString(false);
        $this->assertEquals(
            json_decode('12345678901234567890'),
            $this->decoder->decode('12345678901234567890')
        );

        $this->config->setBigIntAsString(true);
        $this->assertSame(
            json_decode('12345678901234567890', false, 512, JSON_BIGINT_AS_STRING),
            $this->decoder->decode('12345678901234567890')
        );
    }

    /**
     * @test
     * @expectedException \LitGroup\Json\Exception\JsonException
     * @expectedExceptionCode \JSON_ERROR_SYNTAX
     */
    public function testSyntaxException()
    {
        $this->decoder->decode('Bad syntax');
    }

    /**
     * @test
     * @expectedException \LitGroup\Json\Exception\JsonException
     * @expectedExceptionCode \JSON_ERROR_DEPTH
     */
    public function testMaxDepthException()
    {
        $this->config->setMaxDepth(1);

        // Value with depth > 1
        $json = '{"sub_map": {}}';
        $this->decoder->decode($json);
    }
}
