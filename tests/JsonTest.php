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
use LitGroup\Json\Decoder;
use LitGroup\Json\Encoder;
use LitGroup\Json\Json;

class JsonTest extends TestCase
{
    /**
     * @test
     */
    public function testGetInstance()
    {
        $json = Json::getInstance();
        $this->assertInstanceOf(Json::class, $json);

        $this->assertSame($json, Json::getInstance(), 'LitGroup\Json\Json must be a Singleton');
    }

    /**
     * @test
     */
    public function testEncode()
    {
        $this->assertSame(
            '{"item":"Tesla Model S","amount":10,"comment":"UTF8 Строка"}',
            Json::getInstance()->encode(['item' => 'Tesla Model S', 'amount' => 10, 'comment' => 'UTF8 Строка'])
        );
    }

    /**
     * @test
     */
    public function testGetEncoder()
    {
        $this->assertInstanceOf(Encoder::class, Json::getInstance()->getEncoder());
    }

    /**
     * @test
     */
    public function testGetDecoder()
    {
        $this->assertInstanceOf(Decoder::class, Json::getInstance()->getDecoder());
    }

    /**
     * @test
     */
    public function testDecode()
    {
        $this->assertSame(
            ['item' => 'Tesla Model S', 'amount' => 10, 'comment' => 'UTF8 Строка'],
            Json::getInstance()->decode('{"item":"Tesla Model S","amount":10,"comment":"UTF8 Строка"}')
        );
    }
}
