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

use LitGroup\Json\JsonString;
use LitGroup\Json\JsonValue;
use PHPUnit\Framework\TestCase;

class JsonStringTest extends TestCase
{
    function testInstance(): void
    {
        self::assertInstanceOf(JsonValue::class, new JsonString(''));
    }

    function testIsNullPredicate(): void
    {
        self::assertFalse((new JsonString(''))->isNull());
    }

    function testIsEmptyPredicate(): void
    {
        self::assertTrue((new JsonString(''))->isEmpty());
        self::assertFalse((new JsonString('hello'))->isEmpty());
    }

    function testRetrievingOfStringValue(): void
    {
        $str = new JsonString('Hello');
        self::assertEquals('Hello', $str->stringValue());
    }

    function testEquality(): void
    {
        $str = new JsonString('Some string');

        self::assertTrue($str->equals(new JsonString('Some string')));
        self::assertFalse($str->equals(new JsonString('Another string')));
    }
}
