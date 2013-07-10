<?php

namespace Primitives;

class DecimalTest extends \PHPUnit_Framework_TestCase {

    public static function provideTestSubtract() {
        return array(
            array(array(1, 0), new Decimal(1, 0), array(0, 0)),
            array(array(1, 2), new Decimal(1, 2), array(0, 2)),
            array(array(1, 3), new Decimal(1, 2), array(0, 2)),
            array(array(1, 4), new Decimal(1, 2), array(0, 2)),
            array(array(1.5, 0), new Decimal(1.5, 0), array(0, 0)),
            array(array(1.5, 1), new Decimal(1.5, 1), array(0, 1)),
            array(array(1.5, 0), new Decimal(1.5, 1), array(0, 0)),
            array(array(0.1, 1), new Decimal(0.7, 1), array(-0.6, 1)),
            array(array(1, 0), 1, array(0, 0)),
            array(array(1, 0), 1.5, array(0, 0)),
            array(array(1, 1), 1, array(0, 1)),
            array(array(1, 1), 1.5, array(-0.5, 1)),
            array(array(2.5, 2), "2.54", array(-0.04, 2)),
        );
    }

    public static function provideTestAdd() {
        return array(
            array(array(1, 0), new Decimal(1, 0), array(2, 0)),
            array(array(1, 2), new Decimal(1, 2), array(2, 2)),
            array(array(1, 3), new Decimal(1, 2), array(2, 2)),
            array(array(1, 4), new Decimal(1, 2), array(2, 2)),
            array(array(1.5, 0), new Decimal(1.5, 0), array(2, 0)),
            array(array(1.5, 1), new Decimal(1.5, 1), array(3, 1)),
            array(array(1.5, 0), new Decimal(1.5, 1), array(2, 0)),
            array(array(0.1, 1), new Decimal(0.7, 1), array(0.8, 1)),
            array(array(1, 0), 1, array(2, 0)),
            array(array(1, 0), 1.5, array(2, 0)),
            array(array(1, 1), 1, array(2, 1)),
            array(array(1, 1), 1.5, array(2.5, 1)),
            array(array(2.5, 2), "2.54", array(5.04, 2)),
        );
    }

    public static function provideTestMultiply() {
        return array(
            array(array(1, 0), new Decimal(1, 0), array(1, 0)),
            array(array(1, 2), new Decimal(1, 2), array(1, 2)),
            array(array(1, 3), new Decimal(1, 2), array(1, 2)),
            array(array(1, 4), new Decimal(1, 2), array(1, 2)),
            array(array(1.5, 0), new Decimal(1.5, 0), array(1, 0)),
            array(array(1.5, 1), new Decimal(1.5, 1), array(2.2, 1)),
            array(array(1.5, 0), new Decimal(1.5, 1), array(1, 0)),
            array(array(0.1, 1), new Decimal(0.7, 1), array(0, 1)),
            array(array(1, 0), 1, array(1, 0)),
            array(array(1, 0), 1.5, array(1, 0)),
            array(array(1, 1), 1, array(1, 1)),
            array(array(1, 1), 1.5, array(1.5, 1)),
            array(array(2.5, 2), "2.54", array(6.35, 2)),
        );
    }

    public static function provideTestDivide() {
        return array(
            array(array(1, 0), new Decimal(1, 0), array(1, 0)),
            array(array(1, 2), new Decimal(1, 2), array(1, 2)),
            array(array(1, 3), new Decimal(1, 2), array(1, 2)),
            array(array(1, 4), new Decimal(1, 2), array(1, 2)),
            array(array(1.5, 0), new Decimal(1.5, 0), array(1, 0)),
            array(array(1.5, 1), new Decimal(1.5, 1), array(1, 1)),
            array(array(1.5, 0), new Decimal(1.5, 1), array(1, 0)),
            array(array(0.1, 1), new Decimal(0.7, 1), array(0.1, 1)),
            array(array(1, 0), 1, array(1, 0)),
            array(array(1, 0), 1.5, array(1, 0)),
            array(array(1, 1), 1, array(1, 1)),
            array(array(1, 1), 1.5, array(0.6, 1)),
            array(array(2.5, 2), "2.54", array(0.98, 2)),

        );
    }

    public static function provideTestModulo() {
        return array(
            array(array(1, 0), new Decimal(1, 0), array(0, 0)),
            array(array(1, 0), new Decimal(2, 0), array(1, 0)),
            array(array(1, 1), new Decimal(2, 1), array(1, 1)),

        );
    }

    public static function provideTestPercent() {
        return array(
            array(array(1, 0), 25, array(0, 0)),
            array(array(1, 0), 50, array(0, 0)),
            array(array(1, 1), 25, array(0.2, 1)),
            array(array(1, 1), 50, array(0.5, 1)),
            array(array(1, 2), 25, array(0.25, 2)),
            array(array(1, 2), 50, array(0.5, 2)),
        );
    }

    public static function provideTestConstructPermutations() {
        return array(
            array(5, 1, "5.0"),
            array(5.5, 1, "5.5"),
            array(0.1, 0, "0"),
            array(1.111, 2, "1.11"),
        );
    }

    /**
     * @dataProvider provideTestSubtract
     */
    public function testSubtract($a, $b, $c) {
        $decimal1 = new Decimal($a[0], $a[1]);
        $decimal3 = new Decimal($c[0], $c[1]);
        $this->assertEquals($decimal3, $decimal1->subtract($b));
    }


    /**
     * @dataProvider provideTestAdd
     */
    public function testAdd($a, $b, $c) {
        $decimal1 = new Decimal($a[0], $a[1]);
        $decimal3 = new Decimal($c[0], $c[1]);
        $this->assertEquals($decimal3, $decimal1->add($b));
    }

    /**
     * @dataProvider provideTestMultiply
     */
    public function testMultiply($a, $b, $c) {
        $decimal1 = new Decimal($a[0], $a[1]);
        $decimal3 = new Decimal($c[0], $c[1]);
        $this->assertEquals($decimal3, $decimal1->multiply($b));
    }

    /**
     * @dataProvider provideTestDivide
     */
    public function testDivide($a, $b, $c) {
        $decimal1 = new Decimal($a[0], $a[1]);
        $decimal3 = new Decimal($c[0], $c[1]);
        $this->assertEquals($decimal3, $decimal1->divide($b));
    }

    /**
     * @dataProvider provideTestModulo
     */
    public function testMod($a, $b, $c) {
        $decimal1 = new Decimal($a[0], $a[1]);
        $decimal3 = new Decimal($c[0], $c[1]);
        $this->assertEquals($decimal3, $decimal1->mod($b));
    }

    /**
     * @dataProvider provideTestPercent
     */
    public function testPercent($a, $b, $c) {
        $decimal1 = new Decimal($a[0], $a[1]);
        $decimal3 = new Decimal($c[0], $c[1]);
        $this->assertEquals($decimal3, $decimal1->percent($b));
    }


    /**
     * @dataProvider provideTestConstructPermutations
     */
    public function testConstructPermutations($value, $precision, $result) {
        $decimal = new Decimal($value, $precision);
        $this->assertEquals($result, $decimal->getValue());
    }


}