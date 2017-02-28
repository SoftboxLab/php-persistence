<?php

namespace Softbox\Persistence\Core;

abstract class InsertBase implements Buildable {

    /**
     * @var
     */
    private $entity;

    /**
     * @var array
     */
    private $values = [];

    /**
     * InsertBase constructor.
     * @param $entity
     */
    public function __construct($entity) {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getEntity() {
        return $this->entity;
    }

    public function val($col, $value) {
        $this->values[$col] = $value;

        return $this;
    }

    public function getValues() {
        return $this->values;
    }

    public function build(Converter $builder) {
        return $builder->convert($this);
    }

    public abstract function execute();
}
