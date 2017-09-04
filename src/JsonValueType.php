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

use function array_key_exists;

final class JsonValueType
{
    /** @var array */
    private static $values = [];

    /** @var string */
    private $value;

    public static function JsonNull(): self
    {
        return self::create('null');
    }

    public static function JsonBoolean(): self
    {
        return self::create('boolean');
    }

    public static function JsonNumber(): self
    {
        return self::create('number');
    }

    public static function JsonString(): self
    {
        return self::create('string');
    }

    public static function JsonArray(): self
    {
        return self::create('array');
    }

    public static function JsonObject(): self
    {
        return self::create('object');
    }

    public function isNull(): bool
    {
        return $this === self::JsonNull();
    }

    public function isBoolean(): bool
    {
        return $this === self::JsonBoolean();
    }

    public function isNumber(): bool
    {
        return $this === self::JsonNumber();
    }

    public function isString(): bool
    {
        return $this === self::JsonString();
    }

    public function isArray(): bool
    {
        return $this === self::JsonArray();
    }

    public function isObject(): bool
    {
        return $this === self::JsonObject();
    }

    public function equals(self $type): bool
    {
        return $this === $type;
    }

    private static function create(string $value): self
    {
        if (!array_key_exists($value, self::$values)) {
            self::$values[$value] = new self($value);
        }

        return self::$values[$value];
    }

    private function __construct(string $value)
    {
        assert(strlen($value) > 0);
        assert(!array_key_exists($value, self::$values));

        $this->value = $value;
    }

    private function __clone() {}
    private function __sleep() {}
    private function __wakeup() {}
}