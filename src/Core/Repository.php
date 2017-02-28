<?php

namespace Softbox\Persistence\Core;

use Softbox\Persistence\Core\Command\Insertable;
use Softbox\Persistence\Core\Command\Queryable;
use Softbox\Persistence\Core\Command\Updatable;

/**
 * Interface that represents the repository available commands
 *
 * @package Softbox\Persistence\Core
 */
interface Repository {

    /**
     * Returns a search command to the given entity
     *
     * @param string $entity name of the entity to be searched
     *
     * @return Queryable
     */
    public function query($entity);

    /**
     * Returns an insert command to the given entity
     *
     * @param string $entity name of the entity to be inserted
     *
     * @return Insertable
     */
    public function insert($entity);

    /**
     * Returns an update command to the given entity
     *
     * @param string $entity name of the entity to be updated
     *
     * @return Updatable
     */
    public function update($entity);
}
