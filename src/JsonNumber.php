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

use LitGroup\Json\Exception\FormatException;

final class JsonNumber implements JsonValue
{
    /** @var int|float */
    private $value;
    /**
     * JsonNumber constructor.
     * @param int|float $value
     */
    public function __construct($value)
    {
        if (!is_int($value) && !is_double($value)) {
            throw new \InvalidArgumentException(sprintf(
                'Value must be of type "int" or "float" but value of type "%s" was given.',
                    is_object($value) ? get_class($value) : gettype($value)));
        }

        $this->value = $value;
    }

    public function isIntegral(): bool
    {
        // It depends on the fact, that PHP's json_decode()
        // decodes number like 100 as int, and 100.0 as float.

        return is_int($this->getValue());
    }

    /**
     * Returns this JSON number as an int.
     *
     * Note that this conversion can lose information about the overall
     * magnitude and precision of the number value as well as return
     * a result with the opposite sign.
     */
    public function toInt(): int
    {
        return (int) $this->getValue();
    }

    /**
     * @throws FormatException if the number has a fractional part.
     */
    public function toIntExact(): int
    {
        if (!$this->isIntegral()) {
            throw new FormatException("{$this->getValue()} is not an integral value.");
        }

        return $this->toInt();
    }

    /**
     * Returns this JSON number as a float.
     */
    public function toFloat(): float
    {
        return (float) $this->getValue();
    }

    /**
     * Returns true if both numbers are equal with given precision.
     *
     * Precision ignored when both numbers are integral.
     */
    public function equals(self $another, float $precision = 0.0): bool
    {
        if ($precision < 0) {
            throw new \InvalidArgumentException('Precision cannot be negative.');
        }

        if (is_int($this->getValue()) && is_int($another->getValue())) {
            return $this->getValue() === $another->getValue();
        } else {
            return abs($this->toFloat() - $another->toFloat()) <= $precision;
        }
    }

    public function getValueType(): JsonValueType
    {
        return JsonValueType::JsonNumber();
    }

    public function isNull(): bool
    {
        return false;
    }

    /**
     * @return int|float
     */
    private function getValue()
    {
        return $this->value;
    }
}