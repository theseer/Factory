<?php
namespace TheSeer\Lib\Factory\Sample {

    use TheSeer\Lib\Factory\AbstractChildFactory;

    class LoggerFactory extends AbstractChildFactory {

        public function createFileLogger() {
            return new FileLogger('/tmp/some_log');
        }

        public function createNullLogger() {
            return new NullLogger();
        }

    }

}
