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

namespace Tests\LitGroup\Json;


use LitGroup\Json\JsonArray;
use LitGroup\Json\JsonBoolean;
use LitGroup\Json\JsonNumber;
use LitGroup\Json\JsonObject;
use LitGroup\Json\JsonString;
use PHPUnit\Framework\TestCase;

class JsonObjectBuilderTest extends TestCase
{
    function testSetJsonValue(): void
    {
        $object = JsonObject::builder()
            ->setValue('str', new JsonString(''))
            ->setValue('num', new JsonNumber(10))
            ->setValue('null', null)
            ->build();

        $this->assertInstanceOf(JsonString::class, $object->getJsonValue('str'));
        $this->assertInstanceOf(JsonNumber::class, $object->getJsonValue('num'));
        $this->assertNull($object->getOptionalJsonValue('null'));
    }

    function testSetScalarValue(): void
    {
        $object = JsonObject::builder()

            ->setString('str', 'some string')
            ->setString('null-str', null)

            ->setInt('int', 100)
            ->setInt('null-int', null)

            ->setFloat('float', 100.0)
            ->setFloat('null-float', null)

            ->setBool('bool', true)
            ->setBool('null-bool', null)

            ->build();

        $this->assertInstanceOf(JsonString::class, $object->getJsonValue('str'));
        $this->assertNull($object->getOptionalJsonValue('null-str'));

        $this->assertInstanceOf(JsonNumber::class, $object->getJsonValue('int'));
        $this->assertNull($object->getOptionalJsonValue('null-int'));

        $this->assertInstanceOf(JsonNumber::class, $object->getJsonValue('float'));
        $this->assertNull($object->getOptionalJsonValue('null-float'));

        $this->assertInstanceOf(JsonBoolean::class, $object->getJsonValue('bool'));
        $this->assertNull($object->getOptionalJsonValue('null-bool'));
    }

    function testSetStructureBuilder(): void
    {
        $object = JsonObject::builder()
            ->setBuilder('obj', JsonObject::builder())
            ->setBuilder('arr', JsonArray::builder())
            ->build();

        $this->assertInstanceOf(JsonObject::class, $object->getJsonValue('obj'));
        $this->assertInstanceOf(JsonArray::class, $object->getJsonValue('arr'));
    }
}