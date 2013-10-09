<?php
namespace TheSeer\Lib\Factory {

    class MasterFactory {

        /**
         * List of registered factories and their exporting methods
         * Format: $method => $factory
         *
         * @var array
         */
        private $methods = array();

        /**
         * List of methods that have overrides
         *
         * @var array
         */
        private $overrides = array();

        /**
         * Register a ChildFactory
         * All public methods starting with 'create' will get registered
         *
         * @param ChildFactoryInterface $factory
         *
         * @throws MasterFactoryException
         */
        public function registerFactory(ChildFactoryInterface $factory) {
            $found = FALSE;
            foreach(get_class_methods($factory) as $method) {
                if (strpos($method, 'create') !== 0) {
                    continue;
                }
                if (isset($this->overrides[$method])) {
                    throw new MasterFactoryException(
                        sprintf("Factory '%s' already overrides method '%s' (originally provided by '%s')",
                            get_class($this->methods[$method]),
                            $method,
                            $this->overrides[$method]),
                        MasterFactoryException::OverrideAlreadyDefined
                    );
                }
                if (isset($this->methods[$method])) {
                    $this->overrides[$method] = get_class($this->methods[$method]);
                }
                $this->methods[$method] = $factory;
                $found = TRUE;
            }
            if (!$found) {
                throw new MasterFactoryException(
                    sprintf("Factory '%s'  does not provide any methods", get_class($factory)),
                    MasterFactoryException::NoMethodsExported
                );
            }
            $factory->registerMaster($this);
        }

        /**
         * Forward calls of requested method to registered factory
         *
         * @param $name
         * @param $arguments
         *
         * @return mixed
         * @throws MasterFactoryException
         */
        public function __call($name, $arguments) {
            if (!isset($this->methods[$name])) {
                throw new MasterFactoryException("No factory registered for method '$name'", MasterFactoryException::NoFactoryForMethod);
            }
            return call_user_func_array(array($this->methods[$name], $name), $arguments);
        }

    }

}