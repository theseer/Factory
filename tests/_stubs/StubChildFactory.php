<?php
namespace TheSeer\Lib\Factory {

    class StubChildFactory implements ChildFactoryInterface {

        /**
         * @param MasterFactory $factory
         *
         * @return array
         */
        public function registerMaster(MasterFactory $factory) {
        }

        public function createStdClass() {
            return new \StdClass();
        }

    }

}
