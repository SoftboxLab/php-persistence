<?php

namespace Softbox\Persistence\Core\SQL\Command;

use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\SQL\Builder\SQLConverter;
use Softbox\Persistence\Core\SQL\PersistenceService;
use Softbox\Persistence\Core\UpdateBase;

/**
 * Class that represents the UPDATE SQL command
 *
 * @package Softbox\Persistence\Core\SQL\Command
 */
class SQLUpdate extends UpdateBase implements Buildable {

    /**
     * @var PersistenceService
     */
    private $persistence;

    /**
     * SQLUpdate constructor.
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
     * Check if the given table exists
     *
     * @throws SQLException
     */
    private function checkTable() {
        if (!$this->persistence->existsTable($this->getEntity())) {
            throw new SQLException("Table '" . $this->getEntity() . "' does not exists.'");
        }
    }

    private function getParams() {
        /** @var \Softbox\Persistence\Core\Filter $filter */
        $filter = $this->getFilter();

        return $filter ? $filter->getParams() : [];
    }

    /**
     * Return only the values that exists on table
     *
     * @return array [[Col => New Value] .. ]
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
            throw new SQLException("There are no values to be updated.");
        }
        $sql = $this->build(new SQLConverter());

        return $this->persistence->exec($sql, array_merge($values, $this->getParams()));
    }
}
