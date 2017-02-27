<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 26/02/17
 * Time: 15:44
 */

namespace Softbox\Persistence\Core;

interface Repository {

    /**
     * @param string $entity
     *
     * @return Queryable
     */
    public function query($entity);
}