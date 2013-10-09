<?php
namespace TheSeer\Lib\Factory {

    require __DIR__ . '/_stubs/StubAbstractChildFactory.php';
    require __DIR__ . '/_stubs/TestClass.php';

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
