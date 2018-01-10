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


final class JsonArray implements JsonStructure
{
    /** @var JsonValue[] */
    private $elements;

    public static function emptyArray(): self
    {
        return new self([]);
    }

    public static function builder(): JsonArrayBuilder
    {
        return new JsonArrayBuilder();
    }

    /**
     * Internal constructor, use `builder()`.
     *
     * @internal
     * @param array $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = array_values($elements);
    }

    public function count(): int
    {
        return count($this->elements);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * @throws FormatException
     */
    public function getJsonValue(int $index): JsonValue
    {
        $element = $this->getOptionalJsonValue($index);
        if ($element === null) {
            throw new FormatException();
        }

        return $element;
    }

    public function getOptionalJsonValue(int $index): ?JsonValue
    {
        if ($index < 0 || $index >= $this->count()) {
            throw new \OutOfBoundsException();
        }

        return $this->elements[$index];
    }

    /**
     * @throws FormatException
     */
    public function getJsonObject(int $index): JsonObject
    {
        $value = $this->getOptionalJsonObject($index);
        if ($value === null) {
            throw new FormatException();
        }

        return $value;
    }

    /**
     * @throws FormatException
     */
    public function getOptionalJsonObject(int $index): ?JsonObject
    {
        $value = $this->getOptionalJsonValue($index);
        if ($value instanceof JsonObject) {
            return $value;
        } elseif ($value === null) {
            return null;
        }

        throw new FormatException();
    }

    /**
     * @throws FormatException
     */
    public function getJsonArray(int $index): JsonArray
    {
        $value = $this->getOptionalJsonArray($index);
        if ($value === null) {
            throw new FormatException();
        }

        return $value;
    }

    /**
     * @throws FormatException
     */
    public function getOptionalJsonArray(int $index): ?JsonArray
    {
        $value = $this->getOptionalJsonValue($index);
        if ($value instanceof JsonArray) {
            return $value;
        } elseif ($value === null) {
            return  null;
        }

        throw new FormatException();
    }

    /**
     * @throws FormatException
     */
    public function getString(int $index): string
    {
        $value = $this->getOptionalString($index);
        if ($value === null) {
            throw new FormatException();
        }

        return $value;
    }

    /**
     * @throws FormatException
     */
    public function getOptionalString(int $index): ?string
    {
        $value = $this->getOptionalJsonValue($index);
        if ($value instanceof JsonString) {
            return $value->toString();
        } elseif ($value === null) {
            return null;
        }

        throw new FormatException();
    }

    /**
     * @throws FormatException
     */
    public function getBool(int $index): bool
    {
        $value = $this->getOptionalBool($index);
        if ($value === null) {
            throw new FormatException();
        }

        return $value;
    }

    /**
     * @throws FormatException
     */
    public function getOptionalBool(int $index): ?bool
    {
        $value = $this->getOptionalJsonValue($index);
        if ($value instanceof JsonBoolean) {
            return $value->toBool();
        } elseif ($value === null) {
            return null;
        }

        throw new FormatException();
    }

    /**
     * @throws FormatException
     */
    public function getFloat(int $index): ?float
    {
        $value = $this->getOptionalFloat($index);
        if ($value === null) {
            throw new FormatException();
        }

        return $value;
    }

    /**
     * @throws FormatException
     */
    public function getOptionalFloat(int $index): ?float
    {
        $value = $this->getOptionalJsonValue($index);
        if ($value instanceof JsonNumber) {
            return $value->toFloat();
        } elseif ($value === null) {
            return null;
        }

        throw new FormatException();
    }

    /**
     * @throws FormatException
     */
    public function getInt(int $index): int
    {
        $value = $this->getOptionalInt($index);
        if ($value === null) {
            throw new FormatException();
        }

        return $value;
    }

    /**
     * @throws FormatException
     */
    public function getOptionalInt(int $index): ?int
    {
        $value = $this->getOptionalJsonValue($index);
        if ($value instanceof JsonNumber) {
            return $value->toInt();
        } elseif ($value === null) {
            return null;
        }

        throw new FormatException();
    }

    /**
     * @throws FormatException
     */
    public function getIntExact(int $index): int
    {
        $value = $this->getOptionalIntExact($index);
        if ($value === null) {
            throw new FormatException();
        }

        return $value;
    }

    /**
     * @throws FormatException
     */
    public function getOptionalIntExact(int $index): ?int
    {
        $value = $this->getOptionalJsonValue($index);
        if ($value instanceof JsonNumber) {
            return $value->toIntExact();
        } elseif ($value === null) {
            return null;
        }

        throw new FormatException();
    }
}

final class JsonArrayBuilder implements JsonStructureBuilder
{
    /** @var JsonValue[] */
    private $elements = [];

    /**
     * @internal
     * @see \LitGroup\Json\JsonArray::builder()
     */
    public function __construct() {}

    public function addValue(?JsonValue $value): self
    {
        $this->elements[] = $value;

        return $this;
    }

    public function addString(?string $value): self
    {
        return $this->addValue($value === null ? null : new JsonString($value));
    }

    public function addInt(?int $value): self
    {
        return $this->addValue($value === null ? null : new JsonNumber($value));
    }

    public function addFloat(?float $value): self
    {
        return $this->addValue($value === null ? null : new JsonNumber($value));
    }

    public function addBool(?bool $value): self
    {
        return $this->addValue($value === null ? null : new JsonBoolean($value));
    }

    public function addBuilder(?JsonStructureBuilder $builder): self
    {
        return $this->addValue($builder === null ? null : $builder->build());
    }

    /**
     * @return JsonArray
     */
    public function build(): JsonStructure
    {
        return new JsonArray($this->elements);
    }
}