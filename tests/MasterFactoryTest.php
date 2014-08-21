<?php
namespace TheSeer\Lib\Factory {

    class MasterFactoryTest extends \PHPUnit_Framework_TestCase {

        /**
         * @var MasterFactory
         */
        private $factory;

        /**
         * @var Registry
         */
        private $registry;

        protected function setUp() {
            $this->registry = $this->getMock(Registry::class);
            $this->factory = new MasterFactory($this->registry);
        }

        /**
         * @covers \TheSeer\Lib\Factory\MasterFactory::registerFactory
         */
        public function testChildFactoryCanBeRegistered() {
            $this->registry->expects($this->once())->method('addFactory');
            $this->factory->registerFactory(new StubChildFactory());
        }

        /**
         * @expectedException \TheSeer\Lib\Factory\MasterFactoryException
         * @expectedExceptionCode -1
         */
        public function testRegistryExceptionWhenRegisteringGetsTransformedToMasterFactoryException() {
            $this->registry->expects($this->once())->method('addFactory')
                           ->will($this->throwException(new RegistryException('foo', -1)));
            $this->factory->registerFactory($this->getMock(ChildFactoryInterface::class));
        }

        /**
         * @covers \TheSeer\Lib\Factory\MasterFactory::forward
         * @covers \TheSeer\Lib\Factory\MasterFactory::__call
         */
        public function testRegisteredChildFactoryGetsCalled() {
            $this->registry->expects($this->once())
                ->method('hasMethod')->with($this->equalTo('createStdClass'))
                ->will($this->returnValue(true));
            $this->registry->expects($this->once())
                 ->method('getMethod')->with($this->equalTo('createStdClass'))
                 ->will($this->returnValue(function(){return new \StdClass;}));
            $std = $this->factory->createStdClass();
            $this->assertInstanceOf('\StdClass', $std);
        }

        /**
         * @expectedException \TheSeer\Lib\Factory\MasterFactoryException
         * @expectedExceptionCode \TheSeer\Lib\Factory\MasterFactoryException::NoMethodsExported
         */
        public function testTryingToRegisterAFactoryWithoutCreateMethodsThrowsException() {
            $this->factory->addFactory($this->getMock('TheSeer\Lib\Factory\ChildFactoryInterface'));
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
