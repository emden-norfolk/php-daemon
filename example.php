<?php

function main(array $argv, $argc, $wrkn) {
	while (running()) {
		// Log to file.
		trigger_error("Hello, world (Worker number: $wrkn)", E_USER_NOTICE);

		// Note that echo will break the daemon because STDOUT is closed.
		// echo "Bad goy!"; <-- Do NOT do this!

		// Do work here.
		sleep(1);
	}
}
