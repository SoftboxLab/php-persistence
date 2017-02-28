<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 27/02/17
 * Time: 19:35
 */

namespace Softbox\Persistence\Core\SQL\Builder\Test;

use Softbox\Persistence\Core\Condition;
use Softbox\Persistence\Core\SQL\Builder\SQLConverter;
use Softbox\Persistence\Core\SQL\Builder\SQLConditionConverter;

class SQLConditionBuilderTest extends \PHPUnit_Framework_TestCase {
    public function testBuild() {
        $sqlCondBuilder = new SQLConditionConverter(new SQLConverter());

        $cond = new Condition("a", ">", "b");

        $this->assertEquals("a > b", $sqlCondBuilder->convert($cond));

        $cond->setAnd(new Condition("d", "<", "c"));

        $this->assertEquals("a > b AND d < c", $sqlCondBuilder->convert($cond));

        $cond->setOr(new Condition("e", "=", "f"));

        $this->assertEquals("a > b AND d < c OR e = f", $sqlCondBuilder->convert($cond));

        $cond = new Condition("a", ">", "b");
        $cond->setOr(new Condition("e", "=", "f"));

        $this->assertEquals("a > b OR e = f", $sqlCondBuilder->convert($cond));

        echo $sqlCondBuilder->convert($cond);
    }
}