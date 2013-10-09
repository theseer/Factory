<?php
namespace TheSeer\Lib\Factory {

    class ExtendedStubChildFactory extends StubChildFactory {

        public function createStdClass() {
            $std = parent::createStdClass();
            $std->isExtended = true;
            return $std;
        }

    }

}
