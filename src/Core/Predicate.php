<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 27/02/17
 * Time: 11:25
 */

namespace Softbox\Persistence\Core;

interface Predicate extends Buildable {
    public function setAnd(Predicate $predicate);

    public function setOr(Predicate $predicate);

    public function getAnd();

    public function getOr();
}