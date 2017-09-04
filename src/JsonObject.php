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

use function call_user_func;
use function array_key_exists;
use IteratorAggregate;

final class JsonObject implements JsonStructure, IteratorAggregate
{
    /** @var array */
    private $properties;

    public static function createBuilder(): JsonObjectBuilder
    {
        return new JsonObjectBuilder(function (array $properties) { return new JsonObject($properties); });
    }

    public function getValueType(): JsonValueType
    {
        return JsonValueType::JsonObject();
    }

    public function isNull(): bool
    {
        return false;
    }

    public function count(): int
    {
        return count($this->getProperties());
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function getIterator()
    {
        foreach ($this->getProperties() as $name => $property) {
            yield $name => $property;
        }
    }

    public function getJsonValue(string $name): JsonValue
    {
        if (array_key_exists($name, $this->getProperties())) {
            return $this->getProperties()[$name];
        }

        return JsonNull::value();
    }

    private function __construct(array $properties)
    {
        $this->properties = $properties;
    }

    private function getProperties(): array
    {
        return $this->properties;
    }
}

final class JsonObjectBuilder
{
    /** @var callable */
    private $factory;

    /** @var array */
    private $properties = [];

    /** @internal  */
    public function __construct(callable $factory)
    {
        $this->factory = $factory;
    }

    public function add(string $name, JsonValue $value): self
    {
        $this->properties[$name] = $value;

        return $this;
    }

    public function build(): JsonObject
    {
        return call_user_func($this->getFactory(), $this->getProperties());
    }

    private function getProperties(): array
    {
        return $this->properties;
    }

    private function getFactory(): callable
    {
        return $this->factory;
    }
}