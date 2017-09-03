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

use function mb_strlen;

/**
 * An immutable JSON string value.
 */
final class JsonString implements JsonValue
{
    /** @var string */
    private $value;

    public function __construct(string $str)
    {
        $this->value = $str;
    }

    public function toString(): string
    {
        return $this->getValue();
    }

    public function isEmpty(): bool
    {
        return $this->length() === 0;
    }

    /**
     * Returns number of utf-8 characters in the string.
     */
    public function length(): int
    {
        return mb_strlen($this->getValue(), 'utf-8');
    }

    public function equals(self $another): bool
    {
        return $this->getValue() === $another->getValue();
    }

    public function getValueType(): JsonValueType
    {
        return JsonValueType::JsonString();
    }

    public function isNull(): bool
    {
        return false;
    }

    private function getValue(): string
    {
        return $this->value;
    }
}