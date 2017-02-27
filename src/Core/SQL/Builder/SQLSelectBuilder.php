<?php

namespace Softbox\Persistence\Core\SQL\Builder;

use Softbox\Persistence\Core\Builder;
use Softbox\Persistence\Core\Projection;

class SQLSelectBuilder implements Builder {
    private $builder;

    public function __construct(Builder $builder) {
        $this->builder = $builder;
    }

    private function buildCols(Projection $select) {
        $buffer = "";
        $delim = "";

        foreach ($select->getCols() as $col) {
            $buffer .= $delim . $col;

            $delim = ", ";
        }

        return empty($buffer) ? "*" : $buffer;
    }

    private function buildOrderBy(Projection $select) {
        if (empty($select->getOrderBy())) {
            return "";
        }

        return " ORDER BY " . implode(", ", $select->getOrderBy());
    }

    private function buildLimit(Projection $select) {
        if ($select->getOffset() === null) {
            return "";
        }

        return " LIMIT " . $select->getOffset() . ", " . $select->getRowCount();
    }

    private function buildWhere(Projection $select) {
        if ($select->getFilter() === null) {
            return "";
        }
        return $this->builder->build($select->getFilter());
    }

    public function build($value) {
        if (!($value instanceof Projection)) {
            throw new \BadMethodCallException("Supply a Select value.");
        }

        return sprintf("SELECT %s FROM %s%s%s%s",
            $this->buildCols($value),
            $value->getEntity(),
            $this->buildWhere($value),
            $this->buildOrderBy($value),
            $this->buildLimit($value));
    }
}