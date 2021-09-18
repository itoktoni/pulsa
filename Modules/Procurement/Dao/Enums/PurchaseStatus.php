<?php

namespace Modules\Procurement\Dao\Enums;

use Rexlabs\Enum\Enum;

/**
 * The Status enum.
 *
 * @method static self IN_PROGRESS()
 * @method static self COMPLETE()
 * @method static self FAILED()
 */
class PurchaseStatus extends Enum
{
    const IN_PROGRESS = 2;
    const COMPLETE = 3;
    const FAILED = 4;

    /**
     * Retrieve a map of enum keys and values.
     *
     * @return array
     */
    public static function map() : array
    {
        return [
            static::IN_PROGRESS => 'In progress',
            static::COMPLETE => 'Complete',
            static::FAILED => 'Failed',
        ];
    }
}
