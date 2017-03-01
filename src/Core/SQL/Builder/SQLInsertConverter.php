<?php

namespace Softbox\Persistence\Core\SQL\Builder;

use BadMethodCallException;
use Softbox\Persistence\Core\Converter;
use Softbox\Persistence\Core\InsertBase;

class SQLInsertConverter implements Converter
{
    /**
     * @var Converter
     */
    private $converter;

    /**
     * SQLInsertConverter constructor.
     *
     * @param Converter $converter
     */
    public function __construct(Converter $converter)
    {
        $this->converter = $converter;
    }

    public function convert($value)
    {
        if (!($value instanceof InsertBase)) {
            throw new BadMethodCallException("Supply an instance of " . InsertBase::class . ".");
        }

        $cols   = array_keys($value->getTableValues());
        $params = array_map(function ($val) {
            return ":" . $val;
        }, $cols);

        return sprintf("INSERT INTO %s(%s) VALUES (%s)",
            $value->getEntity(),
            implode(", ", $cols),
            implode(", ", $params));
    }
}
