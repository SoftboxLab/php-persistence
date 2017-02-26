<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 25/02/17
 * Time: 16:32
 */

namespace Softbox\Persistence\Core\Test;

use Softbox\Persistence\Core\Repository;

class RepositoryTest {


    public function test() {
        $repository = new Repository();


        $repository->query("xpto")
            ->col("a, b, c")
            ->where(new Where())
            ->execute();


        $repository->query("xpto")
           ->col("a, b, c")
           ->where(ExampleBuilder.build([
               "cola_a" => "1",
               "colb_a" => "2"
               ]))
           ->execute();
    }
}