<?php
namespace TheSeer\Lib\Factory\Sample {

    use TheSeer\Lib\Factory\AbstractChildFactory;

    class SampleFactory extends AbstractChildFactory {

        public function createHelper() {
            return new DefaultHelper();
        }
    }

}
