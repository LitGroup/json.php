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

class JsonArrayTypedReadingTest extends TestCase
{
    /**
     * @throws FormatException
     */
    function testGetOptionalString(): void
    {
        $array = JsonArray::builder()
            ->addString('some string')
            ->addString(null)
            ->addInt(100)
            ->build();

        $this->assertSame('some string', $array->getOptionalString(0));
        $this->assertNull($array->getOptionalString(1));

        try  {
            $array->getOptionalString(2);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetString(): void
    {
        $array = JsonArray::builder()
            ->addString('some string')
            ->addString(null)
            ->addInt(100)
            ->build();

        $this->assertSame('some string', $array->getString(0));

        try  {
            $array->getString(1);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try  {
            $array->getString(2);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetOptionalBool(): void
    {
        $array = JsonArray::builder()
            ->addBool(true)
            ->addBool(false)
            ->addBool(null)
            ->addInt(100)
            ->build();

        $this->assertTrue($array->getOptionalBool(0));
        $this->assertFalse($array->getOptionalBool(1));
        $this->assertNull($array->getOptionalBool(2));

        try {
            $array->getOptionalBool(3);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetBool(): void
    {
        $array = JsonArray::builder()
            ->addBool(true)
            ->addBool(false)
            ->addInt(100)
            ->addBool(null)
            ->build();

        $this->assertTrue($array->getBool(0));
        $this->assertFalse($array->getBool(1));

        try {
            $array->getBool(2);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try {
            $array->getBool(3);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetOptionalFloat(): void
    {
        $array = JsonArray::builder()
            ->addFloat(100.0)
            ->addInt(100)
            ->addFloat(null)
            ->addString('100.0')
            ->build();

        $this->assertEquals(100.0, $array->getOptionalFloat(0));
        $this->assertEquals(100.0, $array->getOptionalFloat(1));
        $this->assertNull($array->getOptionalFloat(2));

        try {
            $array->getOptionalFloat(3);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetFloat(): void
    {
        $array = JsonArray::builder()
            ->addFloat(100.0)
            ->addInt(100)
            ->addString('100.0')
            ->addFloat(null)
            ->build();

        $this->assertEquals(100.0, $array->getFloat(0));
        $this->assertEquals(100.0, $array->getFloat(1));

        try {
            $array->getFloat(2);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try {
            $array->getFloat(3);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetOptionalInt(): void
    {
        $array = JsonArray::builder()
            ->addInt(100)
            ->addFloat(100.8)
            ->addInt(null)
            ->addString('100')
            ->build();

        $this->assertSame(100, $array->getOptionalInt(0));
        $this->assertSame(100, $array->getOptionalInt(1));
        $this->assertNull($array->getOptionalInt(2));

        try {
            $array->getOptionalInt(3);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetInt(): void
    {
        $array = JsonArray::builder()
            ->addInt(100)
            ->addFloat(100.8)
            ->addString('100')
            ->addInt(null)
            ->build();

        $this->assertSame(100, $array->getInt(0));
        $this->assertSame(100, $array->getInt(1));

        try {
            $array->getInt(2);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try {
            $array->getInt(3);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetOptionalIntExact(): void
    {
        $array = JsonArray::builder()
            ->addInt(100)
            ->addInt(null)
            ->addFloat(100.8)
            ->addString('100')
            ->build();

        $this->assertSame(100, $array->getOptionalIntExact(0));
        $this->assertNull($array->getOptionalIntExact(1));

        try {
            $array->getOptionalIntExact(2);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try {
            $array->getOptionalIntExact(3);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetIntExact(): void
    {
        $array = JsonArray::builder()
            ->addInt(100)
            ->addFloat(100.8)
            ->addString('100')
            ->addInt(null)
            ->build();

        $this->assertSame(100, $array->getIntExact(0));

        try {
            $array->getIntExact(1);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try {
            $array->getIntExact(2);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
        try {
            $array->getIntExact(3);
            $this->fail('FormatException expected.');
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetOptionalJsonObject(): void
    {
        $array = JsonArray::builder()
            ->addBuilder(JsonObject::builder())
            ->addBuilder(null)
            ->addBuilder(JsonArray::builder())
            ->build();

        $this->assertInstanceOf(JsonObject::class, $array->getOptionalJsonObject(0));
        $this->assertNull($array->getOptionalJsonObject(1));

        try {
            $array->getOptionalJsonObject(2);
            $this->fail();
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetJsonObject(): void
    {
        $array = JsonArray::builder()
            ->addBuilder(JsonObject::builder())
            ->addBuilder(JsonArray::builder())
            ->addBuilder(null)
            ->build();

        $this->assertInstanceOf(JsonObject::class, $array->getJsonObject(0));

        try {
            $array->getJsonObject(1);
            $this->fail();
        } catch (FormatException $e) {}
        try {
            $array->getJsonObject(2);
            $this->fail();
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetOptionalJsonArray(): void
    {
        $array = JsonArray::builder()
            ->addBuilder(JsonArray::builder())
            ->addBuilder(null)
            ->addBuilder(JsonObject::builder())
            ->build();

        $this->assertInstanceOf(JsonArray::class, $array->getOptionalJsonArray(0));
        $this->assertNull($array->getOptionalJsonArray(1));

        try {
            $array->getOptionalJsonArray(2);
            $this->fail();
        } catch (FormatException $e) {}
    }

    /**
     * @throws FormatException
     */
    function testGetJsonArray(): void
    {
        $array = JsonArray::builder()
            ->addBuilder(JsonArray::builder())
            ->addBuilder(JsonObject::builder())
            ->addBuilder(null)
            ->build();

        $this->assertInstanceOf(JsonArray::class, $array->getJsonArray(0));

        try {
            $array->getJsonArray(1);
            $this->fail();
        } catch (FormatException $e) {}
        try {
            $array->getJsonArray(2);
            $this->fail();
        } catch (FormatException $e) {}
    }
}