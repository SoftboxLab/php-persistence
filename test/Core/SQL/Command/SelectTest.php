<?php

namespace Softbox\Persistence\Core\SQL\Command\Test;

use Softbox\Persistence\Core\PersistenceService;
use Softbox\Persistence\Core\ResultSet;
use Softbox\Persistence\Core\SQL\Builder\SQLBuilder;
use Softbox\Persistence\Core\SQL\Command\Select;

class SelectTest extends \PHPUnit_Framework_TestCase {

    public function testExecute() {
        //$psMock = $this->getMockBuilder(PersistenceService::class)->getMock();

        //$psMock->method('query')->willReturn(new ResultSet());
    }

    private function getPS() {
        $psMock = $this->getMockBuilder(PersistenceService::class)->getMock();

        $psMock->method('query')->willReturn(new ResultSet());
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

    public function testConstrutor() {
        $psMock = $this->getPS();

        $select = new Select($psMock, 'teste');

        $this->assertEquals("teste", $select->getEntity());
        $this->expectException(\BadMethodCallException::class);

        new Select($psMock, 'teste_abc');
    }

    public function testProjection() {
        $select = new Select($this->getPS(), 'teste');

        $this->assertEquals($select, $select->projection("a", "b", "c"));
        $this->assertCount(3, $select->getCols());
        $this->expectException(\BadMethodCallException::class);
        $select->projection("d");
    }

    public function testLimit() {
        $select = new Select($this->getPS(), 'teste');

        $this->assertEquals($select, $select->projection("a", "b", "c"));
        $this->assertEquals($select, $select->limit(12, 200));
        $this->assertEquals(12, $select->getOffset());
        $this->assertEquals(200, $select->getRowCount());
    }

    //public function testBuild() {
    //    $select = new Select($this->getPS(), 'teste');
    //
    //    $select->projection("a", "b");
    //    $ret = $select->build(new SQLBuilder());
    //
    //    print_r($ret);
    //}
}