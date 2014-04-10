<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductDAO
 *
 * @author mark.vanderveken
 */

namespace Pizzeria\Data;

use Pizzeria\Entities\Product;

class ProductDAO extends DAO {
private $args=array();
    /**
     * 
     * @return array: array gevuld met de productobjecten
     */
    public static function getAll() {
        $sql = "SELECT * FROM product";
        $stmt = parent::execPreppedStmt($sql);
        $resultSet = $stmt->fetchall();
        $arr = array();
        foreach ($resultSet as $result) {
            $product = Product::create($result['productid'], $result['productnaam'], $result['productomschrijving'], $result['productprijs']);
            $arr[] = $product;
        }
        return $arr;
    }
/**
 * 
 * @param integer $id: id van het zoeken product
 * @return object: object met data van product
 */
    public static function getById($id) {
        $sql = "SELECT * FROM product where id=?";
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $result = $stmt->fetch();
        $product = Product::create($result['productid'], $result['productnaam'], $result['productomschrijving'], $result['productprijs']);
        return $product;
    }
/**
 * 
 * @param integer $id: id van het te verwijderen product
 */
    public static function delete($id) {
        $sql = "DELETE FROM product where id=?";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
    }
/**
 * 
 * @param string $productnaam: naam van het nieuwe product
 * @param string $productomschrijving:omschrijving van het nieuwe product
 * @param integer $productprijs:prijs van het nieuwe product
 * @param integer $bestelregelid:bestelregelid (default NULL)
 */
    public static function insert($productnaam, $productomschrijving, $productprijs) {
        $sql = "INSERT INTO product (productnaam,productomschrijving,productprijs) VALUES(?,?,?,?)";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
    }
/**
 * 
 * @param object $product: product object met de data om up te daten 
 */
    public static function update($product) {
        $sql = "UPDATE product SET productnaam=?,productomschrijving=?,productprijs=? WHERE id=?";
        $args[] = $product->getProductnaam();
        $args[] = $product->getProductomschrijving();
        $args[] = $product->getProductprijs();
        $args[] = $product->getBestelregelid();
        parent::execPreppedStmt($sql, $args);
    }

}
