<?php

namespace Softbox\Persistence\Core\SQL\Command;

use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\InsertBase;
use Softbox\Persistence\Core\SQL\PersistenceService;
use Softbox\Persistence\Core\SQL\Builder\SQLConverter;

/**
 * Class that represents the SQL INSERT command
 *
 * @package Softbox\Persistence\Core\SQL\Command
 */
class SQLInsert extends InsertBase implements Buildable {

    /**
     * @var PersistenceService
     */
    private $persistence;

    /**
     * SQLInsert constructor.
     *
     * @param PersistenceService $persistence
     * @param $entity
     */
    public function __construct(PersistenceService $persistence, $entity) {
        parent::__construct($entity);
        $this->persistence = $persistence;
        $this->checkTable();
    }

    /**
     * Check if the given table exists.
     *
     * @throws SQLException
     */
    private function checkTable() {
        if (!$this->persistence->existsTable($this->getEntity())) {
            throw new SQLException("Table '" . $this->getEntity() . "' does not exists.'");
        }
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
