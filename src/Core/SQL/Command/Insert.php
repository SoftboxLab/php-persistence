<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 27/02/17
 * Time: 20:40
 */

namespace Softbox\Persistence\Core\SQL\Command;

use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\Builder;
use Softbox\Persistence\Core\PersistenceService;

class Insert extends \Softbox\Persistence\Core\Insert implements Buildable {
    private $pserv;

    public function __construct(PersistenceService $pserv, $entity) {
        parent::__construct($entity);

        $this->pserv = $pserv;
    }

    public function getTableValues() {
        $cols = $this->pserv->getColsOfTable($this->getEntity());

        $values = [];

        foreach ($this->getValues() as $col => $val) {
            if (in_array($col, $cols)) {
                $values[$col] = $val;
            }
        }

        return $values;
    }

    public function execute() {
        $values = $this->getTableValues();

    }
}