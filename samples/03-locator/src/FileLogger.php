<?php
namespace TheSeer\Lib\Factory\Sample {

    class FileLogger implements LoggerInterface {

        /**
         * @var string
         */
        private $filename;

        public function __construct($filename) {
            $this->filename = $filename;
        }

        /**
         * @param string $msg
         *
         * @return void
         */
        public function log($msg) {
            file_put_contents($this->filename, $msg . "\n", FILE_APPEND);
        }

    }

}
