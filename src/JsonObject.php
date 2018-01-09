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


final class JsonObject implements JsonStructure
{
    /** @var array */
    private $properties;

    public static function emptyObject(): self
    {
        return new self([]);
    }

    public static function builder(): JsonObjectBuilder
    {
        return new JsonObjectBuilder();
    }

    /**
     * Internal constructor, use `build()`.
     *
     * @internal
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        $this->properties = $properties;
    }

    public function count(): int
    {
        return count($this->properties);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * @return string[]
     */
    public function getKeys(): array
    {
        return array_keys($this->properties);
    }

    public function hasProperty(string $key): bool
    {
        return array_key_exists($key, $this->properties);
    }

    public function containsNull(string $key): bool
    {
        return $this->getOptionalJsonValue($key) === null;
    }

    public function containsString(string $key): bool
    {
        return $this->getOptionalJsonValue($key) instanceof JsonString;
    }

    public function containsNumber(string $key): bool
    {
        return $this->getOptionalJsonValue($key) instanceof JsonNumber;
    }

    public function containsInt(string $key): bool
    {
        $value = $this->getOptionalJsonValue($key);

        return $value instanceof JsonNumber && $value->isIntegral();
    }

    public function containsFloat(string $key): bool
    {
        return $this->containsNumber($key);
    }

    public function containsBool(string $key): bool
    {
        return $this->getOptionalJsonValue($key) instanceof JsonBoolean;
    }

    public function containsObject(string $key): bool
    {
        return $this->getOptionalJsonValue($key) instanceof JsonObject;
    }

    public function containsArray(string $key): bool
    {
        return $this->getOptionalJsonValue($key) instanceof JsonArray;
    }

    /**
     * @param string $key
     * @return JsonValue
     * @throws FormatException If property does not exist or it's null.
     */
    public function getJsonValue(string $key): JsonValue
    {
        $value = $this->getOptionalJsonValue($key);

        if ($value === null) {
            throw new FormatException("Property '$key' does not exist or it is null.");
        }

        return $value;
    }

    /**
     * @throws FormatException
     */
    public function getJsonObject(string $key): JsonObject
    {
        $value = $this->getJsonValue($key);
        if ($value instanceof JsonObject) {
            return $value;
        }

        throw new FormatException();
    }

    /**
     * @throws FormatException
     */
    public function getJsonArray(string $key): JsonArray
    {
        $value = $this->getJsonValue($key);
        if ($value instanceof JsonArray) {
            return $value;
        }

        throw new FormatException();
    }

    public function getOptionalJsonValue(string $key): ?JsonValue
    {
        if ($this->hasProperty($key)) {
            return $this->properties[$key];
        }

        return null;
    }

    /**
     * @throws FormatException
     */
    public function getString(string $key): string
    {
        $value = $this->getOptionalString($key);
        if ($value === null) {
            throw new FormatException();
        }

        return $value;
    }

    /**
     * @throws FormatException
     */
    public function getOptionalString(string $key): ?string
    {
        $value = $this->getOptionalJsonValue($key);
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
    public function getBool(string $key): bool
    {
        $value = $this->getOptionalBool($key);
        if ($value === null) {
            throw new FormatException();
        }

        return $value;
    }

    /**
     * @throws FormatException
     */
    public function getOptionalBool(string $key): ?bool
    {
        $value = $this->getOptionalJsonValue($key);
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
    public function getFloat(string $key): float
    {
        $value = $this->getOptionalFloat($key);
        if ($value === null) {
            throw new FormatException();
        }

        return $value;
    }

    /**
     * @throws FormatException
     */
    public function getOptionalFloat(string $key): ?float
    {
        $value = $this->getOptionalJsonValue($key);
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
    public function getInt(string $key): int
    {
        $value = $this->getOptionalInt($key);
        if ($value === null) {
            throw new FormatException();
        }

        return $value;
    }

    /**
     * @throws FormatException
     */
    public function getOptionalInt(string $key): ?int
    {
        $value = $this->getOptionalJsonValue($key);
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
    public function getIntExact(string $key): int
    {
        $value = $this->getOptionalIntExact($key);
        if ($value === null) {
            throw new FormatException();
        }

        return $value;
    }

    /**
     * @throws FormatException
     */
    public function getOptionalIntExact(string $key): ?int
    {
        $value = $this->getOptionalJsonValue($key);
        if ($value instanceof JsonNumber) {
            return $value->toIntExact();
        } elseif ($value === null) {
            return null;
        }

        throw new FormatException();
    }
}

final class JsonObjectBuilder implements JsonStructureBuilder
{
    /** @var array */
    private $properties = [];

    /**
     * @internal
     * @see \LitGroup\Json\JsonObject::builder()
     */
    public function __construct() {}

    public function setValue(string $key, ?JsonValue $value): self
    {
        $this->properties[$key] = $value;

        return $this;
    }

    public function setBuilder(string $key, JsonStructureBuilder $builder): self
    {
        return $this->setValue($key, $builder->build());
    }

    public function setString(string $key, ?string $value): self
    {
        return $this->setValue($key, $value === null ? $value : new JsonString($value));
    }

    public function setInt(string $key, ?int $value): self
    {
        return $this->setValue($key, $value === null ? $value : new JsonNumber($value));
    }

    public function setFloat(string $key, ?float $value): self
    {
        return $this->setValue($key, $value === null ? $value : new JsonNumber($value));
    }

    public function setBool(string $key, ?bool $value): self
    {
        return $this->setValue($key, $value === null ? $value : new JsonBoolean($value));
    }

    /**
     * @return JsonObject
     */
    public function build(): JsonStructure
    {
        return new JsonObject($this->properties);
    }
}