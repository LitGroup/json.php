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

use LitGroup\Json\JsonNull;
use LitGroup\Json\JsonObject;
use LitGroup\Json\JsonString;
use LitGroup\Json\JsonStructure;
use LitGroup\Json\JsonValueType;
use PHPUnit\Framework\TestCase;

class JsonObjectTest extends TestCase
{
    function testInstance(): void
    {
        $object = JsonObject::createBuilder()->build();
        self::assertInstanceOf(JsonStructure::class, $object);
        self::assertFalse($object->isNull());
        self::assertTrue($object->getValueType()->equals(JsonValueType::JsonObject()));
    }

    function testCount(): void
    {
        $object = JsonObject::createBuilder()->build();
        self::assertEquals(0, $object->count());

        $object = JsonObject::createBuilder()
            ->add('some_property', new JsonString('some string'))
            ->build();
        self::assertEquals(1, $object->count());
    }

    function testEmptyPredicate(): void
    {
        $object = JsonObject::createBuilder()->build();
        self::assertTrue($object->isEmpty());

        $object = JsonObject::createBuilder()
            ->add('some_property', new JsonString('some string'))
            ->build();
        self::assertFalse($object->isEmpty());
    }

    function testAccessByPropertyName(): void
    {
        $object = JsonObject::createBuilder()->build();
        self::assertInstanceOf(JsonNull::class, $object->getJsonValue('some_property'));

        $value = new JsonString('some string');
        $object = JsonObject::createBuilder()
            ->add('some_property', $value)
            ->build();
        self::assertTrue($value->equals(
            $object->getJsonValue('some_property')
        ));
    }

    function testIterationOfJsonValues(): void
    {
        $value = new JsonString('some string');
        $object = JsonObject::createBuilder()
            ->add('some_property', $value)
            ->build();

        $properties = [];
        foreach ($object as $name => $property) {
            $properties[$name] = $property;
        }
        self::assertCount(1, $properties);
        self::assertTrue($value->equals($properties['some_property']));
    }
}
