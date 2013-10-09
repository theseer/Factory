<?php
namespace TheSeer\Lib\Factory {

    require __DIR__ . '/_stubs/StubChildFactory.php';
    require __DIR__ . '/_stubs/ExtendedStubChildFactory.php';

    class MasterFactoryTest extends \PHPUnit_Framework_TestCase {

        /**
         * @var MasterFactory
         */
        private $factory;

        protected function setUp() {
            $this->factory = new MasterFactory();
        }

        /**
         * @covers \TheSeer\Lib\Factory\MasterFactory::registerFactory
         */
        public function testChildFactoryCanBeRegistered() {
            $this->factory->registerFactory(new StubChildFactory());
            $this->assertTrue(true);
        }

        /**
         * @covers \TheSeer\Lib\Factory\MasterFactory::__call
         */
        public function testRegisteredChildFactoryGetsCalled() {
            $this->factory->registerFactory(new StubChildFactory());
            $std = $this->factory->createStdClass();
            $this->assertInstanceOf('\StdClass', $std);
        }

        /**
         * @covers \TheSeer\Lib\Factory\MasterFactory::registerFactory
         */
        public function testRegisteringASecondFactoryForSameMethodOverridesMethod() {
            $this->factory->registerFactory(new StubChildFactory());
            $this->factory->registerFactory(new ExtendedStubChildFactory());
            $std = $this->factory->createStdClass();
            $this->assertInstanceOf('\StdClass', $std);
            $this->assertTrue($std->isExtended);
        }

        /**
         * @expectedException \TheSeer\Lib\Factory\MasterFactoryException
         * @expectedExceptionCode \TheSeer\Lib\Factory\MasterFactoryException::OverrideAlreadyDefined
         */
        public function testTryingToOverrideAnAlreadyOverriddenMethodThrowsException() {
            $this->factory->registerFactory(new StubChildFactory());
            $this->factory->registerFactory(new ExtendedStubChildFactory());
            $this->factory->registerFactory(new ExtendedStubChildFactory());
        }

        /**
         * @expectedException \TheSeer\Lib\Factory\MasterFactoryException
         * @expectedExceptionCode \TheSeer\Lib\Factory\MasterFactoryException::NoMethodsExported
         */
        public function testTryingToRegisterAFactoryWithoutCreateMethodsThrowsException() {
            $this->factory->registerFactory($this->getMock('TheSeer\Lib\Factory\ChildFactoryInterface'));
        }

        /**
         * @expectedException \TheSeer\Lib\Factory\MasterFactoryException
         * @expectedExceptionCode \TheSeer\Lib\Factory\MasterFactoryException::NoFactoryForMethod
         */
        public function testCallingNonMappedMethodThrowsException() {
            $this->factory->createUndefined();
        }
    }

}