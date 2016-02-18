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

use function json_decode;
use function json_last_error;
use function json_last_error_msg;
use const JSON_ERROR_NONE;
use LitGroup\Json\Exception\JsonException;

/**
 * Class Decoder
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class Decoder implements DecoderInterface
{
    /**
     * @var DecoderConfiguration
     */
    private $config;


    /**
     * Decoder constructor.
     *
     * @param DecoderConfiguration $config
     */
    public function __construct(DecoderConfiguration $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function decode($json)
    {
        $result = json_decode(
            $json,
            $this->config->getUseAssoc(),
            $this->config->getMaxDepth(),
            $this->config->getOptionsBitmask()
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