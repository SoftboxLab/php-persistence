<?php

namespace Softbox\Persistence\Core\SQL;

use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\Builder;
use Softbox\Persistence\Core\Where;

class SQLWhere implements Buildable {
    private $where;

    private $builder;

    public function __construct(Builder $builder, Where $where) {
        $this->builder = $builder;

        $this->where = $where;
    }

    public function build() {
        $buffer = "";

        $delim = " ";

        foreach ($this->where->getConditions() as $condition) {
            $buffer .= $delim . $this->builder->build($condition);

            $delim = " AND ";
        }

        return "WHERE " . (empty($buffer) ? "1 = 1" : $buffer);
    }
}