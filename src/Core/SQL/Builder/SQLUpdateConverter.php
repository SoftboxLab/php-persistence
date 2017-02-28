<?php

namespace Softbox\Persistence\Core\SQL\Builder;

use Softbox\Persistence\Core\Converter;
use Softbox\Persistence\Core\SQL\Command\SQLUpdate;

/**
 * Classe responsavel pela montagem do comando SQL de UPDATE.
 *
 * @package Softbox\Persistence\Core\SQL\Builder
 */
class SQLUpdateConverter implements Converter {

    /**
     * @var Converter
     */
    private $converter;

    public function __construct(Converter $converter) {
        $this->converter = $converter;
    }

    private function buildWhere(Projection $select) {
        if ($select->getFilter() === null) {
            return "";
        }
        return $this->converter->convert($select->getFilter());
    }

    public function convert($value) {
        if (!($value instanceof SQLUpdate)) {
            throw new SQLConverterException("Supply a instance of " . SQLUpdate::class . ".");
        }

        $cols = array_keys($value->getTableValues());

        $params = array_map(function($val) {
            return ":" . $val;
        }, $cols);

        return sprintf("UPDATE %s SET %s%s",
            $value->getEntity(),
            implode(", ", $params),
            $this->buildWhere($value->getFilter()));
    }
}