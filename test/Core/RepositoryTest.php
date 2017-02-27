<?php

namespace Softbox\Persistence\Core\Test;

use Softbox\Persistence\Core\DatabaseRepository;
use Softbox\Persistence\Core\Projection;
use Softbox\Persistence\Core\SQL\SQLBuilder;
use Softbox\Persistence\Core\Filter;

class RepositoryTest extends \PHPUnit_Framework_TestCase {

    public function testQuery() {
    }


    //public function test() {
        //$repository = new DatabaseRepository();
        //
        //
        //$repository->query("xpto")
        //    ->col("a, b, c")
        //    ->where(new Where())
        //    ->execute();
        //
        //
        //$repository->query("xpto")
        //   ->col("a, b, c")
        //   ->where(ExampleBuilder.build([
        //       "cola_a" => "1",
        //       "colb_a" => "2"
        //       ]))
        //   ->execute();
        //
        //
        //new Where().eq().eq().eq().addOr().endOr();
        //
        //$repository->query("xxx")
        //        ->where();
    //}

    //public function testWhere() {
    //    $sqlBuilder = new SQLBuilder();
    //
    //    $where = new Where();
    //    $where->eq("a", 1)
    //        ->eq("b", 1)
    //        ->le("c", 3)
    //        ->le("d", 3)
    //        ->setOr()
    //            ->le('x', 3)
    //            ->lt('y', 3)
    //        ->setAnd()
    //            ->gt('w', 4)
    //            ->gt('q', 4)
    //    ;
    //
    //    //$where->isEmpty("x");
    //
    //    //$where->or();
    //
    //    echo "\n" . $where->build($sqlBuilder) . "\n";
    //}

    //public function testSelectBuilder() {
    //    $select = new Select("tabela", ["a", "b", "c"]);
    //
    //    $select->setWhere((new Where())->eq("a", 10));
    //    echo "\n\n" . $select->build(new SQLBuilder());
    //}
}