<?php
namespace TheSeer\Lib\Factory\Sample {

    use TheSeer\Lib\Factory\AbstractChildFactory;

    class LocatorFactory extends AbstractChildFactory {

        /**
         * @return LoggerLocator
         */
        public function createLoggerLocator() {
            return new LoggerLocator($this->getMasterFactory());
        }
    }

}
