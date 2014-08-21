<?php
namespace TheSeer\Lib\Factory\Sample {

    use TheSeer\Lib\Factory\CodeGenerator;
    use TheSeer\Lib\Factory\MasterFactory;
    use TheSeer\Lib\Factory\Registry;

    require __DIR__ . '/../../src/autoload.php';
    require __DIR__ . '/src/autoload.php';

    $registry = new Registry();
    $registry->addFactory(
        new SampleChildFactory()
    );

    $traitTemplate = file_get_contents(__DIR__ . '/tpl/Trait.php');
    $methodTemplate = file_get_contents(__DIR__ . '/tpl/Method.php');

    $generator = new CodeGenerator($traitTemplate, $methodTemplate);
    echo $generator->generate($registry);

}
