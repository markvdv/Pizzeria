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

class BestelregelDAO extends DAO {

    public static function getAll() {
        $sql = "SELECT * FROM bestelregel inner join product on bestelregel.productnaam= product.productnaam";
       parent::execPreppedStmt($sql);
        $resultSet =parent::$stmt->fetchall(\PDO::FETCH_ASSOC);
        $arr = array();
        foreach ($resultSet as $result) {
            $product= Product::create($result['productnaam'],$result['productomschrijving'],$result['productprijs']);
            $bestelregel = Bestelregel::create($result['bestelregelid'],  $product,$result['bestellingid']);
            $arr[] = $bestelregel;
        }
        return $arr;
    }

    public static function insert($bestellingid, $productnaam) {
        $sql = "INSERT INTO bestelregel (bestellingid,productnaam) VALUES (?,?)";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
    }

}
