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
use LitGroup\Json\JsonNumber;
use LitGroup\Json\JsonValue;
use PHPUnit\Framework\TestCase;

class JsonNumberTest extends TestCase
{
    function testType(): void
    {
        $this->assertInstanceOf(JsonValue::class, new JsonNumber(100));
    }

    function testInstantiateWithWrongValueType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new JsonNumber('100');
    }

    function testIntegrityPredicate(): void
    {
        $number = new JsonNumber(100);
        $this->assertTrue($number->isIntegral());

        $number = new JsonNumber(100.0);
        $this->assertFalse($number->isIntegral());
    }

    function testConvertToFloat(): void
    {
        $floatNumber = new JsonNumber(100.0);
        $this->assertEquals(100.0, $floatNumber->toFloat());

        $intNumber = new JsonNumber(100);
        $this->assertEquals(100.0, $intNumber->toFloat());
    }

    function testConvertToInt(): void
    {
        $intNumber = new JsonNumber(100);
        $this->assertSame(100, $intNumber->toInt());

        $floatNumber = new JsonNumber(100.8);
        $this->assertSame(100, $floatNumber->toInt());
    }

    /**
     * @throws FormatException
     */
    function testToIntExact(): void
    {
        $intNumber = new JsonNumber(100);
        $this->assertSame(100, $intNumber->toIntExact());

        $floatNumber = new JsonNumber(100.8);
        $this->expectException(FormatException::class);
        $floatNumber->toIntExact();
    }
}
