<?php

use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

$file = __DIR__ . '/../vendor/autoload.php';

if (! file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite. "php composer.phar install --dev"');
}

$loader = require $file;
require_once __DIR__ . '/Application/app/TestAppKernel.php';


AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

// copy dist parameters to yml if does not exists or it's newer.
$params     = __DIR__ . '/Application/app/parameters.yml';
$paramsDist = __DIR__ . '/Application/app/parameters.yml.dist';

// TODO: I had to add this here, otherwise it's not loaded. Could not figure out why, yet.
new \Origammi\Bundle\BlocksBundle\Annotation\BlockCollectionData([]);

if (! file_exists($params) || filemtime($paramsDist) > filemtime($params)) {
    copy($paramsDist, $params);
}

if (isset($_SERVER['CREATE_DB']) && $_SERVER['CREATE_DB']) {
    $kernel = new TestAppKernel('test', true);
    $kernel->boot();

    $application = new Application($kernel);
    $output      = new ConsoleOutput();

    $command = new DropDatabaseDoctrineCommand();
    $application->add($command);
    $input = new ArrayInput(array(
        'command' => 'doctrine:database:drop',
        '--force' => true,
    ));
    $command->run($input, $output);

    $command = new CreateDatabaseDoctrineCommand();
    $application->add($command);
    $input = new ArrayInput([
        'command' => 'doctrine:database:create',
    ]);
    $command->run($input, $output);

    $command = new CreateSchemaDoctrineCommand();
    $application->add($command);
    $input = new ArrayInput([
        'command' => 'doctrine:schema:create',
    ]);
    $command->run($input, $output);
}

return $loader;
