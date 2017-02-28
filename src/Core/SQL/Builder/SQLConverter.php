<?php

namespace Softbox\Persistence\Core\SQL\Builder;

use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\Converter;
use Softbox\Persistence\Core\Condition;
use Softbox\Persistence\Core\Filter;
use Softbox\Persistence\Core\InsertBase;
use Softbox\Persistence\Core\SQL\Command\SQLSelect;

/**
 * Construtor base de comandos SQL, responsavel por identificar e delega a construcao do componente SQL correto.
 *
 * @package Softbox\Persistence\Core\SQL\Builder
 */
class SQLConverter implements Converter {

    /**
     * Construtores de comando SQL.
     *
     * @var Converter[]
     */
    private $converters = [];

    public function __construct() {
        $this->converters = [
            Filter::class     => new SQLWhereConverter($this),
            Condition::class  => new SQLConditionConverter($this),
            SQLSelect::class  => new SQLSelectConverter($this),
            InsertBase::class => new SQLInsertConverter($this)
        ];
    }

    /**
     * Realiza o processo de build do comando SQL para o valor fornecido.
     *
     * @param mixed $value
     *
     * @return string O valor fornecido em um representacao em SQL.
     */
    public function convert($value) {
        if ($value === null) {
            return "NULL";
        }

        if ($value instanceof Buildable) {
            $className = get_class($value);

            if (isset($this->converters[$className])) {
                return $this->converters[$className]->convert($value);
            }
        }

        return strval($value);
    }
}