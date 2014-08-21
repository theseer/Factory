<?php
namespace TheSeer\Lib\Factory {

    class CodeGenerator {

        /**
         * @var string
         */
        private $classTemplate;

        /**
         * @var string
         */
        private $methodTemplate;

        /**
         * @param string $classTemplate
         * @param string $methodTemplate
         */
        public function __construct($classTemplate, $methodTemplate) {
            $this->classTemplate = $classTemplate;
            $this->methodTemplate = $methodTemplate;
        }

        public function generate(Registry $registry) {
            $methodList=array();
            foreach($registry->getFactories() as $factory) {
                foreach(get_class_methods($factory) as $methodName) {
                    if (strpos($methodName, 'create') !== 0) {
                        continue;
                    }
                    $methodObj = new \ReflectionMethod($factory, $methodName);
                    $methodList[] = $this->buildMethod($methodObj);
                }
            }
            return str_replace('/*___METHODS___*/', join("\n\n", $methodList), $this->classTemplate);
        }

        private function buildMethod(\ReflectionMethod $methodObj) {
            $method = array(
                '/*___DOCBLOCK___*/' => trim($methodObj->getDocComment()),
                '/*___NAME___*/' => $methodObj->getName(),
                '/*___PARAMETERS___*/' => $this->buildParameters($methodObj->getParameters())
            );
            return str_replace(array_keys($method), array_values($method), $this->methodTemplate);
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
                        $parameter .= 'NULL';
                    }
                }
                $list[] = $parameter;
            }
            return join(', ', $list);
        }

    }

}
