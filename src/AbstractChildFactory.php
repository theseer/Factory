<?php
namespace TheSeer\Lib\Factory {

    abstract class AbstractChildFactory implements ChildFactoryInterface {

        /**
         * @var MasterFactory
         */
        private $master;

        /**
         * @param MasterFactory $factory
         *
         * @return array
         */
        public function registerMaster(MasterFactory $factory) {
            $this->master = $factory;
        }

        protected function getMasterFactory() {
            return $this->master;
        }

    }

}
