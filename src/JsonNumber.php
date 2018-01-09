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
        if (!is_int($value) && !is_float($value)) {
            throw new \InvalidArgumentException(sprintf(
                'Value must be of type "int" or "float", but "%s" was given.',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        $this->value = $value;
    }

    public function isIntegral(): bool
    {
        // It depends on the fact, that json_decode()
        // decodes number like 100 as int, and 100.0 as float.

        return is_int($this->getValue());
    }

    public function toFloat(): float
    {
        return (float) $this->getValue();
    }

    public function toInt(): int
    {
        return (int) $this->getValue();
    }

    /**
     * @return int
     * @throws FormatException If this number is not integral.
     */
    public function toIntExact(): int
    {
        if ($this->isIntegral()) {
            return $this->toInt();
        }

        throw new FormatException(sprintf('Number %f is not integral.', $this->getValue()));
    }

    /**
     * @return int|float
     */
    private function getValue()
    {
        return $this->value;
    }
}