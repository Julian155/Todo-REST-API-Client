<?php
declare(strict_types=1);

namespace App\Kernel\Persistence;

use App\Database\ConnectionTrait;

abstract class AbstractQueryContainer
{
    use ConnectionTrait;
}
