<?php
namespace TheSeer\Lib\Factory\Sample {

    use TheSeer\Lib\Factory\MasterFactory;

    require __DIR__ . '/../../src/autoload.php';
    require __DIR__ . '/src/autoload.php';

    $factory = new MasterFactory();
    $factory->registerFactory(
        new SampleChildFactory()
    );

    $something = $factory->createSomething();
    var_dump($something);
}