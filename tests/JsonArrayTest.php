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

use LitGroup\Json\JsonArray;
use LitGroup\Json\JsonString;
use LitGroup\Json\JsonStructure;
use PHPUnit\Framework\TestCase;

class JsonArrayTest extends TestCase
{
    function testInstance(): void
    {
        $array = JsonArray::createBuilder()->build();
        self::assertInstanceOf(JsonStructure::class, $array);
    }

    function testValueType(): void
    {
        $array = JsonArray::createBuilder()->build();
        self::assertTrue($array->getValueType()->isArray());
    }

    function testIsNullPredicate(): void
    {
        $array = JsonArray::createBuilder()->build();
        self::assertFalse($array->isNull());
    }

    function testCount(): void
    {
        $array = JsonArray::createBuilder()->build();
        self::assertEquals(0, $array->count());

        $array = JsonArray::createBuilder()
            ->add(new JsonString('some string'))
            ->build();
        self::assertEquals(1, $array->count());
    }

    function testEmptyPredicate(): void
    {
        $array = JsonArray::createBuilder()->build();
        self::assertTrue($array->isEmpty());

        $array = JsonArray::createBuilder()
            ->add(new JsonString('some string'))
            ->build();
        self::assertFalse($array->isEmpty());
    }

    function testAccessJsonValueByIndex(): void
    {
        $value = new JsonString('some value');
        $array = JsonArray::createBuilder()
            ->add($value)
            ->build();

        self::assertTrue($value->equals($array->getJsonValue(0)));
    }

    function testIterator(): void
    {
        $element0 = new JsonString('one string');
        $element1 = new JsonString('another string');

        $array = JsonArray::createBuilder()
            ->add($element0)
            ->add($element1)
            ->build();

        $elements = [];
        foreach ($array as $element) {
            $elements[] = $element;
        }

        self::assertCount(2, $elements);
        self::assertTrue($element0->equals($elements[0]));
        self::assertTrue($element1->equals($elements[1]));
    }
}
