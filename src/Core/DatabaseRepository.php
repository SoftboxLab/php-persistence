<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 25/02/17
 * Time: 16:25
 */

namespace Softbox\Persistence\Core;

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
        return new SQLSelectBuilder($this->pserv, $entity);
    }
}