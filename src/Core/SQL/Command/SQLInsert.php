<?php

namespace Softbox\Persistence\Core\SQL\Command;

use Softbox\Persistence\Core\InsertBase;
use Softbox\Persistence\Core\SQL\PersistenceService;
use Softbox\Persistence\Core\SQL\Builder\SQLConverter;

/**
 * Class that represents the SQL INSERT command
 *
 * @package Softbox\Persistence\Core\SQL\Command
 */
class SQLInsert extends InsertBase {

    /**
     * SQLInsert constructor.
     *
     * @param PersistenceService $persistence
     * @param $entity
     */
    public function __construct(PersistenceService $persistence, $entity) {
        parent::__construct($persistence, $entity);
    }

    /**
     * Returns an array with the possible values to be inserted
     *
     * @return array [[Key => Value] ...]
     */
    public function getTableValues() {
        $cols = $this->persistence->getColsOfTable($this->getEntity());
        $values = [];
        foreach ($this->getValues() as $col => $val) {
            if (in_array($col, $cols)) {
                $values[$col] = $val;
            }
        }

        return $values;
    }

    public function execute() {
        $values = $this->getTableValues();
        if (empty($values)) {
            throw new SQLException("There are no values to be inserted.");
        }
        $sql = $this->build(new SQLConverter());

        return $this->persistence->exec($sql, $values);
    }
}
