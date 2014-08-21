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

        /**
         * @param array     $someParam
         * @param \StdClass $otherParam
         * @param int       $intParam
         * @param int       $constParam
         * @param null      $null
         *
         * @return \StdClass
         */
        public function createStdClass(Array $someParam, \StdClass &$otherParam, $intParam = 1, $constParam = PHP_INT_MAX, $null = NULL) {
            return new \StdClass();
        }

    }

}
