<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'theseer\\lib\\factory\\abstractchildfactory' => '/AbstractChildFactory.php',
                'theseer\\lib\\factory\\childfactoryinterface' => '/ChildFactoryInterface.php',
                'theseer\\lib\\factory\\masterfactory' => '/MasterFactory.php',
                'theseer\\lib\\factory\\masterfactoryexception' => '/MasterFactoryException.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    }
);
// @codeCoverageIgnoreEnd