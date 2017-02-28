<?php

namespace Softbox\Persistence\Core;

use Softbox\Persistence\Core\SQL\Command\SQLSelect;

class DatabaseRepository implements Repository {

    /**
     * @var PersistenceService
     */
    private $pserv;

    public function __construct() {
        $this->pserv = new PersistenceService();
    }

    /**
     * @param $entity
     *
     * @return Queryable
     */
    public function query($entity) {
        return new SQLSelect($this->pserv, $entity);
    }

    public function insert($entity) {
        return new Insert($this->pserv, $entity);
    }
}