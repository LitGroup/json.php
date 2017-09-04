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
use IteratorAggregate;

final class JsonArray implements JsonStructure, IteratorAggregate
{

    /** @var JsonValue[] */
    private $elements;

    public static function createBuilder(): JsonArrayBuilder
    {
        return new JsonArrayBuilder(function (array $elements) { return new JsonArray($elements); });
    }

    public function count(): int
    {
        return count($this->getElements());
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function getIterator()
    {
        foreach ($this->getElements() as $element) {
            yield $element;
        }
    }

    public function getJsonValue(int $index): JsonValue
    {
        return $this->getElements()[$index];
    }

    public function getValueType(): JsonValueType
    {
        return JsonValueType::JsonArray();
    }

    public function isNull(): bool
    {
        return false;
    }

    /**
     * JsonArray constructor.
     * @param JsonValue[] $elements
     */
    private function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * @return JsonValue[]
     */
    private function getElements(): array
    {
        return $this->elements;
    }
}

class JsonArrayBuilder
{
    /** @var callable */
    private $factory;

    /** @var JsonValue[] */
    private $elements = [];

    public function __construct(callable $arrayFactory)
    {
        $this->factory = $arrayFactory;
    }

    public function add(JsonValue $value): self
    {
        $this->elements[] = $value;

        return $this;
    }

    public function build(): JsonArray
    {
        return call_user_func($this->getFactory(), $this->getElements());
    }

    private function getFactory(): callable
    {
        return $this->factory;
    }

    private function getElements(): array
    {
        return $this->elements;
    }
}