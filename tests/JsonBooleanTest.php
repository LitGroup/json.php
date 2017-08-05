<?php
/**
 * Copyright 2016 – 2017 LitGroup LLC
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

use LitGroup\Json\JsonBoolean;
use LitGroup\Json\JsonValue;
use LitGroup\Json\JsonValueType;
use PHPUnit\Framework\TestCase;

class JsonBooleanTest extends TestCase
{
    function testInstance(): void
    {
        self::assertInstanceOf(JsonValue::class, new JsonBoolean(true));
    }

    function testFactories(): void
    {
        self::assertTrue(JsonBoolean::trueValue()->getBool());
        self::assertFalse(JsonBoolean::falseValue()->getBool());
    }

    function testIsNullPredicate(): void
    {
        self::assertFalse(JsonBoolean::trueValue()->isNull());
        self::assertFalse(JsonBoolean::falseValue()->isNull());
    }

    function testValueType(): void
    {
        $jsonBoolean = JsonBoolean::trueValue();
        self::assertTrue($jsonBoolean->getValueType()->isBoolean());
    }

    function testBoolValue(): void
    {
        $jsonBoolean= new JsonBoolean(true);
        self::assertTrue($jsonBoolean->getBool());

        $jsonBoolean= new JsonBoolean(false);
        self::assertFalse($jsonBoolean->getBool());
    }

    function testPredicates(): void
    {
        $jsonBoolean = new JsonBoolean(true);
        self::assertTrue($jsonBoolean->isTrue());
        self::assertFalse($jsonBoolean->isFalse());

        $jsonBoolean = new JsonBoolean(false);
        self::assertFalse($jsonBoolean->isTrue());
        self::assertTrue($jsonBoolean->isFalse());
    }

    function testEquality(): void
    {
        $jsonBoolean = new JsonBoolean(true);

        self::assertTrue($jsonBoolean->equals(new JsonBoolean(true)));
        self::assertFalse($jsonBoolean->equals(new JsonBoolean(false)));
    }
}
