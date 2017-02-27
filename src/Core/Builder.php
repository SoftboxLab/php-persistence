<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 27/02/17
 * Time: 00:12
 */

namespace Softbox\Persistence\Core;

interface Builder {

    public function build($value);
}