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


use LitGroup\Json\FormatException;
use LitGroup\Json\JsonArray;
use LitGroup\Json\JsonObject;
use PHPUnit\Framework\TestCase;

class JsonObjectTypedReadingTest extends TestCase
{
    /**
     * @throws FormatException
     */
    function testGetOptionalString(): void
    {
        $object = JsonObject::builder()
            ->setString('str', 'some string')
            ->setString('empty', null)
            ->setInt('not-a-string', 100)
            ->build();

        $this->assertSame('some string', $object->getOptionalString('str'));
        $this->assertNull($object->getOptionalString('empty'));
        $this->assertNull($object->getOptionalString('none'));

        try  {
            $object->getOptionalString('not-a-string');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetString(): void
    {
        $object = JsonObject::builder()
            ->setString('str', 'some string')
            ->setString('empty', null)
            ->setInt('not-a-string', 100)
            ->build();

        $this->assertSame('some string', $object->getString('str'));

        try  {
            $object->getString('empty');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try  {
            $object->getString('none');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try  {
            $object->getString('not-a-string');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetOptionalBool(): void
    {
        $object = JsonObject::builder()
            ->setBool('true', true)
            ->setBool('false', false)
            ->setBool('empty', null)
            ->setInt('not-a-bool', 100)
            ->build();

        $this->assertTrue($object->getOptionalBool('true'));
        $this->assertFalse($object->getOptionalBool('false'));
        $this->assertNull($object->getOptionalBool('empty'));
        $this->assertNull($object->getOptionalBool('none'));

        try {
            $object->getOptionalBool('not-a-bool');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetBool(): void
    {
        $object = JsonObject::builder()
            ->setBool('true', true)
            ->setBool('false', false)
            ->setInt('not-a-bool', 100)
            ->build();

        $this->assertTrue($object->getBool('true'));
        $this->assertFalse($object->getBool('false'));

        try {
            $object->getBool('none');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try {
            $object->getBool('not-a-bool');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetOptionalFloat(): void
    {
        $object = JsonObject::builder()
            ->setFloat('float', 100.0)
            ->setInt('int', 100)
            ->setFloat('empty', null)
            ->setString('not-a-number', '100.0')
            ->build();

        $this->assertEquals(100.0, $object->getOptionalFloat('float'));
        $this->assertEquals(100.0, $object->getOptionalFloat('int'));
        $this->assertNull($object->getOptionalFloat('empty'));
        $this->assertNull($object->getOptionalFloat('none'));

        try {
            $object->getOptionalFloat('not-a-number');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetFloat(): void
    {
        $object = JsonObject::builder()
            ->setFloat('float', 100.0)
            ->setInt('int', 100)
            ->setString('not-a-number', '100.0')
            ->build();

        $this->assertEquals(100.0, $object->getFloat('float'));
        $this->assertEquals(100.0, $object->getFloat('int'));

        try {
            $object->getFloat('none');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try {
            $object->getFloat('not-a-number');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetOptionalInt(): void
    {
        $object = JsonObject::builder()
            ->setInt('int', 100)
            ->setFloat('float', 100.8)
            ->setInt('empty', null)
            ->setString('not-a-number', '100')
            ->build();

        $this->assertSame(100, $object->getOptionalInt('int'));
        $this->assertSame(100, $object->getOptionalInt('float'));
        $this->assertNull($object->getOptionalInt('empty'));
        $this->assertNull($object->getOptionalInt('none'));

        try {
            $object->getOptionalInt('not-a-number');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetInt(): void
    {
        $object = JsonObject::builder()
            ->setInt('int', 100)
            ->setFloat('float', 100.8)
            ->setString('not-a-number', '100')
            ->build();

        $this->assertSame(100, $object->getInt('int'));
        $this->assertSame(100, $object->getInt('float'));

        try {
            $object->getInt('not-a-number');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try {
            $object->getInt('none');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetOptionalIntExact(): void
    {
        $object = JsonObject::builder()
            ->setInt('int', 100)
            ->setFloat('float', 100.8)
            ->setInt('empty', null)
            ->setString('not-a-number', '100')
            ->build();

        $this->assertSame(100, $object->getOptionalIntExact('int'));
        $this->assertNull($object->getOptionalIntExact('empty'));
        $this->assertNull($object->getOptionalIntExact('none'));

        try {
            $object->getOptionalIntExact('float');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try {
            $object->getOptionalIntExact('not-a-number');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetIntExact(): void
    {
        $object = JsonObject::builder()
            ->setInt('int', 100)
            ->setFloat('float', 100.8)
            ->setString('not-a-number', '100')
            ->build();

        $this->assertSame(100, $object->getIntExact('int'));

        try {
            $object->getIntExact('float');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try {
            $object->getIntExact('not-a-number');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try {
            $object->getIntExact('none');
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetJsonObject(): void
    {
        $object = JsonObject::builder()
            ->setBuilder('object', JsonObject::builder())
            ->setBuilder('array', JsonArray::builder())
            ->build();

        $this->assertInstanceOf(JsonObject::class, $object->getJsonObject('object'));

        try {
            $object->getJsonObject('array');
            $this->fail();
        } catch (FormatException $e) {}
        try {
            $object->getJsonObject('none');
            $this->fail();
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetJsonArray(): void
    {
        $object = JsonObject::builder()
            ->setBuilder('array', JsonArray::builder())
            ->setBuilder('object', JsonObject::builder())
            ->build();

        $this->assertInstanceOf(JsonArray::class, $object->getJsonArray('array'));

        try {
            $object->getJsonArray('object');
            $this->fail();
        } catch (FormatException $e) {}
        try {
            $object->getJsonArray('none');
            $this->fail();
        } catch (FormatException $e) {}
    }
}