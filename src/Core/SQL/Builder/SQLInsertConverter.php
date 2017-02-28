<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 27/02/17
 * Time: 20:42
 */

namespace Softbox\Persistence\Core\SQL\Builder;

use Softbox\Persistence\Core\Converter;
use Softbox\Persistence\Core\SQL\Command\InsertBase;

class SQLInsertConverter implements Converter {
    private $converter;

    public function __construct(Converter $converter) {
        $this->converter = $converter;
    }

    public function convert($value) {
        if (!($value instanceof InsertBase)) {
            throw new \BadMethodCallException("Supply a instance of " . InsertBase::class . ".");
        }

        $cols = array_keys($value->getTableValues());

        $params = array_map(function($val) {
            return ":" . $val;
        }, $cols);

        return sprintf("INSERT INTO %s(%s) VALUES (%s)",
            $value->getEntity(),
            implode(", ", $cols),
            implode(", ", $params));
    }
}