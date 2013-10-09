<?php
namespace TheSeer\Lib\Factory\Sample {

    use TheSeer\Lib\Factory\AbstractChildFactory;

    class ABTestFactory extends AbstractChildFactory {

        public function createHelper() {
            return new AlternativeHelper();
        }
    }

}
