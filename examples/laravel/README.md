# Laravel 5.5 and Monit Example Using Emden-Norfolk PHP Daemoniser

Monit config:

```
check process example0 with pidfile /var/www/storage/monit/example.0.pid
    start program = "/var/www/vendor/emden-norfolk/php-daemon/phpdaemon /var/www/daemon/example.php /var/www/storage/monit/example.0.pid /var/www/storage/logs/monit-example.log 0"
        as uid apache and gid apache
    stop program = "/var/www/vendor/emden-norfolk/php-daemon/phpdaemonstop /var/www/storage/monit/example.0.pid"
```

Your Laravel directory structure should be:

```
app/
    Console/
        Commands/
            RestartQueues.php
bootstrap/
daemon/
    example.php
resources/
storage/
    logs/
        monit-example.log
    monit/
        example.0.pid
        example.1.pid
        example.2.pid
        ...
        example.n.pid
vendor/
    emden-norfolk/
        php-daemon/
```

To restart queues: `/var/www/artisan monit:restart`
