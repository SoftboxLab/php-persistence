<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 25/02/17
 * Time: 16:25
 */

namespace Softbox\Persistence\Core;

class RepositoryBase implements Repository {


    public function __construct() {
    }

    /**
     * @param $entity
     *
     * @return Queryable
     */
    public function query($entity) {
        return new QueryBuilder();
    }
}