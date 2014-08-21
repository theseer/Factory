<?php
namespace TheSeer\Lib\Factory\Sample {

    use TheSeer\Lib\Factory\MasterFactory;
    use TheSeer\Lib\Factory\Registry;

    require __DIR__ . '/../../src/autoload.php';
    require __DIR__ . '/src/autoload.php';

    $registry = new Registry();
    $factory = new MasterFactory($registry);

    $factory->registerFactory(new SampleChildFactory());
    $factory->registerFactory(new DependencySampleChildFactory());

    $something = $factory->createSomething();
    var_dump($something);

}
