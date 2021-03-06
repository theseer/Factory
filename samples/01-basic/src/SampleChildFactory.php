<?php
namespace TheSeer\Lib\Factory\Sample {

    use TheSeer\Lib\Factory\AbstractChildFactory;

    class SampleChildFactory extends AbstractChildFactory {

        /**
         * @return Something
         */
        public function createSomething() {
            return new Something();
        }

    }

}
