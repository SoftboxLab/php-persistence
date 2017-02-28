<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 27/02/17
 * Time: 20:40
 */

namespace Softbox\Persistence\Core;


abstract class InsertBase implements Buildable {
    private $entity;

    private $values = [];

    public function __construct($entity) {
        $this->entity = $entity;
    }

    public function build(Converter $builder) {
        return $builder->convert($this);
    }

    /**
     * @return mixed
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

    public abstract function execute();
}
