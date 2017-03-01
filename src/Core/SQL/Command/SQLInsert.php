<?php

namespace Softbox\Persistence\Core\SQL\Command;

use Softbox\Persistence\Core\InsertBase;
use Softbox\Persistence\Core\SQL\Builder\SQLConverter;

/**
 * Class that represents the SQL INSERT command.
 */
class SQLInsert extends InsertBase
{
    /**
     * Returns an array with the possible values to be inserted.
     *
     * @return array [[Key => Value] ...]
     */
    public function getTableValues()
    {
        $cols   = $this->persistence->getColsOfTable($this->getEntity());
        $values = [];
        foreach ($this->getValues() as $col => $val) {
            if (in_array($col, $cols)) {
                $values[$col] = $val;
            }
        }

        return $values;
    }

    public function execute()
    {
        $values = $this->getTableValues();
        if (empty($values)) {
            throw new SQLException("There are no values to be inserted.");
        }
        $sql = $this->build(new SQLConverter());

        return $this->persistence->exec($sql, $values);
    }
}
