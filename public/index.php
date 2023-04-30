<?php

use App\Kernel\Kernel;
use App\Shared\Kernel\KernelConstants;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    if (!isset($context[KernelConstants::APPLICATION_ROOT_DIR])) {
        $_ENV[KernelConstants::APPLICATION_ROOT_DIR] = dirname(__FILE__, 2);
    }

    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
