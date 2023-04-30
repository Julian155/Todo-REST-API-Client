<?php

use \App\Shared\Database\DatabaseConstants;
use \App\Shared\Kernel\KernelConstants;

$config[DatabaseConstants::DATABASE_DSN] = $_ENV[DatabaseConstants::DATABASE_DSN];
$config[DatabaseConstants::DATABASE_USER] = $_ENV[DatabaseConstants::DATABASE_USER];
$config[DatabaseConstants::DATABASE_PASSWORD] = $_ENV[DatabaseConstants::DATABASE_PASSWORD];

$config[KernelConstants::APPLICATION_ROOT_DIR] = $_ENV[KernelConstants::APPLICATION_ROOT_DIR];
