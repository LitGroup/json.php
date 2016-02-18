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
 * Configuration for JSON Encoder.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class EncoderConfiguration extends AbstractConfiguration
{
    public function __construct()
    {
        $this
            ->setUnescapedSlashes(true)
            ->setUnescapedUnicode(true)
            // TODO (Sharom): Uncomment it when support of PHP 5.5 will finish.
            // ->setPreserveZeroFraction(true)
        ;
    }

    /**
     * All < and > are converted to \u003C and \u003E (Default: false).
     *
     * @param bool $hexTag
     *
     * @return $this
     */
    public function setHexTag($hexTag)
    {
        return $this->switchOption(JSON_HEX_TAG, $hexTag);
    }

    /**
     * All &s are converted to \u0026 (Default: false).
     *
     * @param bool $hexAmp
     *
     * @return $this
     */
    public function setHexAmp($hexAmp)
    {
        return $this->switchOption(JSON_HEX_AMP, $hexAmp);
    }

    /**
     * All ' are converted to \u0027 (Default: false).
     *
     * @param bool $hexApos
     *
     * @return $this
     */
    public function setHexApos($hexApos)
    {
        return $this->switchOption(JSON_HEX_APOS, $hexApos);
    }

    /**
     * All " are converted to \u0022 (Default: false).
     *
     * @param bool $hexQuot
     *
     * @return $this
     */
    public function setHexQuot($hexQuot)
    {
        return $this->switchOption(JSON_HEX_QUOT, $hexQuot);
    }

    /**
     * Outputs an object rather than an array when a non-associative array is used (Default: false).
     *
     * Especially useful when the recipient of the output is expecting an object and the array is empty.
     *
     * @param bool $forceObject
     *
     * @return $this
     */
    public function setForceObject($forceObject)
    {
        return $this->switchOption(JSON_FORCE_OBJECT, $forceObject);
    }

    /**
     * Encodes numeric strings as numbers (Default: false).
     *
     * @param bool $numericCheck
     *
     * @return $this
     */
    public function setNumericCheck($numericCheck)
    {
        return $this->switchOption(JSON_NUMERIC_CHECK, $numericCheck);
    }

    /**
     * Use whitespace in returned data to format it (Default: false).
     *
     * @param bool $prettyPrint
     *
     * @return $this
     */
    public function setPrettyPrint($prettyPrint)
    {
        return $this->switchOption(JSON_PRETTY_PRINT, $prettyPrint);
    }

    /**
     * Don't escape / (Default: true).
     *
     * @param bool $unescapedSlashes
     *
     * @return $this
     */
    public function setUnescapedSlashes($unescapedSlashes)
    {
        return $this->switchOption(JSON_UNESCAPED_SLASHES, $unescapedSlashes);
    }

    /**
     * Encode multibyte Unicode characters literally (Default: true).
     *
     * @param bool $unescapedUnicode
     *
     * @return $this
     */
    public function setUnescapedUnicode($unescapedUnicode)
    {
        return $this->switchOption(JSON_UNESCAPED_UNICODE, $unescapedUnicode);
    }

    /**
     * Substitute some unencodable values instead of failing (Default: false).
     *
     * @param bool $partialOutputOnError
     *
     * @return $this
     */
    public function setPartialOutputOnError($partialOutputOnError)
    {
        return $this->switchOption(JSON_PARTIAL_OUTPUT_ON_ERROR, $partialOutputOnError);
    }

//    TODO (Sharom): Uncomment it when support of PHP 5.5 will finish.
//    /**
//     * Ensures that float values are always encoded as a float value (Default: true).
//     *
//     * @param bool $preserveZeroFraction
//     *
//     * @return $this
//     */
//    public function setPreserveZeroFraction($preserveZeroFraction)
//    {
//        return $this->switchOption(JSON_PRESERVE_ZERO_FRACTION, $preserveZeroFraction);
//    }
}