<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 26/02/17
 * Time: 10:41
 */

namespace Softbox\Persistence\Core;

class PersistenceService {

    public function __construct() {
    }

    public function query($sql, $params = []) {
        return [];
    }

    public function getColsOfTable($tableName) {
        return array_keys($this->getMetaData($tableName));
    }

    public function getMetaData($table) {
        return [
            "a" => [
                "size" => 10,
                "type" => "int"
            ],

            "b" => [
                "size" => 10,
                "type" => "varchar"
            ],

            "c" => [
                "size" => 10,
                "type" => "varchar"
            ]
        ];
    }

    public function existsTable($tableName) {
        return $tableName == 'teste';
    }

    public function exec($sql, $values = []) {
        return $values;
    }
}