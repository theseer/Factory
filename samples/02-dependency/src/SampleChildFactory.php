<?php
namespace TheSeer\Lib\Factory\Sample {

    use TheSeer\Lib\Factory\AbstractChildFactory;

    class SampleChildFactory extends AbstractChildFactory {

        public function createSomething() {
            return new Something(
                $this->getMasterFactory()->createDependency()
            );
        }

    }

}
