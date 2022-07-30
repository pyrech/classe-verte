<?php

use App\Kernel;

$_SERVER['APP_RUNTIME_OPTIONS'] = [
    'dotenv_overload' => true,
];

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
