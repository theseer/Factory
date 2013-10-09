<?php
namespace TheSeer\Lib\Factory {

    interface ChildFactoryInterface {

        /**
         * @param MasterFactory $factory
         *
         * @return array
         */
        public function registerMaster(MasterFactory $factory);

    }

}


