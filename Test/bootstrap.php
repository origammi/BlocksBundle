<?php

$file = __DIR__ . '/../vendor/autoload.php';

if (! file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite. "php composer.phar install --dev"');
}

require_once $file;

// copy dist parameters to yml if does not exists.
$params     = __DIR__ . '/Application/app/parameters.yml';
$paramsDist = __DIR__ . '/Application/app/parameters.yml.dist';

if (! file_exists($params)) {
    copy($paramsDist, $params);
}
