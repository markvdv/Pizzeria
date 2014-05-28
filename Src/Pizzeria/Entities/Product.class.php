<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Product
 *
 * @author mark.vanderveken
 */

namespace Pizzeria\Entities;

class Product {

    private static $idMap = array();
    private $productnaam;
    private $productomschrijving;
    private $productprijs;

    // <editor-fold defaultstate="collapsed" desc="CONSTRUCT">
    function __construct($productnaam, $productomschrijving, $productprijs) {
        $this->productnaam = $productnaam;
        $this->productomschrijving = $productomschrijving;
        $this->productprijs = $productprijs;
    }

// </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="CREATE">
    public function create($productnaam, $productomschrijving, $productprijs) {
        if (!isset(self::$idMap[$productnaam])) {
            self::$idMap[$productnaam] = new Product($productnaam, $productomschrijving, $productprijs);
        }
        return self::$idMap[$productnaam];
    }

// </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="GETTER/SETTER">
    public function getProductnaam() {
        return $this->productnaam;
    }

    public function getProductomschrijving() {
        return $this->productomschrijving;
    }

    public function getProductprijs() {
        return $this->productprijs/100;
    }


    public function setProductnaam($productnaam) {
        $this->productnaam = $productnaam;
    }

    public function setProductomschrijving($productomschrijving) {
        $this->productomschrijving = $productomschrijving;
    }

    public function setProductprijs($productprijs) {
        $this->productprijs = $productprijs;
    }


// </editor-fold>
}
