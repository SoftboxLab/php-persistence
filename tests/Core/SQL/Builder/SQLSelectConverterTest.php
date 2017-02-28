<?php

namespace Softbox\Persistence\Core\SQL\Builder\Test;

use Softbox\Persistence\Core\Filter;
use Softbox\Persistence\Core\ResultSet;
use Softbox\Persistence\Core\SQL\Builder\SQLConverter;
use Softbox\Persistence\Core\SQL\Builder\SQLConverterException;
use Softbox\Persistence\Core\SQL\Builder\SQLSelectConverter;
use Softbox\Persistence\Core\SQL\Command\SQLException;
use Softbox\Persistence\Core\SQL\Command\SQLSelect;
use Softbox\Persistence\Core\SQL\PersistenceService;

class SQLSelectConverterTest extends \PHPUnit_Framework_TestCase {

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

    public function testConverter() {
        $sqlSelectBuilder = new SQLSelectConverter(new SQLConverter());

        $select = new SQLSelect($this->getPS(), "teste");
        $select->projection("a");

        $this->assertEquals("SELECT a FROM teste", $sqlSelectBuilder->convert($select));
        $this->assertEquals("SELECT a, b FROM teste", $sqlSelectBuilder->convert($select->projection("a", "b")));
        $this->assertEquals("SELECT * FROM teste", $sqlSelectBuilder->convert($select->projection()));
    }

    public function testOrderBy() {
        $sqlSelectBuilder = new SQLSelectConverter(new SQLConverter());

        $select = new SQLSelect($this->getPS(), "teste");
        $select->projection("a");

        $this->assertEquals("SELECT a FROM teste ORDER BY a DESC", $sqlSelectBuilder->convert($select->order("a DESC")));
        $this->assertEquals("SELECT a FROM teste ORDER BY a DESC, b ASC", $sqlSelectBuilder->convert($select->order("a DESC", "b ASC")));

        $select->projection("a", "b")
               ->order("a ASC", "b desc");
        $this->assertEquals("SELECT a, b FROM teste ORDER BY a ASC, b DESC", $select->build(new SQLConverter()));

        $select->order("b", "a");
        $this->assertEquals("SELECT a, b FROM teste ORDER BY b ASC, a ASC", $select->build(new SQLConverter()));

        $select->order("c");
        $this->assertEquals("SELECT a, b FROM teste ORDER BY c ASC", $select->build(new SQLConverter()));

        $select->order("c desc");
        $this->assertEquals("SELECT a, b FROM teste ORDER BY c DESC", $select->build(new SQLConverter()));

        $this->expectException(SQLException::class);
        $select->order("d desc");
    }

    public function testParams() {
        $select = new SQLSelect($this->getPS(), "teste");
        $select->projection("a");

        $filter = new Filter();
        $filter->eq("a", 123);

        $select->filter($filter);
        $this->assertEquals("SELECT a FROM teste WHERE a = :p_0", $select->build(new SQLConverter()));

        $filter->eq("b", 123);
        $this->assertEquals("SELECT a FROM teste WHERE b = :p_1 AND a = :p_0", $select->build(new SQLConverter()));

        $filter->setOr()->eq("c", 123);
        $this->assertEquals("SELECT a FROM teste WHERE c = :p_2 OR b = :p_1 AND a = :p_0", $select->build(new SQLConverter()));
    }
}