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
use LitGroup\Json\JsonStructure;
use PHPUnit\Framework\TestCase;

class JsonObjectTest extends TestCase
{
    function testType(): void
    {
        $this->assertInstanceOf(JsonStructure::class, JsonObject::builder()->build());
    }

    function testCount(): void
    {
        $object = JsonObject::builder()->build();
        $this->assertSame(0, $object->count());

        $object = JsonObject::builder()
            ->setValue('some-property', new JsonString('some string'))
            ->setValue('null-property', null)
            ->build();
        $this->assertSame(2, $object->count());
    }

    function testEmptyPredicate(): void
    {
        $object = JsonObject::builder()->build();
        $this->assertTrue($object->isEmpty());

        $object = JsonObject::builder()
            ->setString('prop', '')
            ->build();
        $this->assertFalse($object->isEmpty());
    }

    function testHasPropertyPredicate(): void
    {
        $object = JsonObject::builder()
            ->setValue('some-property', new JsonString('some string'))
            ->setValue('null-property', null)
            ->build();

        $this->assertTrue($object->hasProperty('some-property'));
        $this->assertTrue($object->hasProperty('null-property'));
        $this->assertFalse($object->hasProperty('another-property'));
    }

    /**
     * @throws FormatException
     */
    function testJsonValue(): void
    {
        $object = JsonObject::builder()
            ->setValue('some-property', new JsonString('some string'))
            ->setValue('another-property', new JsonString('another string'))
            ->setValue('null-property', null)
            ->build();

        $this->assertSame('some string', $object->getJsonValue('some-property')->toString());
        $this->assertSame('another string', $object->getJsonValue('another-property')->toString());

        try {
            $object->getJsonValue('null-property');
            $this->fail();
        } catch (FormatException $e) {}

        try {
            $object->getJsonValue('no-property');
            $this->fail();
        } catch (FormatException $e) {}
    }

    function testOptionalJsonValue(): void
    {
        $object = JsonObject::builder()
            ->setValue('some-property', new JsonString('some string'))
            ->setValue('null-property', null)
            ->build();

        $this->assertSame('some string', $object->getOptionalJsonValue('some-property')->toString());

        $this->assertNull($object->getOptionalJsonValue('null-property'));
        $this->assertNull($object->getOptionalJsonValue('no-property'));
    }

    function testKeys(): void
    {
        $object = JsonObject::builder()->build();
        $this->assertSame([], $object->getKeys());

        $object = JsonObject::builder()
            ->setString('propA', '')
            ->setString('propB', '')
            ->build();
        $this->assertSame(['propA', 'propB'], $object->getKeys());
    }

    function testPropertyTest(): void
    {
        $object = JsonObject::builder()
            ->setString('string', '')
            ->setInt('int', 100)
            ->setFloat('float', 100.0)
            ->setBool('true', true)
            ->setBool('false', false)
            ->setString('null', null)
            ->setBuilder('object', JsonObject::builder())
            ->setBuilder('array', JsonArray::builder())
            ->build();

        $this->assertTrue($object->containsNull('null'));
        $this->assertTrue($object->containsNull('not-defined'));
        $this->assertFalse($object->containsNull('string'));

        $this->assertTrue($object->containsString('string'));
        $this->assertFalse($object->containsString('int'));
        $this->assertFalse($object->containsString('null'));

        $this->assertTrue($object->containsNumber('int'));
        $this->assertTrue($object->containsNumber('float'));
        $this->assertFalse($object->containsNumber('string'));
        $this->assertFalse($object->containsNumber('null'));

        $this->assertTrue($object->containsInt('int'));
        $this->assertFalse($object->containsInt('float'));
        $this->assertFalse($object->containsInt('string'));
        $this->assertFalse($object->containsInt('null'));

        $this->assertTrue($object->containsFloat('float'));
        $this->assertTrue($object->containsFloat('int'));
        $this->assertFalse($object->containsFloat('string'));
        $this->assertFalse($object->containsFloat('null'));

        $this->assertTrue($object->containsBool('true'));
        $this->assertTrue($object->containsBool('false'));
        $this->assertFalse($object->containsBool('string'));
        $this->assertFalse($object->containsBool('null'));

        $this->assertTrue($object->containsObject('object'));
        $this->assertFalse($object->containsObject('array'));
        $this->assertFalse($object->containsObject('null'));

        $this->assertTrue($object->containsArray('array'));
        $this->assertFalse($object->containsArray('object'));
        $this->assertFalse($object->containsArray('null'));
    }
}
