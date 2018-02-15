# PHP Daemoniser

Daemonises PHP scripts with graceful shutdown and multiple workers.

## Usage

### How to write your scripts.

The following rules must be adheared to when writing a PHP script to be called by phpdaemon:

 - Your script must implement a function `main()`.
 - Your script must check `running()` for a true/false condition for each
   item of work. If false, the script should exit. If you do not check for this
   condition, the script will be unable to exit cleanly and signal interrupts
   will be ignored.
 - Standard output is closed. Any use of `print`, `echo`, `var_dump`, etc will
   result in the script terminating abruptly.
 - Errors will be logged to a log file. Use `trigger_error()` to manually write
   to the log.

See `examples/basic.php` for an implementation reference.

### Standalone

```
./phpdaemon <php file> <process id file> <log file> <worker number>
```

Example:

```
./phpdaemon examples/basic.php example.0.pid example.log 0
```

### Monit

Example of how to configure Monit with two workers. Assumes user is
`apache` and directory is `/opt`.

```
check process example0 with pidfile /opt/daemon/example.0.pid
    start program = "/opt/daemon/phpdaemon /opt/daemon/examples/basic.php /opt/daemon/example.0.pid /opt/daemon/example.log 0"
        as uid apache and gid apache
    stop program = "/opt/daemon/phpdaemonstop /opt/daemon/example.0.pid"

check process example1 with pidfile /opt/daemon/example.1.pid
    start program = "/opt/daemon/phpdaemon /opt/daemon/examples/basic.php /opt/daemon/example.1.pid /opt/daemon/example.log 1"
        as uid apache and gid apache
    stop program = "/opt/daemon/phpdaemonstop /opt/daemon/example.1.pid"
```

### Monit and Laravel

See `examples/laravel/`

## Resources

 * Advanced Programming in the UNIX Environment (Third Edition), Chapter 13: Daemon Processes, W. R. Stevens, et. al 2013.
 * [Daemonising a PHP cli script on a posix system](https://andytson.com/blog/2010/05/daemonising-a-php-cli-script-on-a-posix-system/), Andy Thompson 2010.
