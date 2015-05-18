<?php
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../app/TestAppKernel.php';

$sfEnv   = 'test';
$sfDebug = true;
$kernel  = new TestAppKernel($sfEnv, $sfDebug);
$kernel->loadClassCache();

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
