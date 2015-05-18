<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$file = __DIR__ . '/../vendor/autoload.php';

if (! file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite. "php composer.phar install --dev"');
}

$loader = require $file;

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

// copy dist parameters to yml if does not exists or it's newer.
$params     = __DIR__ . '/Application/app/parameters.yml';
$paramsDist = __DIR__ . '/Application/app/parameters.yml.dist';

// TODO: I had to add this here, otherwise it's not loaded. Could not figure out why, yet.
new \Origammi\Bundle\BlocksBundle\Annotation\BlockCollectionData([]);

if (! file_exists($params) || filemtime($paramsDist) > filemtime($params)) {
    copy($paramsDist, $params);
}

return $loader;
