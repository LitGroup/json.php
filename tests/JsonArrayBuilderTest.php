<?php
/**
 * Copyright (c) 2018 LitGroup, LLC
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

declare(strict_types=1);

namespace Test\LitGroup\Json;

use LitGroup\Json\FormatException;
use LitGroup\Json\JsonArray;
use LitGroup\Json\JsonObject;
use LitGroup\Json\JsonString;
use PHPUnit\Framework\TestCase;

class JsonArrayBuilderTest extends TestCase
{
    /**
     * @throws FormatException
     */
    function testAddJsonValue(): void
    {
        $value = new JsonString('');
        $anotherValue = new JsonString('');

        $array = JsonArray::builder()
            ->addValue($value)
            ->addValue($anotherValue)
            ->addValue(null)
            ->build();

        $this->assertSame($value, $array->getJsonValue(0));
        $this->assertSame($anotherValue, $array->getJsonValue(1));
        $this->assertNull($array->getOptionalJsonValue(2));
    }

    /**
     * @throws FormatException
     */
    function testAddString(): void
    {
        $array = JsonArray::builder()
            ->addString('one')
            ->addString('another')
            ->addString(null)
            ->build();

        $this->assertSame('one', $array->getJsonValue(0)->toString());
        $this->assertSame('another', $array->getJsonValue(1)->toString());
        $this->assertNull($array->getOptionalJsonValue(2));
    }

    /**
     * @throws FormatException
     */
    function testAddInt(): void
    {
        $array = JsonArray::builder()
            ->addInt(10)
            ->addInt(20)
            ->addInt(null)
            ->build();

        $this->assertSame(10, $array->getJsonValue(0)->toIntExact());
        $this->assertSame(20, $array->getJsonValue(1)->toIntExact());
        $this->assertNull($array->getOptionalJsonValue(2));
    }

    /**
     * @throws FormatException
     */
    function testAddFloat(): void
    {
        $array = JsonArray::builder()
            ->addFloat(10.1)
            ->addFloat(20.1)
            ->addFloat(null)
            ->build();

        $this->assertEquals(10.1, $array->getJsonValue(0)->toFloat());
        $this->assertEquals(20.1, $array->getJsonValue(1)->toFloat());
        $this->assertNull($array->getOptionalJsonValue(2));
    }

    /**
     * @throws FormatException
     */
    function testAddBool(): void
    {
        $array = JsonArray::builder()
            ->addBool(true)
            ->addBool(false)
            ->addBool(null)
            ->build();

        $this->assertTrue($array->getJsonValue(0)->toBool());
        $this->assertFalse($array->getJsonValue(1)->toBool());
        $this->assertNull($array->getOptionalJsonValue(2));
    }

    /**
     * @throws FormatException
     */
    function testAddBuilder(): void
    {
        $array = JsonArray::builder()
            ->addBuilder(JsonArray::builder())
            ->addBuilder(JsonObject::builder())
            ->addBuilder(null)
            ->build();

        $this->assertInstanceOf(JsonArray::class, $array->getJsonValue(0));
        $this->assertInstanceOf(JsonObject::class, $array->getJsonValue(1));
        $this->assertNull($array->getOptionalJsonValue(2));
    }
}
