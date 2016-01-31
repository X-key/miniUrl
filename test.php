<?php
require "vendor\Autoload.php";
require "sqrt_class.php";

class sqrt_classTest extends PHPUnit_Framework_TestCase{
    /**
     * @dataProvider providerSq
     */
    public function testSq($a,$b){

        $ob = new sqrt_class();
        $this->assertEquals($a,$ob->sq($b));

    }

    public function providerSq(){

        return array(

            array(2,4),
            array(5,25),
            array(6,36)

        );

    }

}