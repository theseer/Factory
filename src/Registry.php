<?php
/**
 * Copyright (c) 2013 Arne Blankerts <arne@blankerts.de>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *   * Redistributions of source code must retain the above copyright notice,
 *     this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright notice,
 *     this list of conditions and the following disclaimer in the documentation
 *     and/or other materials provided with the distribution.
 *
 *   * Neither the name of Arne Blankerts nor the names of contributors
 *     may be used to endorse or promote products derived from this software
 *     without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT  * NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER ORCONTRIBUTORS
 * BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    Factory
 * @author     Arne Blankerts <arne@blankerts.de>
 * @copyright  Arne Blankerts <arne@blankerts.de>, All rights reserved.
 * @license    BSD License
 */
namespace TheSeer\Lib\Factory {

    /**
     * Class Registry
     *
     * @package TheSeer\Lib\Factory
     */
    class Registry {

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
         * List of registered factories
         *
         * @var ChildFactoryInterface[]
         */
        private $factories = array();

        /**
         * Add a ChildFactory
         * All public methods starting with 'create' will get registered
         *
         * @param ChildFactoryInterface $factory
         *
         * @throws RegistryException
         */
        public function addFactory(ChildFactoryInterface $factory) {
            $class = get_class($factory);
            if (isset($this->factories[$class])) {
                throw new RegistryException(
                    sprintf("An instance of '%s' has already been registered", $class),
                    RegistryException::AlreadyRegistered
                );
            }
            if (!$this->registerMethods($factory)) {
                throw new RegistryException(
                    sprintf("Factory '%s'  does not provide any create methods", $class),
                    RegistryException::NoMethodsExported
                );
            }
            $this->factories[$class] = $factory;
        }

        /**
         * @param $name
         *
         * @return bool
         */
        public function hasMethod($name) {
            return isset($this->methods[$name]);
        }

        /**
         * @param $name
         *
         * @return array
         */
        public function getMethod($name) {
            if (!$this->hasMethod($name)) {
                throw new RegistryException(
                    sprintf("No method %s registered", $name),
                    RegistryException::NoSuchMethod
                );
            }
            return array($this->methods[$name], $name);
        }

        /**
         * @return ChildFactoryInterface[]
         */
        public function getFactories() {
            return $this->factories;
        }

        /**
         * @param ChildFactoryInterface $factory
         *
         * @throws RegistryException
         */
        private function registerMethods(ChildFactoryInterface $factory) {
            $found = FALSE;
            foreach(get_class_methods($factory) as $method) {
                if (strpos($method, 'create') !== 0) {
                    continue;
                }
                if (isset($this->overrides[$method])) {
                    throw new RegistryException(
                        sprintf("Factory '%s' already overrides method '%s' (originally provided by '%s')",
                            get_class($this->methods[$method]),
                            $method,
                            $this->overrides[$method]),
                        RegistryException::OverrideAlreadyDefined
                    );
                }
                if (isset($this->methods[$method])) {
                    $expectRef = new \ReflectionMethod($this->methods[$method], $method);
                    $actualRef = new \ReflectionMethod($factory, $method);
                    if (!$this->isEqualSignature($expectRef, $actualRef)) {
                        throw new RegistryException(
                            sprintf("Signature of method '%s' differs from original Factory '%s' to '%s'",
                                $method,
                                get_class($this->methods[$method]),
                                get_class($factory)
                            ),
                            RegistryException::SignaturesDiffer
                        );
                    }
                    $this->overrides[$method] = get_class($this->methods[$method]);
                }
                $this->methods[$method] = $factory;
                $found = TRUE;
            }
            return $found;
        }


        private function isEqualSignature(\ReflectionMethod $expectedRef, \ReflectionMethod $actualRef) {
            $expectedParams = $this->buildParameters($expectedRef->getParameters());
            $actualParams = $this->buildParameters($actualRef->getParameters());
            return $expectedParams == $actualParams;
        }

        /**
         * @param \ReflectionParameter[] $parameters
         */
        private function buildParameters(array $parameters) {
            $list = array();
            foreach($parameters as $parameterObj) {
                $parameter = '';

                if ($parameterObj->isArray()) {
                    $parameter .= 'Array ';
                } elseif ($parameterObj->getClass()) {
                    $parameter .= $parameterObj->getClass()->getName() . ' ';
                }

                if ($parameterObj->isPassedByReference()) {
                    $parameter .= '&';
                }

                $parameter .= '$' . $parameterObj->getName();

                if ($parameterObj->isOptional()) {
                    $parameter .= '=';
                    if ($parameterObj->isDefaultValueConstant()) {
                        $parameter .= $parameterObj->getDefaultValueConstantName();
                    } else if ($parameterObj->isDefaultValueAvailable()) {
                        $parameter .= $parameterObj->getDefaultValue();
                    } else {
                        // I have no idea how an optional parameter cannot have
                        // a default value set, but obviously it can be ...
                        // @codeCoverageIgnoreStart
                        $parameter .= 'NULL';
                        // @codeCoverageIgnoreEnd
                    }
                }
                $list[] = $parameter;
            }
            return join(', ', $list);
        }


    }

}
