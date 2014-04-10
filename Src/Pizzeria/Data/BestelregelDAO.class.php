<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BestelregelDAO
 *
 * @author Mark.Vanderveken
 */

namespace Pizzeria\Data;

use Pizzeria\Entities\Bestelregel;
use Pizzeria\Entities\Product;
use Pizzeria\Entities\Postcode;
use Pizzeria\Entities\Bestelling;

class BestelregelDAO extends DAO {

    public static function getAll() {
        $sql = "SELECT * FROM bestelregel";
        $stmt = parent::execPreppedStmt($sql);
        $resultSet = $stmt->fetchall(\PDO::FETCH_ASSOC);
        $stmt = null;
        $arr = array();
        foreach ($resultSet as $result) {
            $bestelregel = Bestelregel::create($result['bestelregelid'], $result['bestellingid'], $result['productid']);
            $arr[] = $bestelregel;
        }
        return $arr;
    }

    public static function insert($bestellingid, $productid) {
        $sql = "INSERT INTO bestelregel (bestellingid,productid) VALUES (?,?)";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
    }

}
