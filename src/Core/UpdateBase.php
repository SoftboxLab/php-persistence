<?php

namespace Softbox\Persistence\Core;

/**
 * Classe base para o compando de update de dados.
 *
 * @package Softbox\Persistence\Core
 */
abstract class UpdateBase implements Buildable, Updatable {

    /**
     * Nome da entidade que sera atualizada.
     * @var string
     */
    private $entity;

    /**
     * Condicao de filtro.
     * @var Filter
     */
    private $filter = null;

    /**
     * Quantidade maxima de registros a serem atualizados.
     * @var int
     */
    private $rowCount = null;

    /**
     * Novos valores.
     * @var array
     */
    private $values = [];

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
