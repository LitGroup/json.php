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

namespace LitGroup\Json;

use function json_encode;
use const JSON_UNESCAPED_UNICODE;
use const JSON_UNESCAPED_SLASHES;

class Encoder
{
    public function encode(JsonStructure $json): string
    {
        return json_encode(
            $this->convertToScalarValues($json),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRESERVE_ZERO_FRACTION
        );
    }

    /**
     * @return array|\stdClass
     */
    private function convertToScalarValues(JsonValue $jsonValue)
    {
        switch ($jsonValue->getValueType()) {
            case JsonValueType::JsonString():
                /** @var JsonString $jsonValue */
                return $jsonValue->toString();

            case JsonValueType::JsonBoolean():
                /** @var JsonBoolean $jsonValue */
                return $jsonValue->toBool();

            case JsonValueType::JsonNull():
                return null;

            case JsonValueType::JsonNumber():
                /** @var JsonNumber $jsonValue */
                if ($jsonValue->isIntegral()) {
                    return $jsonValue->toInt();
                }

                return $jsonValue->toFloat();

            case JsonValueType::JsonObject():
                /** @var JsonObject $jsonValue */
                $properties = [];
                foreach ($jsonValue as $name => $value) {
                    $properties[$name] = $this->convertToScalarValues($value);
                }

                return (object) $properties;

            case JsonValueType::JsonArray():
                /** @var JsonArray $jsonValue */
                $elements = [];
                foreach ($jsonValue as $element) {
                    $elements[] = $this->convertToScalarValues($element);
                }

                return $elements;
            default:
                throw new \RuntimeException("Must not be reachable!"); // @codeCoverageIgnore
        }
    }
}