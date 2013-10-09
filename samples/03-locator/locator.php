<?php
namespace TheSeer\Lib\Factory\Sample {

    use TheSeer\Lib\Factory\MasterFactory;

    require __DIR__ . '/../../src/autoload.php';
    require __DIR__ . '/src/autoload.php';

    $factory = new MasterFactory();
    $factory->registerFactory(new LoggerFactory());
    $factory->registerFactory(new LocatorFactory());

    $locator = $factory->createLoggerLocator();
    $logger = $locator->getLogger('null');
    var_dump($logger);
}