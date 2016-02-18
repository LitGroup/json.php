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
 * Configuration for JSON Decoder.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class DecoderConfiguration extends AbstractConfiguration
{
    /**
     * @var bool
     */
    private $useAssoc = true;


    /**
     * If UseAssoc is enabled — JSON-object will be presented as a PHP associative array (Default: false).
     *
     * @param bool $useAssoc
     *
     * @return $this
     */
    public function setUseAssoc($useAssoc)
    {
        $this->useAssoc = (bool) $useAssoc;

        return $this;
    }

    /**
     * If UseAssoc is enabled — JSON-object will be presented as a PHP associative array.
     *
     * @return bool
     */
    public function getUseAssoc()
    {
        return $this->useAssoc;
    }

    /**
     * Decode large integers as their original string value (Default: false).
     *
     * @param bool $bigIntAsString
     *
     * @return $this
     */
    public function setBigIntAsString($bigIntAsString)
    {
        return $this->switchOption(JSON_BIGINT_AS_STRING, $bigIntAsString);
    }
}