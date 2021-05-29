#!/usr/bin/env php
<?php

$php = 'php7.4';
$composer = './composer.phar';

shell_exec('cd ~/app');
shell_exec("$php $composer install --no-ansi --no-progress --no-interaction");
shell_exec("$php $composer dump-autoload");
shell_exec("$php artisan storage:link");
shell_exec("$php artisan nova:publish");
shell_exec("$php artisan view:clear");
shell_exec("$php artisan migrate --force");

