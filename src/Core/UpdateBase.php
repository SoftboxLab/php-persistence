<?php

namespace Softbox\Persistence\Core;

use Softbox\Persistence\Core\Command\Updatable;

/**
 * Base class to the update command
 *
 * @package Softbox\Persistence\Core
 */
abstract class UpdateBase extends CommandBase implements Updatable {

    /**
     * @var Filter The filter condition
     */
    private $filter = null;

    /**
     * @var int Max number of rows that will be updated
     */
    private $rowCount = null;

    /**
     * @var array new values
     */
    private $values = [];

    public function setFilter(Filter $filter) {
        $this->filter = $filter;

        return $this;
    }
    /**
     * @return \Softbox\Persistence\Core\Filter
     */
    public function getFilter() {
        return $this->filter;
    }

    public function getRowCount() {
        return $this->rowCount;
    }

    public function limit($rowCount) {
        $this->rowCount = $rowCount;

        return $this;
    }

    public function filter(Filter $filter) {
        $this->setFilter($filter);

        return $this;
    }
}
