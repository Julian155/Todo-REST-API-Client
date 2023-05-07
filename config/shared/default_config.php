<?php

use \App\Shared\Database\DatabaseConstants;
use \App\Shared\Kernel\KernelConstants;
use \App\Shared\Payment\PaymentConstants;

$config[DatabaseConstants::DATABASE_DSN] = $_ENV[DatabaseConstants::DATABASE_DSN];
$config[DatabaseConstants::DATABASE_USER] = $_ENV[DatabaseConstants::DATABASE_USER];
$config[DatabaseConstants::DATABASE_PASSWORD] = $_ENV[DatabaseConstants::DATABASE_PASSWORD];

$config[KernelConstants::APPLICATION_ROOT_DIR] = $_ENV[KernelConstants::APPLICATION_ROOT_DIR];

$config[PaymentConstants::PAYMENT_RATE] = 'h';
$config[PaymentConstants::PAYMENT_RATE_AMOUNT] = 1;
