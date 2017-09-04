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

use LitGroup\Json\Encoder;
use LitGroup\Json\JsonArray;
use LitGroup\Json\JsonBoolean;
use LitGroup\Json\JsonNull;
use LitGroup\Json\JsonNumber;
use LitGroup\Json\JsonObject;
use LitGroup\Json\JsonObjectBuilder;
use LitGroup\Json\JsonString;
use PHPUnit\Framework\TestCase;

class EncoderTest extends TestCase
{
    /** @var Encoder */
    private $encoder;

    protected function setUp(): void
    {
        $this->encoder = new Encoder();
    }

    function testEncodeEmptyArray(): void
    {
        $array = JsonArray::createBuilder()->build();
        self::assertEquals('[]', $this->encoder->encode($array));
    }

    function testEncodeEmptyObject(): void
    {
        $object = JsonObject::createBuilder()->build();
        self::assertEquals('{}', $this->encoder->encode($object));
    }

    function testEncode(): void
    {
        $object = JsonObject::createBuilder()
            ->add('string_val', new JsonString('some string'))
            ->add('true_val', JsonBoolean::trueValue())
            ->add('false_val', JsonBoolean::falseValue())
            ->add('null_val', JsonNull::value())
            ->add('int_val', new JsonNumber(100))
            ->add('double_val', new JsonNumber(100.0))
            ->add('object_val', JsonObject::createBuilder()->build())
            ->add('array_val', JsonArray::createBuilder()->build())
            ->add(
                "array_of_strings",
                JsonArray::createBuilder()
                    ->add(new JsonString('some string'))
                    ->build()
            )
            ->add(
                "array_of_booleans",
                JsonArray::createBuilder()
                    ->add(JsonBoolean::trueValue())
                    ->add(JsonBoolean::falseValue())
                    ->build()
            )
            ->add(
                "array_of_nulls",
                JsonArray::createBuilder()
                    ->add(JsonNull::value())
                    ->build()
            )
            ->add(
                "array_of_integers",
                JsonArray::createBuilder()
                    ->add(new JsonNumber(100))
                    ->build()
            )
            ->add(
                "array_of_doubles",
                JsonArray::createBuilder()
                    ->add(new JsonNumber(100.1))
                    ->build()
            )
            ->add(
                "array_of_arrays",
                JsonArray::createBuilder()
                    ->add(JsonArray::createBuilder()->build())
                    ->build()
            )
            ->add(
                "array_of_objects",
                JsonArray::createBuilder()
                    ->add(JsonObject::createBuilder()->build())
                    ->build()
            )
            ->build();

        self::assertJsonStringEqualsJsonString(
            '{
                "string_val": "some string",
                "true_val": true,
                "false_val": false,
                "null_val": null,
                "int_val": 100,
                "double_val": 100.0,
                "object_val": {},
                "array_val": [],
                "array_of_strings": ["some string"],
                "array_of_booleans": [true, false],
                "array_of_nulls": [null],
                "array_of_integers": [100],
                "array_of_doubles": [100.1],
                "array_of_arrays": [[]],
                "array_of_objects": [{}]
            }',
            $this->encoder->encode($object)
        );
    }
}