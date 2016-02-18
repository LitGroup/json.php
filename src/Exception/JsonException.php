<?php
/**
 * This file is part of the "litgroup/json" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace LitGroup\Json\Exception;

use Exception;

/**
 * Class JsonException
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class JsonException extends Exception
{
    /**
     * JsonException constructor.
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}