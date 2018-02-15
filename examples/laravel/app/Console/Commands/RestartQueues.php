<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RestartQueues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monit:restart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restart Monit queues.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $error = false;

        foreach (scandir(storage_path('monit')) as $file) {
            if (!Str::endsWith($file, '.pid')) continue;

            $commands = [];

            list($queue, $id) = explode('.', $file);

            $stop = base_path('vendor/emden-norfolk/php-daemon/phpdaemonstop');
            $start = base_path('vendor/emden-norfolk/php-daemon/phpdaemon');
            $daemon = base_path("daemon/$queue.php");
            $pidfile = storage_path("monit/$file");
            $logfile = storage_path("logs/$queue.log");


            $commands[] = "sudo -u apache $stop $pidfile";
            $commands[] = "sudo -u apache $start $daemon $pidfile $logfile $id";

            foreach ($commands as $command) {
                $output = system($command, $return);
                if ($return === 0) {
                    $this->line($command);
                } else {
                    $error = true;
                    $this->error("Error running: $command");
                }
            }
        }

        if (!$error) {
            $this->info('Successfully restarted all queues.');
            return 0;
        }
        return 1;
    }
}
