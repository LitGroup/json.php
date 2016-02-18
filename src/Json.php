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
 * Singleton JSON codec with default configuration.
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class Json implements CodecInterface
{
    /**
     * @var Json
     */
    private static $instance;

    /**
     * @var Codec
     */
    private $codec;


    /**
     * Returns the instance of Json.
     *
     * @return self
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * {@inheritDoc}
     */
    public function getEncoder()
    {
        return $this->codec->getEncoder();
    }

    /**
     * {@inheritDoc}
     */
    public function getDecoder()
    {
        return $this->codec->getDecoder();
    }

    /**
     * {@inheritDoc}
     */
    public function encode($value)
    {
        return $this->codec->encode($value);
    }

    /**
     * {@inheritDoc}
     */
    public function decode($json)
    {
        return $this->codec->decode($json);
    }

    private function __construct()
    {
        $this->codec = new Codec(
            new Encoder(
                (new EncoderConfiguration())
                    ->setUnescapedUnicode(true)
                    ->setUnescapedSlashes(true)
            ),
            new Decoder(
                (new DecoderConfiguration())
                    ->setUseAssoc(true)
                    ->setBigIntAsString(true)
            )
        );
    }

    private function __sleep() {}

    private function __wakeup() {}

    private function __clone() {}
}