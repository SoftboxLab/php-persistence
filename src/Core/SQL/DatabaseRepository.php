<?php

namespace Softbox\Persistence\Core\SQL;

use Softbox\Persistence\Core\Repository;
use Softbox\Persistence\Core\SQL\Command\SQLInsert;
use Softbox\Persistence\Core\SQL\Command\SQLSelect;
use Softbox\Persistence\Core\SQL\Command\SQLUpdate;

/**
 * Implements a repository of database access
 *
 * @package Softbox\Persistence\Core
 */
class DatabaseRepository implements Repository {

    /**
     * @var PersistenceService
     */
    private $persistence;

    /**
     * DatabaseRepository constructor
     */
    public function __construct() {
        $this->persistence = new PersistenceService();
    }

    /**
     * Returns a SQL SELECT command
     *
     * @param string $entity the table name
     *
     * @return SQLSelect
     */
    public function query($entity) {
        return new SQLSelect($this->persistence, $entity);
    }

    public function namedQuery($name) {

    }

    /**
     * Returns a SQL INSERT command
     *
     * @param string $entity the table name
     *
     * @return SQLInsert
     */
    public function insert($entity) {
        return new SQLInsert($this->persistence, $entity);
    }

    /**
     * Returns a SQL UPDATE command
     *
     * @param string $entity the table name
     *
     * @return SQLUpdate
     */
    public function update($entity) {
        return new SQLUpdate($this->persistence, $entity);
    }
}
