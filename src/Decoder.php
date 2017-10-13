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

namespace LitGroup\Json;

use const JSON_ERROR_NONE;
use function json_decode;
use function json_last_error;
use function json_last_error_msg;
use LitGroup\Json\Exception\FormatException;

class Decoder
{
    /**
     * @throws FormatException
     */
    public function decode(string $jsonString): JsonStructure
    {
        /** @var JsonStructure $jsonValue */
        $jsonValue = $this->scalarToJsonValue(
            $this->decodeToScalarValues($jsonString)
        );

        return $jsonValue;
    }

    /**
     * @throws FormatException
     */
    public function decodeObject(string $jsonString): JsonObject
    {
       $json = $this->decode($jsonString);

       if (!$json instanceof JsonObject) {
           throw new FormatException('JSON Object was expected but array was given.');
       }

       return $json;
    }

    /**
     * @throws FormatException
     */
    public function decodeArray(string $jsonString): JsonArray
    {
        $json = $this->decode($jsonString);

        if (!$json instanceof JsonArray) {
            throw new FormatException('JSON Array was expected but object was given.');
        }

        return $json;
    }

    /** @return array|\stdClass */
    private function decodeToScalarValues(string $jsonString)
    {
        $scalarValue = json_decode($jsonString, false);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new FormatException(json_last_error_msg());
        }

        if (!is_array($scalarValue) && !is_object($scalarValue)) {
            throw new FormatException('JSON must have a structural type on top.');
        }

        return $scalarValue;
    }

    private function scalarToJsonValue($scalarValue): JsonValue
    {
        switch (gettype($scalarValue)) {
            case 'NULL':
                return JsonNull::value();

            case 'string':
                return new JsonString($scalarValue);

            case 'integer':
            case 'double':
                return new JsonNumber($scalarValue);

            case 'boolean':
                return new JsonBoolean($scalarValue);

            case 'array':
                $arrayBuilder = JsonArray::createBuilder();
                foreach ($scalarValue as $scalarElement) {
                    $arrayBuilder->add($this->scalarToJsonValue($scalarElement));
                }

                return $arrayBuilder->build();

            case 'object':
                $objectBuilder = JsonObject::createBuilder();
                foreach ((array) $scalarValue as $name => $scalarProperty) {
                    $objectBuilder->add($name, $this->scalarToJsonValue($scalarProperty));
                }

                return $objectBuilder->build();

            default:
                throw new \RuntimeException('This line of code must not be reachable!'); // @codeCoverageIgnore
        }
    }
}