<?php

namespace Softbox\Persistence\Core\SQL;

use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\Builder;

class SQLBuilder implements Builder {

    private $builders = [];

    public function __construct() {
        $this->builders = [
            'Softbox\Persistence\Core\Where'     => new SQLWhereBuilder($this),
            'Softbox\Persistence\Core\Condition' => new SQLConditionBuilder($this),
            'Softbox\Persistence\Core\Select'    => new SQLSelectBuilder($this),
        ];
    }

    public function build($value) {
        if ($value === null) {
            return "NULL";

        } else if ($value instanceof Buildable) {
            $className = get_class($value);

            if (isset($this->builders[$className])) {
                return $this->builders[$className]->build($value);
            }
        }

        return strval($value);
    }
}