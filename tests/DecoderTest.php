<?php
/**
 * Copyright 2016 – 2017 LitGroup, LLC
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
use LitGroup\Json\Exception\FormatException;
use LitGroup\Json\JsonArray;
use LitGroup\Json\JsonNumber;
use LitGroup\Json\JsonObject;
use LitGroup\Json\JsonString;
use PHPUnit\Framework\TestCase;

class DecoderTest extends TestCase
{
    /** @var Decoder */
    private $decoder;

    protected function setUp(): void
    {
        $this->decoder = new Decoder();
    }

    function testDecodeObject(): void
    {
        /** @var JsonObject $json */
        $json = $this->decoder->decode(
            '{
                "string_val": "some string",
                "int_val": 100,
                "double_val": 100.1,
                "true_val": true,
                "false_val": false,
                "null_val": null,
                "object_val": {},
                "array_val": []
            }'
        );

        self::assertInstanceOf(JsonObject::class, $json);
        self::assertTrue($json->getJsonValue('string_val')->equals(new JsonString('some string')));
        self::assertTrue($json->getJsonValue('int_val')->equals(new JsonNumber(100)));
        self::assertTrue($json->getJsonValue('double_val')->equals(new JsonNumber(100.1)));
        self::assertTrue($json->getJsonValue('true_val')->isTrue());
        self::assertTrue($json->getJsonValue('false_val')->isFalse());
        self::assertTrue($json->getJsonValue('null_val')->isNull());
        self::assertTrue($json->getJsonValue('object_val')->getValueType()->isObject());
        self::assertTrue($json->getJsonValue('array_val')->getValueType()->isArray());
    }

    function testDecodeArray(): void
    {
        /** @var JsonArray $json */
        $json = $this->decoder->decode(
            '[
                "some string",
                100,
                100.1,
                true,
                false,
                null,
                {},
                []
            ]'
        );

        self::assertInstanceOf(JsonArray::class, $json);
        self::assertTrue($json->getJsonValue(0)->equals(new JsonString('some string')));
        self::assertTrue($json->getJsonValue(1)->equals(new JsonNumber(100)));
        self::assertTrue($json->getJsonValue(2)->equals(new JsonNumber(100.1)));
        self::assertTrue($json->getJsonValue(3)->isTrue());
        self::assertTrue($json->getJsonValue(4)->isFalse());
        self::assertTrue($json->getJsonValue(5)->isNull());
        self::assertTrue($json->getJsonValue(6)->getValueType()->isObject());
        self::assertTrue($json->getJsonValue(7)->getValueType()->isArray());
    }

    function getInvalidJsonExamples(): array
    {
        return [
            [''],
            ['{}}'],
            ['[]]'],
            ['10'],
            ['10.1'],
            ['"some string"'],
            ['true'],
            ['false'],
            ['null'],
        ];
    }

    /** @dataProvider getInvalidJsonExamples */
    function testExceptionOnInvalidJsonDecoding(string $jsonString): void
    {
        $this->expectException(FormatException::class);
        $this->decoder->decode($jsonString);
    }

    function testDecodeExactlyObject(): void
    {
        $object = $this->decoder->decodeObject('{"name": "value"}');
        self::assertEquals(1, $object->count());
    }

    function testDecodeExactlyObjectExceptionWhenDecodeArray(): void
    {
        $this->expectException(FormatException::class);
        $this->decoder->decodeObject('[]');
    }

    function testDecodeExactlyArray(): void
    {
        $array = $this->decoder->decodeArray('["some string"]');
        self::assertEquals(1, $array->count());
    }

    function testDecodeExactlyArrayExceptionWhenDecodeObject(): void
    {
        $this->expectException(FormatException::class);
        $this->decoder->decodeArray('{}');
    }
}
