<?php
declare(strict_types=1);

namespace App\Shared\Transfer;

interface TransferTypeEnum
{
    public const TRANSFER_PROPERTY_TYPES = [
        'int',
        'string',
        'bool',
        'array'
    ];
}
