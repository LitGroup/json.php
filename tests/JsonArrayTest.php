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
use LitGroup\Json\JsonString;
use LitGroup\Json\JsonStructure;
use PHPUnit\Framework\TestCase;

class JsonArrayTest extends TestCase
{
    function testType(): void
    {
        $this->assertInstanceOf(JsonStructure::class, JsonArray::builder()->build());
    }

    function testCount(): void
    {
        $array = JsonArray::builder()->build();
        $this->assertSame(0, $array->count());

        $array = JsonArray::builder()
            ->addValue(new JsonString('some-value'))
            ->addValue(null)
            ->build();
        $this->assertSame(2, $array->count());
    }

    function testEmptyPredicate(): void
    {
        $array = JsonArray::builder()->build();
        $this->assertTrue($array->isEmpty());

        $array = JsonArray::builder()
            ->addValue(new JsonString('some-value'))
            ->addValue(null)
            ->build();
        $this->assertFalse($array->isEmpty());
    }

    function testGetOptionalElement(): void
    {
        $value = new JsonString('');
        $anotherValue = new JsonString('');

        $array = JsonArray::builder()
            ->addValue($value)
            ->addValue($anotherValue)
            ->addValue(null)
            ->build();

        $this->assertSame($value, $array->getOptionalJsonValue(0));
        $this->assertSame($anotherValue, $array->getOptionalJsonValue(1));
        $this->assertNull($array->getOptionalJsonValue(2));

        try {
            $array->getOptionalJsonValue(-1);
            $this->fail();
        } catch (\OutOfBoundsException $e) {}

        try {
            $array->getOptionalJsonValue(3);
            $this->fail();
        } catch (\OutOfBoundsException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetElement(): void
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

        try {
            $array->getJsonValue(-1);
            $this->fail();
        } catch (\OutOfBoundsException $e) {}

        try {
            $array->getJsonValue(3);
            $this->fail();
        } catch (\OutOfBoundsException $e) {}

        try {
            $array->getJsonValue(2);
            $this->fail();
        } catch (FormatException $e) {}
    }
}
