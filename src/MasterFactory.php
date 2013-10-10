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