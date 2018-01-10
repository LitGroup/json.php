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


class Encoder
{
    public function encode(JsonStructure $structure): string
    {
        return json_encode(
            $this->convertValue($structure),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    private function convertValue(?JsonValue $value)
    {
       if ($value === null) {
           return null;
       } elseif ($value instanceof JsonNumber) {
           return $value->isIntegral() ? $value->toInt() : $value->toFloat();
       } elseif ($value instanceof JsonString) {
           return $value->toString();
       } elseif ($value instanceof JsonBoolean) {
           return $value->toBool();
       } elseif ($value instanceof JsonArray) {
           $result = [];
           for ($i = 0, $count = $value->count(); $i < $count; $i++) {
               $result[] = $this->convertValue($value->getOptionalJsonValue($i));
           }

           return $result;
       } elseif ($value instanceof JsonObject) {
           $result = [];
           foreach ($value->getKeys() as $key) {
               $result[$key] = $this->convertValue($value->getOptionalJsonValue($key));
           }

           return (object) $result;
       }
        // @codeCoverageIgnoreStart
        throw new \RuntimeException('Must be unreachable');
        // @codeCoverageIgnoreEnd
    }
}