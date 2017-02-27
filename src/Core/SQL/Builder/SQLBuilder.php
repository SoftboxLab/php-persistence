<?php

namespace Softbox\Persistence\Core\SQL\Builder;



use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\Builder;
use Softbox\Persistence\Core\Condition;
use Softbox\Persistence\Core\Filter;
use Softbox\Persistence\Core\SQL\Command\Select;

class SQLBuilder implements Builder {

    private $builders = [];

    public function __construct() {
        $this->builders = [
            Filter::class    => new SQLWhereBuilder($this),
            Condition::class => new SQLConditionBuilder($this),
            Select::class    => new SQLSelectBuilder($this),
        ];
    }

    public function build($value) {
        if ($value === null) {
            return "NULL";

        } else if ($value instanceof Buildable) {
            $className = get_class($value);

            //echo "\n" . $className;

            if (isset($this->builders[$className])) {
                return $this->builders[$className]->build($value);
            }
        }

        return strval($value);
    }
}