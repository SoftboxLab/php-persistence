<?php

namespace Softbox\Persistence\Core\SQL\Test;

use PHPUnit_Framework_TestCase;
use Softbox\Persistence\Core\Filter;
use Softbox\Persistence\Core\Projection;
use Softbox\Persistence\Core\SQL\DatabaseRepository;

class DatabaseRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function testQueryReturns()
    {
        $repo = new DatabaseRepository();

        /** @var Projection $projection */
        $projection = $repo->query("teste");

        $this->assertInstanceOf(Projection::class, $projection);
        $this->assertEquals($projection, $projection->projection("a", "b", "c"));
        $this->assertEquals($projection, $projection->filter((new Filter())->ge("a", 1)));
        $this->assertEquals($projection, $projection->limit(1, 100));
        $this->assertEquals($projection, $projection->order("a ASC"));

        $this->assertEquals("teste", $projection->getEntity());
        $this->assertInternalType("array", $projection->getCols());
    }
}
