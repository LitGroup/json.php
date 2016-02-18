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

/***
 * Class AbstractConfiguration
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
abstract class AbstractConfiguration
{
    /**
     * @var int
     */
    private $maxDepth = 512;

    /**
     * @var int
     */
    private $optionsBitmask = 0;


    /**
     * Sets the maximum depth. Must be greater than zero.
     *
     * @param int $maxDepth
     *
     * @return $this
     */
    public function setMaxDepth($maxDepth)
    {
        $maxDepth = intval($maxDepth);
        if ($maxDepth <= 0) {
            throw new \InvalidArgumentException(
                sprintf('$depth must be greater than zero, but "%d" given.', $maxDepth)
            );
        }

        $this->maxDepth = $maxDepth;

        return $this;
    }

    /**
     * Returns the maximum depth.
     *
     * @return int
     */
    public function getMaxDepth()
    {
        return $this->maxDepth;
    }

    /**
     * Returns JSON-options as bitmask.
     *
     * @internal
     *
     * @return integer
     */
    public function getOptionsBitmask()
    {
        return $this->optionsBitmask;
    }

    /**
     * Switches option's state (enable|disable).
     *
     * @param int  $option
     * @param bool $enable
     *
     * @return $this
     */
    protected function switchOption($option, $enable)
    {
        $option = (int) $option;
        if ($enable) {
            $this->optionsBitmask |= $option;
        } else {
            $this->optionsBitmask &= ~$option;
        }

        return $this;
    }
}