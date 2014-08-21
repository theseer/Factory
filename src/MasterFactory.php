<?php
namespace TheSeer\Lib\Factory {

    class MasterFactory {

        use RegisteredTrait;

        /**
         * @var Registry
         */
        private $registry;

        public function __construct(Registry $registry) {
            $this->registry = $registry;
        }

        /**
         * Register a ChildFactory
         * All public methods starting with 'create' will get registered
         *
         * @param ChildFactoryInterface $factory
         *
         * @throws MasterFactoryException
         */
        public function registerFactory(ChildFactoryInterface $factory) {
            try {
                $this->registry->addFactory($factory);
                $factory->setMasterFactory($this);
            } catch (RegistryException $e) {
                throw new MasterFactoryException($e->getMessage(), $e->getCode(), $e);
            }
        }

        /**
         * Forward calls of requested method to registered factory
         *
         * @param $name
         * @param $arguments
         *
         * @return mixed
         * @throws RegistryException
         */
        protected function forward($name, $arguments) {
            if (!$this->registry->hasMethod($name)) {
                throw new MasterFactoryException("No factory registered for method '$name'", MasterFactoryException::NoFactoryForMethod);
            }
            return call_user_func_array($this->registry->getMethod($name), $arguments);
        }

        public function __call($name, $method) {
            return $this->forward($name, $method);
        }

    }

}
