<?php
namespace TheSeer\Lib\Factory {

    class MasterFactoryException extends \Exception {

        const NoFactoryForMethod = 1;
        const NoMethodsExported = 2;
        const OverrideAlreadyDefined = 4;

    }

}
