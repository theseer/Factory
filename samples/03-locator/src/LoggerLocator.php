<?php
namespace TheSeer\Lib\Factory\Sample {

    use TheSeer\Lib\Factory\MasterFactory;
    use TheSeer\Lib\Factory\Registry;

    class LoggerLocator {

        /**
         * @var Registry
         */
        private $factory;

        /**
         * @param Registry $factory
         */
        public function __construct(MasterFactory $factory) {
            $this->factory = $factory;
        }

        /**
         * @param $type
         *
         * @return LoggerInterface
         *
         * @throws \InvalidArgumentException
         */
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
