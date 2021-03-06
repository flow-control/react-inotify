<?php

/**
 * start this example using: php 01-example.php
 * open another terminal and: touch foobar
 */

declare(strict_types=1);

use Flowcontrol\React\Inotify\InotifyStream;
use React\EventLoop\Factory;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$inotify = inotify_init();
$watch_descriptor = inotify_add_watch($inotify, __DIR__, IN_CLOSE_WRITE);

$watcher = new InotifyStream($inotify, $loop);
$watcher->on('event', static function (array $data): void {
    print_r($data);
});

touch(__DIR__ . '/testfile');
unlink(__DIR__ . '/testfile');

$loop->run();

inotify_rm_watch($inotify, $watch_descriptor);
fclose($inotify);
