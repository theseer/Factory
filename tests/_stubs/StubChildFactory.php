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

        /**
         * @return \StdClass
         */
        public function createStdClass() {
            return new \StdClass();
        }

    }

}
