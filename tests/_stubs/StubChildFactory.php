<?php
namespace TheSeer\Lib\Factory {

    class StubChildFactory implements ChildFactoryInterface {

        /**
         * @param Registry $factory
         *
         * @return array
         */
        public function setMasterFactory(MasterFactory $factory) {
        }

        public function createStdClass() {
            return new \StdClass();
        }

    }

}
