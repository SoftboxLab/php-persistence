<?php

namespace Softbox\Persistence\Core\SQL\Command\Test;

use Softbox\Persistence\Core\Filter;
use Softbox\Persistence\Core\ResultSetBase;
use Softbox\Persistence\Core\SQL\Builder\SQLConverter;
use Softbox\Persistence\Core\SQL\Command\SQLException;
use Softbox\Persistence\Core\SQL\Command\SQLSelect;
use Softbox\Persistence\Core\SQL\PersistenceService;

class SelectTest extends \PHPUnit_Framework_TestCase {

    private function getPS() {
        $psMock = $this->getMockBuilder(PersistenceService::class)->getMock();

        $psMock->method('query')->willReturn(new ResultSetBase());
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

        $select = new SQLSelect($psMock, 'teste');

        $this->assertEquals("teste", $select->getEntity());
        $this->expectException(SQLException::class);

        new SQLSelect($psMock, 'teste_abc');
    }

    public function testProjection() {
        $select = new SQLSelect($this->getPS(), 'teste');

        $this->assertEquals($select, $select->projection("a", "b", "c"));
        $this->assertCount(3, $select->getCols());
        $this->expectException(SQLException::class);
        $select->projection("d");
    }

    public function testLimit() {
        $select = new SQLSelect($this->getPS(), 'teste');

        $this->assertEquals($select, $select->projection("a", "b", "c"));
        $this->assertEquals($select, $select->limit(12, 200));
        $this->assertEquals(12, $select->getOffset());
        $this->assertEquals(200, $select->getRowCount());
    }

    public function testBuild() {
        $select = new SQLSelect($this->getPS(), 'teste');

        $select->projection("a", "b");
        $this->assertEquals("SELECT a, b FROM teste", $select->build(new SQLConverter()));
    }

    public function testGetParams() {
        $select = new SQLSelect($this->getPS(), 'teste');

        $select->projection("a", "b");

        $filter = new Filter();
        $filter->eq("a", 1234);
        $filter->eq("b", 5678);

        $select->filter($filter);
        $this->assertEquals("SELECT a, b FROM teste WHERE b = :p_1 AND a = :p_0", $select->build(new SQLConverter()));

        $params = $filter->getParams();

        $this->assertCount(2, $params);
        $this->assertEquals(1234, $params["p_0"]);
        $this->assertEquals(5678, $params["p_1"]);
    }
}