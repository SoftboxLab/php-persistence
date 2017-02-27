<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 27/02/17
 * Time: 19:46
 */

namespace Softbox\Persistence\Core\SQL\Builder\Test;

use Softbox\Persistence\Core\PersistenceService;
use Softbox\Persistence\Core\ResultSet;
use Softbox\Persistence\Core\SQL\Builder\SQLBuilder;
use Softbox\Persistence\Core\SQL\Builder\SQLSelectBuilder;
use Softbox\Persistence\Core\SQL\Command\Select;

class SQLSelectBuilderTest extends \PHPUnit_Framework_TestCase {

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
    public function testBuilder() {
        $sqlSelectBuilder = new SQLSelectBuilder(new SQLBuilder());

        $select = new Select($this->getPS(), "teste");
        $select->projection("a");

        $this->assertEquals("SELECT a FROM teste", $sqlSelectBuilder->build($select));
        $this->assertEquals("SELECT a, b FROM teste", $sqlSelectBuilder->build($select->projection("a", "b")));
        $this->assertEquals("SELECT * FROM teste", $sqlSelectBuilder->build($select->projection()));
    }

    public function testOrderBy() {
        $sqlSelectBuilder = new SQLSelectBuilder(new SQLBuilder());

        $select = new Select($this->getPS(), "teste");
        $select->projection("a");

        $this->assertEquals("SELECT a FROM teste ORDER BY a DESC", $sqlSelectBuilder->build($select->order("a DESC")));
        $this->assertEquals("SELECT a FROM teste ORDER BY a DESC, b ASC", $sqlSelectBuilder->build($select->order("a DESC", "b ASC")));

        $select->projection("a", "b")
               ->order("a ASC", "b desc");
        $this->assertEquals("SELECT a, b FROM teste ORDER BY a ASC, b DESC", $select->build(new SQLBuilder()));

        $select->order("b", "a");
        $this->assertEquals("SELECT a, b FROM teste ORDER BY b ASC, a ASC", $select->build(new SQLBuilder()));

        $select->order("c");
        $this->assertEquals("SELECT a, b FROM teste ORDER BY c ASC", $select->build(new SQLBuilder()));

        $select->order("c desc");
        $this->assertEquals("SELECT a, b FROM teste ORDER BY c DESC", $select->build(new SQLBuilder()));

        $this->expectException(\BadMethodCallException::class);
        $select->order("d desc");
    }
}