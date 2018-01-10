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

namespace LitGroup\Json;


class Decoder
{
    /**
     * @throws FormatException
     */
    public function decodeObject(string $json): JsonObject
    {
        $structure = $this->decodeStructure($json);

        if ($structure instanceof JsonObject) {
            return $structure;
        }

        throw new FormatException();
    }

    /**
     * @throws FormatException
     */
    public function decodeArray(string $json): JsonArray
    {
        $structure = $this->decodeStructure($json);

        if ($structure instanceof JsonArray) {
            return $structure;
        }

        throw new FormatException();
    }

    /**
     * @throws FormatException
     */
    public function decodeStructure(string $json): JsonStructure
    {
        $decoded = json_decode($json, false);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new FormatException(json_last_error_msg());
        }

        if (!is_array($decoded) && !is_object($decoded)) {
            throw new FormatException();
        }

        return $this->convertValue($decoded);
    }

    private function convertValue($value)
    {
        switch (gettype($value)) {
            case 'NULL':
                return null;
            case 'integer':
            case 'double':
                return new JsonNumber($value);
            case 'string':
                return new JsonString($value);
            case 'boolean':
                return new JsonBoolean($value);
            case 'array':
                $builder = JsonArray::builder();
                foreach ($value as $element) {
                    $builder->addValue($this->convertValue($element));
                }

                return $builder->build();
            case 'object':
                $builder = JsonObject::builder();
                foreach ($value as $propertyKey => $propertyValue) {
                    $builder->setValue($propertyKey, $this->convertValue($propertyValue));
                }

                return $builder->build();
        }

        // @codeCoverageIgnoreStart
        throw new \RuntimeException('Must be unreachable');
        // @codeCoverageIgnoreEnd
    }
}