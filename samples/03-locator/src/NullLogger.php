<?php
namespace TheSeer\Lib\Factory\Sample {

    class NullLogger implements LoggerInterface {

        /**
         * @param string $msg
         *
         * @return void
         */
        public function log($msg) {
        }
    }

}
