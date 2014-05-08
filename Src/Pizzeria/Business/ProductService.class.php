<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductService
 *
 * @author mark.vanderveken
 */
namespace Pizzeria\Business;
use Pizzeria\Data\ProductDAO;
class ProductService {
    public static function toonProducten() {
        $productenlijst=ProductDAO::getAll();
        return $productenlijst;
    }
    public static function zoekProductOpNaam($productnaam) {
        $product= ProductDAO::getByName($productnaam);
        return $product;
    }
}
