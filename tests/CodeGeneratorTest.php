<?php
namespace TheSeer\Lib\Factory {

    class CodeGeneratorTest extends \PHPUnit_Framework_TestCase {

        public function testCorrectCodeIsGenerated() {
            $registry = $this->getMock(Registry::class);
            $registry->expects($this->once())
                     ->method('getFactories')
                     ->will(
                         $this->returnValue(
                             array(new DifferingStubChildFactory())
                         ));

            $generator = new CodeGenerator('/*___METHODS___*/', '/*___DOCBLOCK___*//*___NAME___*/(/*___PARAMETERS___*/)');
            $code = $generator->generate($registry);

            $expected = '/**
         * @param array     $someParam
         * @param \StdClass $otherParam
         * @param int       $intParam
         * @param int       $constParam
         * @param null      $null
         *
         * @return \StdClass
         */createStdClass(Array $someParam, stdClass &$otherParam, $intParam=1, $constParam=TheSeer\Lib\Factory\PHP_INT_MAX, $null=)';

            $this->assertEquals($expected, $code);
        }

    }

}
