<?php
namespace TheSeer\Lib\Factory {

    class AbstractChildFactoryTest extends \PHPUnit_Framework_TestCase {

        public function testGetMasterFactoryReturnsInstanceOfMasterFactory() {
            $factory = new MasterFactory(new Registry());
            $factory->registerFactory(new StubAbstractChildFactory());
            $this->assertInstanceOf(
                TestClass::class,
                $factory->createTestClass()
            );
        }
    }

}
