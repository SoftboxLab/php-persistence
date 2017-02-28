<?php

namespace Softbox\Persistence\Core\SQL\Builder;

use Softbox\Persistence\Core\Converter;
use Softbox\Persistence\Core\Projection;

class SQLSelectConverter implements Converter {
    private $converter;

    public function __construct(Converter $converter) {
        $this->converter = $converter;
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
        return $this->converter->convert($select->getFilter());
    }

    public function convert($value) {
        if (!($value instanceof Projection)) {
            throw new SQLConverterException("Supply a instance of " . Projection::class . ".");
        }

        return sprintf("SELECT %s FROM %s%s%s%s",
            $this->buildCols($value),
            $value->getEntity(),
            $this->buildWhere($value),
            $this->buildOrderBy($value),
            $this->buildLimit($value));
    }
}