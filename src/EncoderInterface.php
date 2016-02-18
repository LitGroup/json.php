<?php
/**
 * This file is part of the "litgroup/json" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace LitGroup\Json;

use LitGroup\Json\Exception\JsonException;

/**
 * Interface EncoderInterface
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 *
 * @api
 */
interface EncoderInterface
{
    /**
     * Encodes value into the JSON.
     *
     * @param mixed $value Value to encode.
     *
     * @return string
     *
     * @throws JsonException
     */
    public function encode($value);
}