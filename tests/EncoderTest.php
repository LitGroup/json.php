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

use LitGroup\Json\Encoder;
use LitGroup\Json\JsonArray;
use LitGroup\Json\JsonObject;
use PHPUnit\Framework\TestCase;

class EncoderTest extends TestCase
{
    function testEncodeObject(): void
    {
        $encoder = new Encoder();

        $this->assertJsonStringEqualsJsonString(
            '{
                "some-int": 100,
                "some-float": 100.0,
                "some-bool": true,
                "another-bool": false,
                "some-string": "some string",
                "some-object": {},
                "some-array": [],
                "some-null": null
            }',
            $encoder->encode(
                JsonObject::builder()
                    ->setInt('some-int', 100)
                    ->setFloat('some-float', 100.0)
                    ->setBool('some-bool', true)
                    ->setBool('another-bool', false)
                    ->setString('some-string', 'some string')
                    ->setBuilder('some-object', JsonObject::builder())
                    ->setBuilder('some-array', JsonArray::builder())
                    ->setString('some-null', null)
                    ->build()
            )
        );
    }

    function testEncodeArray(): void
    {
        $encoder = new Encoder();

        $this->assertJsonStringEqualsJsonString(
            '[
                100,
                100.0,
                true,
                false,
                "some string",
                {},
                [],
                null
            ]',
            $encoder->encode(
                JsonArray::builder()
                    ->addInt(100)
                    ->addFloat(100.0)
                    ->addBool(true)
                    ->addBool(false)
                    ->addString('some string')
                    ->addBuilder(JsonObject::builder())
                    ->addBuilder(JsonArray::builder())
                    ->addString(null)
                    ->build()
            )
        );
    }
}
