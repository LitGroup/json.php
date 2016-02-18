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

/**
 * Interface CodecInterface
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 *
 * @api
 */
interface CodecInterface extends EncoderInterface, DecoderInterface
{
    /**
     * Returns used encoder.
     *
     * @return EncoderInterface
     */
    public function getEncoder();

    /**
     * Returns used decoder.
     *
     * @return DecoderInterface
     */
    public function getDecoder();
}