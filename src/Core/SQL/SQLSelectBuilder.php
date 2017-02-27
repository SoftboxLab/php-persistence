<?php

namespace Softbox\Persistence\Core\SQL;

use Softbox\Persistence\Core\Builder;
use Softbox\Persistence\Core\Select;

class SQLSelectBuilder implements Builder {
    private $builder;

    public function __construct(BUilder $builder) {
        $this->builder = $builder;
    }

    private function buildCols(Select $select) {
        $buffer = "*";

        $cols = ["a" => true];

        $delim = " ";

        foreach ($select->getCols() as $col) {
            if (empty($cols[$col])) {
                continue;
            }

            $buffer .= $delim . $col;

            $delim = ", ";
        }

        return $buffer;
    }

    private function buildOrderBy(Select $select) {
        if ($select->getOrderBy() === null) {
            return "";
        }

        return " ORDER BY " . $select->getOrderBy();
    }

    private function buildLimit(Select $select) {
        if ($select->getOffset() === null) {
            return "";
        }

        return " LIMIT " . $select->getOffset() . ", " . $select->getRowCount();
    }

    public function build($value) {
        if (!($value instanceof Select)) {
            throw new \BadMethodCallException("Supply a Select value.");
        }

        return sprintf("SELECT %s FROM %s %s %s %s",
            $this->buildCols($value),
            $value->getEntity(),
            $this->builder->build($value->getWhere()),
            $this->buildOrderBy($value),
            $this->buildLimit($value));
    }
}