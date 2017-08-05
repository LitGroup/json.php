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

final class JsonBoolean implements JsonValue
{
    /** @var boolean */
    private $value;

    public static function trueValue(): self
    {
        return new self(true);
    }

    public static function falseValue(): self
    {
        return new self(false);
    }

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function getBool(): bool
    {
        return $this->value;
    }

    public function isTrue(): bool
    {
        return $this->getBool();
    }

    public function isFalse(): bool
    {
        return !$this->getBool();
    }

    public function equals(self $another): bool
    {
        return $this->getBool() === $another->getBool();
    }

    public function getValueType(): JsonValueType
    {
        return JsonValueType::JsonBoolean();
    }

    public function isNull(): bool
    {
        return false;
    }
}