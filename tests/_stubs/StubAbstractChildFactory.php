<?php
namespace TheSeer\Lib\Factory {

    class StubAbstractChildFactory extends AbstractChildFactory {

        public function createTestClass() {
            return new TestClass(
                $this->getMasterFactory()
            );
        }

    }

}
