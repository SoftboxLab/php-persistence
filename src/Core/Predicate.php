<?php

namespace Softbox\Persistence\Core;

interface Predicate extends Buildable
{
    public function setAnd(Predicate $predicate);

    public function setOr(Predicate $predicate);

    public function getAnd();

    public function getOr();
}
