<?php
namespace TheSeer\Lib\Factory {

    class DifferingStubChildFactory implements ChildFactoryInterface {

        /**
         * @param Registry $factory
         *
         * @return array
         */
        public function setMasterFactory(MasterFactory $factory) {
        }

        public function createStdClass(Array $someParam, \StdClass &$otherParam, $intParam = 1, $constParam = PHP_INT_MAX, $null = NULL) {
            return new \StdClass();
        }

    }

}
