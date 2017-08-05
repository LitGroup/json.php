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

use LitGroup\Json\JsonValueType;
use PHPUnit\Framework\TestCase;

class JsonValueTypeTest extends TestCase
{
    function testTypeEnumeration(): void
    {
        $type = JsonValueType::JsonNull();
        self::assertTrue($type->isNull());
        self::assertFalse($type->isNumber());

        $type = JsonValueType::JsonNumber();
        self::assertTrue($type->isNumber());
        self::assertFalse($type->isNull());

        $type = JsonValueType::JsonString();
        self::assertTrue($type->isString());
        self::assertFalse($type->isNull());


        $type = JsonValueType::JsonBoolean();
        self::assertTrue($type->isBoolean());
        self::assertFalse($type->isNull());

        $type = JsonValueType::JsonArray();
        self::assertTrue($type->isArray());
        self::assertFalse($type->isNull());
    }

    function testEquality(): void
    {
        self::assertTrue(JsonValueType::JsonNumber() === JsonValueType::JsonNumber());
        self::assertFalse(JsonValueType::JsonNumber() === JsonValueType::JsonString());

        // Do not to use non-strict equality check in a client code!!!
        self::assertTrue(JsonValueType::JsonNumber() == JsonValueType::JsonNumber());
        self::assertFalse(JsonValueType::JsonNumber() == JsonValueType::JsonString());

        self::assertTrue(JsonValueType::JsonNumber()->equals(JsonValueType::JsonNumber()));
        self::assertFalse(JsonValueType::JsonNumber()->equals(JsonValueType::JsonString()));
    }
}
