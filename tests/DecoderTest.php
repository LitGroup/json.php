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

use LitGroup\Json\Decoder;
use LitGroup\Json\FormatException;
use LitGroup\Json\JsonArray;
use LitGroup\Json\JsonObject;
use PHPUnit\Framework\TestCase;

class DecoderTest extends TestCase
{
    /**
     * @var Decoder
     */
    private $decoder;

    protected function setUp()
    {
        $this->decoder = new Decoder();
    }

    /**
     * @throws FormatException
     */
    function testDecodeStructure_Object(): void
    {
        $object = $this->decoder->decodeStructure(
            '{
                "some-int": 100,
                "some-float": 100.0,
                "another-float": 100.5,
                "some-bool": true,
                "another-bool": false,
                "some-string": "some string",
                "some-object": {},
                "some-array": [],
                "some-null": null
            }'
        );

        if (!$object instanceof JsonObject) {
            $this->fail('JsonObject was expected.');
        }

        $this->assertSame(9, $object->count());
        $this->assertEquals(100, $object->getIntExact('some-int'));
        $this->assertEquals(100.0, $object->getFloat('some-float'));
        $this->assertEquals(100.5, $object->getFloat('another-float'));
        $this->assertTrue($object->getBool('some-bool'));
        $this->assertFalse($object->getBool('another-bool'));
        $this->assertEquals('some string', $object->getString('some-string'));
        $this->assertTrue($object->getJsonObject('some-object')->isEmpty());
        $this->assertTrue($object->getJsonArray('some-array')->isEmpty());
        $this->assertTrue($object->containsNull('some-null'));
    }

    /**
     * @throws FormatException
     */
    function testDecodeStructure_Array(): void
    {
        $array = $this->decoder->decodeStructure(
            '[
                100,
                100.0,
                100.5,
                true,
                false,
                "some string",
                {},
                [],
                null
            ]'
        );

        if (!$array instanceof JsonArray) {
            $this->fail('JsonArray was expected.');
        }

        $this->assertSame(9, $array->count());
        $this->assertEquals(100, $array->getIntExact(0));
        $this->assertEquals(100.0, $array->getFloat(1));
        $this->assertEquals(100.5, $array->getFloat(2));
        $this->assertTrue($array->getBool(3));
        $this->assertFalse($array->getBool(4));
        $this->assertEquals('some string', $array->getString(5));
        $this->assertTrue($array->getJsonObject(6)->isEmpty());
        $this->assertTrue($array->getJsonArray(7)->isEmpty());
        $this->assertNull($array->getOptionalJsonValue(8));
    }

    function getMalformedJsonExamples(): array
    {
        return [
            [''],
            ['{some: malformed}'],
            ['"string"'],
            ['100'],
            ['100.5'],
            ['true'],
            ['false'],
            ['null'],
        ];
    }

    /**
     * @dataProvider getMalformedJsonExamples
     * @throws FormatException
     */
    function testDecodeStructure_MalformedJson(string $json): void
    {
        $this->expectException(FormatException::class);
        $this->decoder->decodeStructure($json);
    }

    function testDecodeObject(): void
    {
        $object = $this->decoder->decodeObject('{}');
        $this->assertTrue($object->isEmpty());
    }

    function testDecodeObject_tryToDecodeArrayInsteadOfObject(): void
    {
        $this->expectException(FormatException::class);
        $this->decoder->decodeObject('[]');
    }

    function testDecodeArray(): void
    {
        $array = $this->decoder->decodeArray('[]');
        $this->assertTrue($array->isEmpty());
    }

    function testDecodeArray_tryToDecodeObjectInsteadOfArray(): void
    {
        $this->expectException(FormatException::class);
        $this->decoder->decodeArray('{}');
    }
}
