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

use LitGroup\Json\Json;

class JsonTest extends \PHPUnit_Framework_TestCase
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
    public function testDecode()
    {
        $this->assertSame(
            ['item' => 'Tesla Model S', 'amount' => 10, 'comment' => 'UTF8 Строка'],
            Json::getInstance()->decode('{"item":"Tesla Model S","amount":10,"comment":"UTF8 Строка"}')
        );
    }
}
