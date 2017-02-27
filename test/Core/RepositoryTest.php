<?php

namespace Softbox\Persistence\Core\Test;

use Softbox\Persistence\Core\DatabaseRepository;
use Softbox\Persistence\Core\Select;
use Softbox\Persistence\Core\SQL\SQLBuilder;
use Softbox\Persistence\Core\Where;

class RepositoryTest extends \PHPUnit_Framework_TestCase {


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

    public function testWhere() {
        $sqlBuilder = new SQLBuilder();

        $where = new Where();
        $where->eq("a", 1)
            ->eq("b", 1)
            ->neq("b", 1)
            ->le("d", 3);

        $where->isEmpty("x");
        
        echo "\n" . $where->build($sqlBuilder) . "\n";
    }

    public function testSelectBuilder() {
        $select = new Select("tabela", ["a", "b", "c"]);

        $select->setWhere((new Where())->eq("a", 10));
        echo "\n\n" . $select->build(new SQLBuilder());
    }
}