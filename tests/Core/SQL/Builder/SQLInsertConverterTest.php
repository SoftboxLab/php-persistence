<?php

namespace Softbox\Persistence\Core\SQL\Builder\Test;

use Softbox\Persistence\Core\SQL\Command\SQLInsert;
use Softbox\Persistence\Core\SQL\PersistenceService;
use Softbox\Persistence\Core\ResultSetBase;
use Softbox\Persistence\Core\SQL\Builder\SQLConverter;
use Softbox\Persistence\Core\SQL\Builder\SQLInsertConverter;

class SQLInsertConverterTest extends \PHPUnit_Framework_TestCase {
    private function getPS() {
        $psMock = $this->getMockBuilder(PersistenceService::class)->getMock();

        $psMock->method('query')->willReturn(new ResultSetBase());
        $psMock->method('getColsOfTable')->willReturn(["a", "b", "c"]);
        $psMock->method('getMetaData')->willReturn([
            "a" => [
                "size" => 10,
                "type" => "int"
            ],

            "b" => [
                "size" => 10,
                "type" => "varchar"
            ],

            "c" => [
                "size" => 10,
                "type" => "varchar"
            ]
        ]);
        $psMock->method('existsTable')->willReturnMap([
            ["teste", true],
            ["teste_abc", false]
        ]);

        return $psMock;
    }

    public function testBuild() {
        $sqlBuilder = new SQLInsertConverter(new SQLConverter());

        $insert = new SQLInsert($this->getPS(), "teste");
        $insert->val("a", 123);
        $insert->val("b", 432);

        $this->assertEquals("INSERT INTO teste(a, b) VALUES (:a, :b)", $insert->build($sqlBuilder));

        $insert = new SQLInsert($this->getPS(), "teste");
        $insert->val("a", 123);
        $this->assertEquals("INSERT INTO teste(a) VALUES (:a)", $insert->build($sqlBuilder));

        $insert = new SQLInsert($this->getPS(), "teste");
        $insert->val("a", 123);
        $insert->val("x", 987);
        $this->assertEquals("INSERT INTO teste(a) VALUES (:a)", $insert->build($sqlBuilder));
    }
}