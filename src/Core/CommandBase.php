<?php

namespace Softbox\Persistence\Core;

use Softbox\Persistence\Core\SQL\Command\SQLException;
use Softbox\Persistence\Core\SQL\PersistenceService;

/**
 * Base class to the commands
 *
 * @package Softbox\Persistence\Core
 */
abstract class CommandBase implements Buildable {

    /**
     * @var PersistenceService
     */
    protected $persistence;

    /**
     * @var string Name of the entity
     */
    protected $entity;

    /**
     * @var array the values
     */
    protected $values = [];

    /**
     * CommandBase constructor.
     *
     * @param PersistenceService $persistence
     * @param string $entity name of the entity where command will be executed
     */
    public function __construct(PersistenceService $persistence, $entity) {
        $this->persistence = $persistence;
        $this->entity = $entity;
        $this->checkTable();
    }

    public function build(Converter $builder) {
        return $builder->convert($this);
    }

    /**
     * @return string the name of the entity
     */
    public function getEntity() {
        return $this->entity;
    }

    /**
     * @return array with values
     */
    public function getValues() {
        return $this->values;
    }

    public function val($col, $value) {
        $this->values[$col] = $value;

        return $this;
    }

    /**
     * Check if the given table exists
     *
     * @throws SQLException
     */
    protected function checkTable() {
        if (!$this->persistence->existsTable($this->getEntity())) {
            throw new SQLException("Table '" . $this->getEntity() . "' does not exists.'");
        }
    }

    public abstract function execute();
}