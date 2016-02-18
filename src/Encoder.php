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

use const JSON_ERROR_NONE;
use function json_encode;
use LitGroup\Json\Exception\JsonException;

/**
 * Class Encoder
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class Encoder implements EncoderInterface
{
    /**
     * @var EncoderConfiguration
     */
    private $config;


    /**
     * Encoder constructor.
     *
     * @param EncoderConfiguration $config
     */
    public function __construct(EncoderConfiguration $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function encode($value)
    {
        $result = json_encode(
            $value,
            $this->config->getOptionsBitmask(),
            $this->config->getMaxDepth()
        );

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new JsonException(
                json_last_error_msg(),
                json_last_error()
            );
        }

        return $result;
    }
}