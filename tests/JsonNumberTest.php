<?php
/**
 * Copyright (c) 2016 – 2017 Roman Shamritskiy
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

use LitGroup\Json\JsonNumber;
use LitGroup\Json\JsonValue;
use PHPUnit\Framework\TestCase;

class JsonNumberTest extends TestCase
{
    function testInstance(): void
    {
        self::assertInstanceOf(JsonValue::class, new JsonNumber(10));
        self::assertInstanceOf(JsonValue::class, new JsonNumber(10.0));
    }

    function testInstantiationExceptionForNotNumber(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new JsonNumber('123');
        new JsonNumber(new \stdClass());
    }

    function testIsNullPredicate(): void
    {
        self::assertFalse((new JsonNumber(10))->isNull());
    }

    function testValueType(): void
    {
        $number = new JsonNumber(10);
        self::assertTrue($number->getValueType()->isNumber());
    }

    function testEquality(): void
    {
        $number = new JsonNumber(10);
        self::assertTrue($number->equals(new JsonNumber(10)));
        self::assertTrue($number->equals(new JsonNumber(10.0)));
        self::assertFalse($number->equals(new JsonNumber(11)));
        self::assertFalse($number->equals(new JsonNumber(9.99)));

        $number = new JsonNumber(10.0);
        self::assertTrue($number->equals(new JsonNumber(10)));
        self::assertTrue($number->equals(new JsonNumber(10.0)));
        self::assertFalse($number->equals(new JsonNumber(11)));
        self::assertFalse($number->equals(new JsonNumber(9.99)));

        $number = new JsonNumber(10.0);
        self::assertTrue($number->equals(new JsonNumber(10), 0.1));
        self::assertTrue($number->equals(new JsonNumber(10.0), 0.1));
        self::assertTrue($number->equals(new JsonNumber(9.9), 0.1));
        self::assertTrue($number->equals(new JsonNumber(9.99), 0.1));
        self::assertTrue($number->equals(new JsonNumber(10.1), 0.1));

        self::assertFalse($number->equals(new JsonNumber(9.8), 0.1));
        self::assertFalse($number->equals(new JsonNumber(9.89), 0.1));
        self::assertFalse($number->equals(new JsonNumber(10.11), 0.1));
    }

    function testExceptionFOrNegativePrecisionDuringEqualityCheck(): void
    {
        $number = new JsonNumber(10);
        $this->expectException(\InvalidArgumentException::class);

        $number->equals($number, -0.1);
    }

    function testIsIntegralPredicate(): void {
        $number = new JsonNumber(10);
        self::assertTrue($number->isIntegral());

        $number = new JsonNumber(10.0);
        self::assertFalse($number->isIntegral());

        $number = new JsonNumber(10.01);
        self::assertFalse($number->isIntegral());
    }

    function testIntValue(): void
    {
        $number = new JsonNumber(10);
        self::assertEquals(10, $number->intValue());

        $number = new JsonNumber(10.0);
        self::assertEquals(10, $number->intValue());

        $number = new JsonNumber(10.1);
        self::assertEquals(10, $number->intValue());
    }

    function testFloatValue(): void
    {
        $number = new JsonNumber(10.0);
        self::assertEquals(10.0, $number->floatValue());

        $number = new JsonNumber(10.1);
        self::assertEquals(10.1, $number->floatValue());

        $number = new JsonNumber(10);
        self::assertEquals(10.0, $number->floatValue());
    }
}
