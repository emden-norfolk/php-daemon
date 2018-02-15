<?php

require_once __DIR__ .'/../vendor/autoload.php';

use Illuminate\Contracts\Console\Kernel;

function main(array $argv, $argc, $wrkn) {
    $app = require_once __DIR__ .'/../bootstrap/app.php';
    $app->make(Kernel::class)->bootstrap();
    restore_error_handler(); // Do not use Laravel's error handler.

	while (running()) {
		// Log to file.
		trigger_error("Hello, world (Worker number: $wrkn)", E_USER_NOTICE);

		// Do work here.
		sleep(1);
	}
}
