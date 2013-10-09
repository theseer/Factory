<?php
namespace TheSeer\Lib\Factory\Sample {

    class Something {

        /**
         * @var Dependency
         */
        private $dependency;

        public function __construct(Dependency $dependency) {
            $this->dependency = $dependency;
        }
    }

}
