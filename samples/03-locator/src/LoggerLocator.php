<?php
namespace TheSeer\Lib\Factory\Sample {

    use TheSeer\Lib\Factory\MasterFactory;

    class LoggerLocator {

        private $factory;

        public function __construct(MasterFactory $factory) {
            $this->factory = $factory;
        }

        public function getLogger($type) {
            switch($type) {
                case 'file': {
                    return $this->factory->createFileLogger();
                }
                case 'null': {
                    return $this->factory->createNullLogger();
                }
                default: {
                    throw new \InvalidArgumentException("Unsupported logger type '$type'");
                }
            }
        }
    }

}
