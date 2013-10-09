<?php
namespace TheSeer\Lib\Factory\Sample {

    use TheSeer\Lib\Factory\AbstractChildFactory;

    class DependencySampleChildFactory extends AbstractChildFactory {

        public function createDependency() {
            return new Dependency();
        }

    }

}
