<?php
namespace TheSeer\Lib\Factory\Sample {

    use TheSeer\Lib\Factory\MasterFactory;

    require __DIR__ . '/../../src/autoload.php';
    require __DIR__ . '/src/autoload.php';

    $featureTestEnabled = (bool)rand(0,1);

    $factory = new MasterFactory();
    $factory->registerFactory(
        new SampleFactory()
    );

    if ($featureTestEnabled) {
        $factory->registerFactory(
            new ABTestFactory()
        );
    }

    $instance = $factory->createHelper();

    var_dump($instance);

}