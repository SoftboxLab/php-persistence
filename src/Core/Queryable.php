<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 26/02/17
 * Time: 10:34
 */

namespace Softbox\Persistence\Core;

interface Queryable {

    public function col(...$cols);

    public function where($where);

    public function order(...$orders);

    public function limit($offset, $rowCount);

    public function execute();
}