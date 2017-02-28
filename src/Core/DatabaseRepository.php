<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 25/02/17
 * Time: 16:25
 */

namespace Softbox\Persistence\Core;

use Softbox\Persistence\Core\SQL\Command\Select;

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
        return new Select($this->pserv, $entity);
    }

    public function insert($entity) {
        return new Insert($this->pserv, $entity);
    }
}