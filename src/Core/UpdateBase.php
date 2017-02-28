<?php

namespace Softbox\Persistence\Core;

use Softbox\Persistence\Core\Command\Updatable;

/**
 * Base class to the update command
 *
 * @package Softbox\Persistence\Core
 */
abstract class UpdateBase implements Buildable, Updatable {

    /**
     * @var string Name of the entity that will be updated.
     */
    private $entity;

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

    /**
     * UpdateBase constructor.
     * @param $entity
     */
    public function __construct($entity) {
        $this->entity = $entity;
    }

    public function setFilter(Filter $filter) {
        $this->filter = $filter;

        return $this;
    }

    public function getEntity() {
        return $this->entity;
    }

    public function getFilter() {
        return $this->filter;
    }

    public function getRowCount() {
        return $this->rowCount;
    }

    public function getValues() {
        return $this->values;
    }

    public function limit($rowCount) {
        $this->rowCount = $rowCount;

        return $this;
    }

    public function filter(Filter $filter) {
        $this->setFilter($filter);

        return $this;
    }

    public function val($col, $value) {
        $this->values[$col] = $value;

        return $this;
    }

    public function build(Converter $builder) {
        return $builder->convert($this);
    }

    public abstract function execute();
}
