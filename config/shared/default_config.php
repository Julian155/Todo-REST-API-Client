<?php

use \App\Shared\Database\DatabaseConstants;

$config[DatabaseConstants::DATABASE_DSN] = $_ENV['DATABASE_DSN'];
$config[DatabaseConstants::DATABASE_USER] = $_ENV['DATABASE_USER'];
$config[DatabaseConstants::DATABASE_PASSWORD] = $_ENV['DATABASE_PASSWORD'];

