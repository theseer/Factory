<?php
namespace TheSeer\Lib\Factory {

    abstract class AbstractChildFactoryTest extends \PHPUnit_Framework_TestCase {

        /**
         * @covers \TheSeer\Lib\Factory\AbstractChildFactory::registerMaster
         * @covers \TheSeer\Lib\Factory\AbstractChildFactory::getMasterFactory
         */
        public function testGetMasterFactoryReturnsInstanceOfMasterFactory() {
            $factory = new MasterFactory();
            $factory->registerFactory(new StubAbstractChildFactory());
            $this->assertInstanceOf(
                'TheSeer\Lib\Factory\TestClass',
                $factory->createTestClass()
            );
        }
    }

}
