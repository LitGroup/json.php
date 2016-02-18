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
 * Class Codec
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class Codec implements CodecInterface
{
    /**
     * @var EncoderInterface
     */
    private $encoder;

    /**
     * @var DecoderInterface
     */
    private $decoder;


    /**
     * Codec constructor.
     *
     * @param EncoderInterface $encoder
     * @param DecoderInterface $decoder
     */
    public function __construct(EncoderInterface $encoder, DecoderInterface $decoder)
    {
        $this->encoder = $encoder;
        $this->decoder = $decoder;
    }

    /**
     * {@inheritDoc}
     */
    public function encode($value)
    {
        return $this->encoder->encode($value);
    }

    /**
     * {@inheritDoc}
     */
    public function decode($json)
    {
        return $this->decoder->decode($json);
    }
}