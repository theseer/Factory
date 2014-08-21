<?php
namespace TheSeer\Lib\Factory {

    class RegistryTest extends \PHPUnit_Framework_TestCase {

        /**
         * @var Registry
         */
        private $registry;

        protected function setUp() {
            $this->registry = new Registry();
        }

        /**
         * @covers \TheSeer\Lib\Factory\Registry::addFactory
         * @covers \TheSeer\Lib\Factory\Registry::getMethod
         */
        public function testChildFactoryCanBeRegistered() {
            $this->registry->addFactory(new StubChildFactory());
            $result = $this->registry->getMethod('createStdClass');
            $this->assertInstanceOf(StubChildFactory::class, $result[0]);
            $this->assertEquals('createStdClass', $result[1]);
        }

        /**
         * @covers \TheSeer\Lib\Factory\Registry::getFactories
         */
        public function testListOfRegisteredFactoriesCanBeRetrieved() {
            $this->registry->addFactory(new StubChildFactory());
            $list = $this->registry->getFactories();
            $this->assertArrayHasKey(StubChildFactory::class, $list);
            $this->assertInstanceOf(StubChildFactory::class, $list[StubChildFactory::class]);
        }

        /**
         * @covers \TheSeer\Lib\Factory\Registry::addFactory
         * @covers \TheSeer\Lib\Factory\Registry::getMethod
         */
        public function testRegisteringASecondFactoryForSameMethodOverridesMethod() {
            $this->registry->addFactory(new StubChildFactory());
            $this->registry->addFactory(new ExtendedStubChildFactory());
            $result = $this->registry->getMethod('createStdClass');
            $this->assertInstanceOf('TheSeer\\Lib\\Factory\\ExtendedStubChildFactory', $result[0]);
            $this->assertEquals('createStdClass', $result[1]);
        }

        /**
         * @expectedException \TheSeer\Lib\Factory\RegistryException
         * @expectedExceptionCode \TheSeer\Lib\Factory\RegistryException::AlreadyRegistered
         */
        public function testTryingToRegisterTheSameFactoryClassTwiceThrowsException() {
            $this->registry->addFactory(new StubChildFactory());
            $this->registry->addFactory(new ExtendedStubChildFactory());
            $this->registry->addFactory(new ExtendedStubChildFactory());
        }

        /**
         * @expectedException \TheSeer\Lib\Factory\RegistryException
         * @expectedExceptionCode \TheSeer\Lib\Factory\RegistryException::OverrideAlreadyDefined
         */
        public function testTryingToOverrideAnAlreadyOverriddenMethodThrowsException() {
            $this->registry->addFactory(new StubChildFactory());
            $this->registry->addFactory(new ExtendedStubChildFactory());
            $this->registry->addFactory(new OverrideExtendedStubChildFactory());
        }

        /**
         * @expectedException \TheSeer\Lib\Factory\RegistryException
         * @expectedExceptionCode \TheSeer\Lib\Factory\RegistryException::NoMethodsExported
         */
        public function testTryingToRegisterAFactoryWithoutCreateMethodsThrowsException() {
            $this->registry->addFactory($this->getMock('TheSeer\Lib\Factory\ChildFactoryInterface'));
        }

        /**
         * @expectedException \TheSeer\Lib\Factory\RegistryException
         * @expectedExceptionCode \TheSeer\Lib\Factory\RegistryException::SignaturesDiffer
         */
        public function testTryingToRegisterAFactoryToOverrideWithDifferentSignatureThrowsException() {
            $this->registry->addFactory(new StubChildFactory());
            $this->registry->addFactory(new DifferingStubChildFactory());
        }

        /**
         * @expectedException \TheSeer\Lib\Factory\RegistryException
         * @expectedExceptionCode \TheSeer\Lib\Factory\RegistryException::NoSuchMethod
         */
        public function testCallingNonMappedMethodThrowsException() {
            $this->registry->getMethod('undefined');
        }
    }

}
