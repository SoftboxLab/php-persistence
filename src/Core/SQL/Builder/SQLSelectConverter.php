<?php

namespace Softbox\Persistence\Core\SQL\Builder;

use Softbox\Persistence\Core\Converter;
use Softbox\Persistence\Core\Projection;

class SQLSelectConverter implements Converter {

    /**
     * @var Converter
     */
    private $converter;

    /**
     * SQLSelectConverter constructor.
     *
     * @param Converter $converter
     */
    public function __construct(Converter $converter) {
        $this->converter = $converter;
    }

    private function buildCols(Projection $select) {
        $buffer     = "";
        $delimiter  = "";
        foreach ($select->getCols() as $col) {
            $buffer .= $delimiter . $col;
            $delimiter = ", ";
        }

        return empty($buffer) ? "*" : $buffer;
    }

    private function buildOrderBy(Projection $select) {
        return empty($select->getOrderBy()) ? "" : " ORDER BY " . implode(", ", $select->getOrderBy());
    }

    private function buildLimit(Projection $select) {
        return $select->getOffset() === null ? "" : " LIMIT " . $select->getOffset() . ", " . $select->getRowCount();
    }

    private function buildWhere(Projection $select) {
        return $select->getFilter() === null ? "" : $this->converter->convert($select->getFilter());
    }

    public function convert($value) {
        if (!($value instanceof Projection)) {
            throw new SQLConverterException("Supply an instance of " . Projection::class . ".");
        }

        return sprintf("SELECT %s FROM %s%s%s%s",
            $this->buildCols($value),
            $value->getEntity(),
            $this->buildWhere($value),
            $this->buildOrderBy($value),
            $this->buildLimit($value));
    }
}